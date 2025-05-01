<?php

namespace App\Http\Controllers\Dashboard;

use App\Models\Syllabi;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSyllabiRequest;
use App\Http\Requests\UpdateSyllabiRequest;
use App\Http\Resources\Dashboard\SyllabiResource;

class SyllabusController extends Controller
{
    use ApiResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $syllabi = Syllabi::withCount('lessons')->get();
        return $this->successResponse([
            'syllabi' => SyllabiResource::collection($syllabi),
        ],'Syllabi retrieved successfully');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSyllabiRequest $request)
    {
        $syllabi = Syllabi::create($request->validated());
        return $this->successResponse(null,'Syllabi created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $syllabi = Syllabi::findOrFail($id);
        return $this->successResponse([
            'syllabi' => new SyllabiResource($syllabi),
        ],'Syllabi retrieved successfully');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSyllabiRequest $request, string $id)
    {
        $syllabi = Syllabi::findOrFail($id);
        $syllabi->update($request->validated());
        return $this->successResponse(null,'Syllabi updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $syllabi = Syllabi::findOrFail($id);
        $syllabi->delete();
        return $this->successResponse(null,'Syllabi deleted successfully');
    }
}
