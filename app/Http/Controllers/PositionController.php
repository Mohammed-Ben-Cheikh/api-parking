<?php

namespace App\Http\Controllers;

use App\Models\Position;
use App\Traits\HttpResponses;
use App\Http\Requests\StorePositionRequest;

class PositionController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Positions = Position::all();
        return $this->success([
            'Positions'  => $Positions
        ], 'Positions retrieved successfully', 201);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePositionRequest $request)
    {
        try {
            $validated = $request->all();

            $Position = Position::create([
                'number' => $validated['number'],
                'hourly_rate' => $validated['hourly_rate'],
                'status' => $validated['status'],
                'parking_id' => $validated['parking_id']
            ]);

            return $this->success([
                'Position'  => $Position
            ], 'Position registered successfully', 201);
        } catch (\Exception $e) {
            return $this->error(null, 'Position registration failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $Position = Position::find($id);
        if (!$Position) {
            return $this->error(null, 'Position not found', 404);
        }
        return $this->success([
            'Position'  => $Position
        ], 'Position retrieved successfully', 201);
    }

        /**
     * Display the specified resource.
     */
    public function showByParking($id)
    {
        $Positions = Position::where('parking_id','=',$id);
        if (!$Positions) {
            return $this->error(null, 'Positions not found', 404);
        }
        return $this->success([
            'Positions'  => $Positions
        ], 'Position retrieved successfully', 201);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(StorePositionRequest $request, Position $Position)
    {
        try {
            $validated = $request->all();

            $Position->update([
                'number' => $validated['number'],
                'hourly_rate' => $validated['hourly_rate'],
                'status' => $validated['status'],
                'parking_id' => $validated['parking_id']
            ]);

            return $this->success([
                'Position'  => $Position
            ], 'Position updated successfully', 201);
        } catch (\Exception $e) {
            return $this->error(null, 'Position update failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Position $Position)
    {
        try {
            $Position->delete();
            return $this->success([
                'Position'  => $Position
            ], 'Position deleted successfully', 201);
        } catch (\Exception $e) {
            return $this->error(null, 'Position delete failed: ' . $e->getMessage(), 500);
        }
    }
}
