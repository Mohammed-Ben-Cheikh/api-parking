<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Http\Requests\StoreReservationRequest;
use App\Traits\HttpResponses;

class ReservationController extends Controller
{
    use HttpResponses;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Reservations = Reservation::all();
        return $this->success([
            'Reservations' => $Reservations
        ], 'Reservations retrieved successfully', 201);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReservationRequest $request)
    {
        try {
            $validated = $request->all();
            // Check if position is already reserved for the given time period
            $existingReservation = Reservation::where('position_id', $validated['position_id'])
                ->where('status', '=', 'active')
                ->where('start_time', '<', $validated['end_time'])
                ->where('end_time', '>', $validated['start_time'])
                ->exists();

            if ($existingReservation) {
                return $this->error(null, 'This position is already reserved for the selected time period', 409);
            }
            $Reservation = Reservation::create([
                'start_time' => $validated["start_time"],
                "end_time" => $validated["end_time"],
                "status" => $validated["status"],
                "total_price" => $validated["total_price"],
                "notes" => $validated["notes"],
                "user_id" => $validated["user_id"],
                "position_id" => $validated["position_id"],
            ]);

            return $this->success([
                'Reservation' => $Reservation
            ], 'Reservation registered successfully', 201);
        } catch (\Exception $e) {
            return $this->error(null, 'Reservation registration failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $Reservation = Reservation::find($id);
        if (!$Reservation) {
            return $this->error(null, 'Reservation not found', 404);
        }
        return $this->success([
            'Reservation' => $Reservation
        ], 'Reservation retrieved successfully', 201);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(StoreReservationRequest $request, Reservation $Reservation)
    {
        try {
            $validated = $request->all();
            // Check if position is already reserved for the given time period
            $existingReservation = Reservation::where('position_id', $validated['position_id'])
                ->where('status', '=', 'active')
                ->where('id', '!=', $Reservation->id)
                ->where('start_time', '<', $validated['end_time'])
                ->where('end_time', '>', $validated['start_time'])
                ->exists();

            if ($existingReservation) {
                return $this->error(null, 'This position is already reserved for the selected time period', 409);
            }

            $Reservation->update([
                'start_time' => $validated["start_time"],
                "end_time" => $validated["end_time"],
                "status" => $validated["status"],
                "total_price" => $validated["total_price"],
                "notes" => $validated["notes"],
                "user_id" => $validated["user_id"],
                "position_id" => $validated["position_id"],
            ]);

            return $this->success([
                'Reservation' => $Reservation
            ], 'Reservation updated successfully', 201);
        } catch (\Exception $e) {
            return $this->error(null, 'Reservation update failed: ' . $e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $reservation = Reservation::find($id);

            $reservation->update([
                "status" => "cancelled",
            ]);
            return $this->success([
                'Reservation' => $reservation
            ], 'Reservation deleted successfully', 201);
        } catch (\Exception $e) {
            return $this->error(null, 'Reservation delete failed: ' . $e->getMessage(), 500);
        }
    }
}
