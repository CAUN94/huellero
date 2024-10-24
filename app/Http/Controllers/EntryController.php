<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place;
use Illuminate\Support\Facades\Auth;
use App\Models\Registration;
use App\Models\User;

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
            // 'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            // 'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        // Validate the request
        $places = Place::all();
        $place= Place::find($request->place);

        $latitude = $request->latitude;
        $longitude = $request->longitude;

        // if isset path of photo
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = time() . '.' . $photo->getClientOriginalExtension(); // Crear un nombre único para la imagen
            $path = $photo->storeAs('fotos_de_registro', $filename, 'public'); // Guardar en 'storage/app/public/fotos_de_registro'

            // path public photo
            $path_photo = "storage/" . $path;
        } else {
            $path_photo = "no-photo.";
        }

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
                    'photo_path' => $path_photo               // Campo nulo
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

    public function administrador()
    {
        $user = Auth::user();

        if ($user && $user->isAdmin()) {
            $registrations = Registration::with('place')->paginate(5, ['*'], 'registrations_page');
            $places = Place::withCount('registrations')->orderBy('registrations_count', 'desc')->paginate(5, ['*'], 'places_page');
            $users = User::where('approve', 1)->paginate(5, ['*'], 'users_page');
            $users_not_approved = User::where('approve', 0)->paginate(5, ['*'], 'users_not_approved_page');

            return view('admin.dashboard',compact('places','users','users_not_approved')); // Vista de administrador
        }

        return redirect()->route('dashboard')->with('error', 'No tienes permisos de administrador');
    }

    public function users_aprove($id)
    {
        $user = User::find($id);
        $user->approve = !$user->approve;
        $user->save();
        return redirect()->route('admin');
    }

    public function users_aprove_destroy($id)
    {
        $user = User::find($id);
        $user->delete();
        return redirect()->route('admin');
    }
}
