<?php
namespace App\Http\Controllers;

use App\Http\Requests\CourseRequests\StoreCourseRequest;
use App\Http\Resources\CourseIndexResource;
use App\Http\Resources\PaginationResource;
use App\Models\Course;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    use ApiResponse;
    public function index(Request $request)
    {
        try {
            $validated = $request->validate([
                'per_page'    => 'nullable|integer',
                'sort_by'     => 'nullable|string|in:newest,highest_rating,most_enrolled',
                'category_id' => 'nullable|integer|exists:categories,id',
                'rating'      => 'nullable|numeric|between:0,5',
                'min_section' => 'nullable|integer|min:1',
                'max_section' => 'nullable|integer|gte:min_section',
                'min_price'   => 'nullable|numeric|min:0',
                'max_price'   => 'nullable|numeric|gte:min_price',
                'search'      => 'nullable|string',
            ]);

            $query = Course::with(['category', 'instructor', 'syllabi.lessons', 'reviews', 'enrollments', 'image']);

            if (! empty($validated['category_id'])) {
                $query->where('category_id', $validated['category_id']);
            }

             if (! empty($validated['sort_by'])) {
                if ($validated['sort_by'] === 'newest') {
                    $query->latest();
                } elseif ($validated['sort_by'] === 'highest_rating') {
                    $query->withAvg('reviews', 'rating')->orderByDesc('reviews_avg_rating');
                } elseif ($validated['sort_by'] === 'most_enrolled') {
                    $query->withCount('enrollments')->orderByDesc('enrollments_count');
                }
            }

            if (! empty($validated['min_section'])) {
                $query->where('section', '>=', $validated['min_section']);
            }
            if (! empty($validated['max_section'])) {
                $query->where('section', '<=', $validated['max_section']);
            }
            if (! empty($validated['rating'])) {
                $query->whereHas('reviews', function ($q) use ($validated) {
                    $q->where('rating', '>=', $validated['rating']);
                });
            }

            if (! empty($validated['min_price'])) {
                $query->where('price', '>=', $validated['min_price']);
            }
            if (! empty($validated['max_price'])) {
                $query->where('price', '<=', $validated['max_price']);
            }

            if (! empty($validated['search'])) {
                $query->where('title', 'like', '%' . $validated['search'] . '%');
            }

            $courses = $query->paginate($validated['per_page'] ?? 10);

            if ($courses->isEmpty()) {
                return $this->errorResponse('No courses found', 404);
            }

            return $this->successResponse([
                'courses'    => CourseIndexResource::collection($courses),
                'pagination' => new PaginationResource($courses),
            ], 'Courses retrieved successfully');

        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve courses', 500);
        }
    }

    public function show($id)
    {
        try {
            $course = Course::with(['category', 'instructor', 'syllabi.lessons', 'reviews', 'enrollments', 'image', 'favorites'])->find($id);

            if (! $course) {
                return $this->errorResponse('Course not found', 404);
            }

            return $this->successResponse([
                'course' => new CourseIndexResource($course),
            ], 'Course retrieved successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Failed to retrieve course', 500);
        }
    }

    public function store(StoreCourseRequest $request)
    {
        $user      = Auth::user();
        $validated = $request->validated();
        try {
            DB::beginTransaction();
            $imagePath = null;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name  = uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/courses'), $name);

                $imagePath = 'uploads/courses/' . $name;
            }

            $course = Course::create([
                'title'         => $validated['title'],
                'category_id'   => $validated['category_id'],
                'instructor_id' => $user->id,
                'price'         => $validated['price'],
                'duration'      => $validated['duration'],
                'level'         => $validated['level'],
                'description'   => $validated['description'],
                'video_url'     => $validated['video_url'],
                'sale'          => $validated['sale'],
                'language'      => $validated['language'],
                'certificate'   => $validated['certificate'],
            ]);
            if (isset($imagePath)) {
                $user->avatar()->create([
                    'path' => $imagePath,
                ]);
            }

            foreach ($validated['syllabi'] as $syllabusData) {
                $syllabus = $course->syllabi()->create($syllabusData);

                if (isset($syllabusData['lessons'])) {
                    foreach ($syllabusData['lessons'] as $lessonData) {
                        $syllabus->lessons()->create($lessonData);
                    }
                }
            }

            if ($request->has('lessons')) {
                foreach ($validated['lessons'] as $lessonData) {
                    $course->syllabi()->first()->lessons()->create($lessonData);
                }
            }
            DB::commit();
            return $this->successResponse(null, 'Course created successfully', 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->errorResponse('Failed to create course', 500);
        }
    }
}
