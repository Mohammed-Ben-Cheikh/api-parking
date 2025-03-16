<?php

namespace App\Http\Controllers;

use App\Models\Parking;
use App\Traits\HttpResponses;
use App\Http\Requests\StoreParkingRequest;
class ParkingController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Parkings = Parking::all();
        return $this->success([
            'Parkings'  => $Parkings
        ], 'Parkings retrieved successfully', 201);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreParkingRequest $request)
    {
        try {
            $validated = $request->all();

            $Parking = Parking::create([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'address' => $validated['address'],
                'total_position' => $validated['total_position'],
                'status' => $validated['status'],
                'region_id' => $validated['region_id']
            ]);                                                                                                                                                            

            return $this->success([
                'Parking'  => $Parking
            ], 'Parking registered successfully', 201);
        } catch (\Exception $e) {
            return $this->error(null, 'Parking registration failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $Parking = Parking::find($id);
        if (!$Parking) {
            return $this->error(null, 'Parking not found', 404);
        }
        return $this->success([
            'Parking'  => $Parking
        ], 'Parking retrieved successfully', 201);
    }

    public function showByRegion($id)
    {   
        $Parkings = Parking::where('region_id','=',$id);
        if (!$Parkings) {
            return $this->error(null, 'Parkings not found', 404);
        }
        return $this->success([
            'Parkings'  => $Parkings
        ], 'Parkings retrieved successfully', 201);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(StoreParkingRequest $request,$id)
    {
        try {
            $Parking = Parking::find($id);
            $validated = $request->all();
            $Parking->update([
                'name' => $validated['name'],
                'description' => $validated['description'],
                'address' => $validated['address'],
                'total_position' => $validated['total_position'],
                'status' => $validated['status'],
                'region_id' => $validated['region_id']
            ]);
            return $this->success([
                'Parking'  => $Parking
            ], 'Parking updated successfully', 201);
        } catch (\Exception $e) {
            return $this->error(null, 'Parking update failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $Parking = Parking::find($id);
            if (!$Parking) {
                return $this->error(null, 'Parking not found', 404);
            }
            $Parking->delete();
            return $this->success([
                'Parking'  => $Parking
            ], 'Parking deleted successfully', 201);
        } catch (\Exception $e) {
            return $this->error(null, 'Parking delete failed: ' . $e->getMessage(), 500);
        }
    }
}
