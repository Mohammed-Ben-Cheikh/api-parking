<?php

namespace App\Http\Controllers;

use App\Models\Region;
use App\Http\Requests\StoreRegionRequest;
use App\Traits\HttpResponses;

class RegionController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $regions = Region::all();
        return $this->success([
            'regions'  => $regions
        ], 'Regions retrieved successfully', 201);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRegionRequest $request)
    {
        try {
            $validated = $request->all();

            $region = Region::create([
                "name" => $validated["name"],
                "description" => $validated["description"],
                "status" => $validated["status"],
            ]);

            return $this->success([
                'region'  => $region
            ], 'region registered successfully', 201);
        } catch (\Exception $e) {
            return $this->error(null, 'region registration failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $region = Region::find($id);
        if (!$region) {
            return $this->error(null, 'Region not found', 404);
        }
        return $this->success([
            'region'  => $region
        ], 'Region retrieved successfully', 201);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(StoreRegionRequest $request,$id)
    {
        try {
            $validated = $request->all();
            $region = Region::find($id);
            $region->update([
                "name" => $validated["name"],
                "description" => $validated["description"],
                "status" => $validated["status"],
            ]);

            return $this->success([
                'region'  => $region
            ], 'region updated successfully', 201);
        } catch (\Exception $e) {
            return $this->error(null, 'region update failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $region = Region::find($id);
            $region->delete();
            return $this->success([
                'region'  => $region
            ], 'region deleted successfully', 201);
        } catch (\Exception $e) {
            return $this->error(null, 'region delete failed: ' . $e->getMessage(), 500);
        }
    }
}
