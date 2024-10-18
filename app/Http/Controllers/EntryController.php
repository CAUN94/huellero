<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place;
use Illuminate\Support\Facades\Auth;
use App\Models\Registration;

class EntryController extends Controller
{
    // index function
    public function index()
    {
        $places = Place::all();
        return view('dashboard',compact('places'));
    }
    // store function
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'place' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);
        // Validate the request
        $places = Place::all();
        $place= Place::find($request->place);

        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $distance = $place->distanceTo($latitude, $longitude);
        if($distance){
            $placeId = $request->input('place');
            $userId = Auth::id();
            // if registration is in same place and day continue compare day-month-year
            $checkRegistration = Registration::where('user_id', $userId)
                ->where('place_id', $placeId)
                ->whereDate('registered_at', now())
                ->first();
            if (!$checkRegistration) {
                $createRegistration = Registration::create([
                    'user_id' => $userId,               // ID del usuario autenticado
                    'place_id' => $placeId,             // ID del lugar
                    'registered_at' => now(),           // Timestamp del registro actual
                    'photo_path' => "no_path",               // Campo nulo
                ]);
            }
            // Get users registrations
            $registrations = Auth::user()->registrations;
            session()->flash('status', 'Registro creado exitosamente.');
            // redirect to /users'
            return redirect()->route('users.index');
        } 
        session()->flash('status', 'Usuario no habilitado para entrar');
        return view('dashboard',compact('places'));        
    }

    public function registers()
    {
        $registrations = Auth::user()->registrations;
        return view('users.index',compact('registrations'));
    }
}
