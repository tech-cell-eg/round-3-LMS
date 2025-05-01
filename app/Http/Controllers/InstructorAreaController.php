<?php

namespace App\Http\Controllers;

use App\Http\Requests\Instructors\StoreInstructorAreaRequest;
use App\Http\Requests\Instructors\UpdateInstructorAreaRequest;
use App\Http\Resources\InstructorAreaResource;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstructorAreaController extends Controller
{
    use ApiResponse;

    public function index()
    {
        $instructor = Auth::user()->instructor;

        if (! $instructor) {
            return $this->errorResponse('Instructor not found.', 404);
        }

        return $this->successResponse(
            $instructor->areas()->get('area'),
            'Instructor areas fetched successfully'
        );
    }

    public function store(StoreInstructorAreaRequest $request)
    {
        $instructor = Auth::user()->instructor;

        if (! $instructor) {
            return $this->errorResponse('Instructor not found.', 404);
        }

        $instructor->areas()->create([
            'area' => $request->validated('area'),
        ]);

        $areas = InstructorAreaResource::collection($instructor->areas()->get());

        return $this->successResponse(
            $areas,
            'Instructor area created successfully',
            201
        );
    }

    public function update(UpdateInstructorAreaRequest $request, $id)
    {
        $instructor = Auth::user()->instructor;

        if (! $instructor) {
            return $this->errorResponse('Instructor not found.', 404);
        }

        $area = $instructor->areas()->where('id', $id)->first();

        if (! $area) {
            return $this->errorResponse('Area not found.', 404);
        }

        $area->update([
            'area' => $request->validated('area'),
        ]);

        $areas = InstructorAreaResource::collection($instructor->areas()->get());

        return $this->successResponse(
            $areas,
            'Instructor area updated successfully',
            200
        );
    }

    public function destroy($id)
    {
        $instructor = Auth::user()->instructor;

        if (!$instructor) {
            return $this->errorResponse('Instructor not found.', 404);
        }

        $instructor->areas()->where('id', $id)->delete();

        return $this->successResponse(
            null,
            'Instructor area deleted successfully',
            200
        );
    }
}
