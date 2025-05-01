<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Lesson;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Http\Resources\Dashboard\LessonResource;

class LessonController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lessons = Lesson::latest()->paginate(10);
        return $this->successResponse([
            'lessons' => LessonResource::collection($lessons),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLessonRequest $request)
    {
        $lesson = Lesson::create($request->validated());
        return $this->successResponse([
            'lesson' => new LessonResource($lesson),
        ], 'Lesson created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $lesson = Lesson::findOrFail($id);
        return $this->successResponse([
            'lesson' => new LessonResource($lesson),
        ], 'Lesson retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLessonRequest $request, string $id)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->update($request->validated());
        return $this->successResponse([
            'lesson' => new LessonResource($lesson),
        ], 'Lesson updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $lesson = Lesson::findOrFail($id);
        $lesson->delete();
        return $this->successResponse(null, 'Lesson deleted successfully');
    }
}
