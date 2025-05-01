<?php

namespace App\Http\Controllers;

use App\Models\Certification;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    use ApiResponse;
    public function getCertification($id){

        $certification = Certification::find($id);
        if (!$certification) {
            return $this->errorResponse('No certification found.', 404);
        }

        return $this->successResponse($certification, 'Certification fetched successfully.');
    }
}
