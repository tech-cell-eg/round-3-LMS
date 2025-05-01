<?php

namespace App\Http\Controllers;

use App\Http\Resources\CertificationResource;
use App\Models\Certification;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    use ApiResponse;
    public function getCertification($id)
    {
        $certification = Certification::with([
            'user',
            'course.instructor.user' // This ensures all needed relationships are loaded
        ])->find($id);

        if (!$certification) {
            return $this->errorResponse('No certification found.', 404);
        }

        return $this->successResponse(new CertificationResource($certification), 'Certification fetched successfully.');
    }
}
