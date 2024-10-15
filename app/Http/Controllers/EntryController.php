<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place;

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
        // return $request->all();
        $places = Place::all();
        $place= Place::find($request->place);

        $latitude = $request->latitude;
        $longitude = $request->longitude;

        $distance = $place->distanceTo($latitude, $longitude);
        return view('dashboard',compact('distance','places'));
        
    }
}
