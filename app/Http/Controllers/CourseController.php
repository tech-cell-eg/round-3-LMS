<?php
namespace App\Http\Controllers;

use App\Http\Requests\CourseRequests\StoreCourseRequest;
use App\Models\Course;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    use ApiResponse;
    public function index()
    {
        // Logic to get all courses
    }

    public function show($id)
    {
        // Logic to get a specific course by ID
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
