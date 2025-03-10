<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReservationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'start_time' => ['required', 'date', 'before:end_time'], // Assure que la date de début est avant la date de fin
            'end_time' => ['required', 'date', 'after:start_time'], // Assure que la date de fin est après la date de début
            'status' => ['required', 'in:pending,active,completed,cancelled'], // Seule une des valeurs énumérées est valide
            'total_price' => ['required', 'numeric', 'min:0'], // Assure que le prix total est un nombre positif
            'notes' => ['nullable', 'string'], // Si présent, doit être une chaîne de caractères
        
            // Relations
            'user_id' => ['required', 'exists:users,id'], // Assure que l'ID de l'utilisateur existe dans la table 'users'
            'position_id' => ['required', 'exists:positions,id'], // Assure que l'ID de la position existe dans la table 'positions'
        ];
        
    }
}
