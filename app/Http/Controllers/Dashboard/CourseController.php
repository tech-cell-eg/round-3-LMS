<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Course;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PaginationResource;
use App\Http\Requests\DashStoreCourseRequest;
use App\Http\Requests\DashUpdateCourseRequest;
use App\Http\Resources\Dashboard\CourseShowResource;
use App\Http\Resources\Dashboard\CourseIndexResource;

class CourseController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::withCount(['students', 'reviews', 'syllabi','favorites','enrollments'])
        ->where('instructor_id', Auth::user()->id)
            ->latest()
            ->paginate(10);

        return $this->successResponse([
            'courses' => CourseIndexResource::collection($courses),
            'pagination' => new PaginationResource($courses)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DashStoreCourseRequest $request)
    {
        $image = $request->file('image')->store('courses', 'public');
        $course = Course::create($request->validated()+ [
            'instructor_id' => Auth::id(),
        ]);
        $course->image->path = $image;
        return $this->successResponse([
            'course' => new CourseShowResource($course)
        ], 'Course created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = Course::findOrFail($id);

        return $this->successResponse([
            'course' => new CourseShowResource($course)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DashUpdateCourseRequest $request, string $id)
    {
        $course = Course::findOrFail($id);
        $course->update($request->validated());

        if($request->hasFile('image')) {
            $image = $request->file('image')->store('courses', 'public');
            if ($course->image) {
                Storage::disk('public')->delete($course->image);
            }
            $course->image->path = $image;
            $course->image->save();
        }

        return $this->successResponse([
            'course' => new CourseShowResource($course)
        ], 'Course updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);
        if ($course->image) {
            Storage::disk('public')->delete($course->image);
        }
        $course->delete();

        return $this->successResponse(null, 'Course deleted successfully');
    }
}
