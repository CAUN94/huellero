<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Place;
use App\Models\Registration;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::orderBy('name', 'desc')->paginate(10);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        User::create($request->all());

        return redirect()->route('admin.users.index')->with('status', 'Usuario creado exitosamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::with('registrations')->findOrFail($id);
        $places = Place::all();  // Obtenemos todos los lugares disponibles para el registro

        return view('admin.users.show', compact('user', 'places'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::with('registrations')->findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::with('registrations')->findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        // update name and email if isset password update
        if ($request->password) {
            $request->validate([
                'password' => 'required|string|min:8',
            ]);

            $user->update($request->all());
        } else {
            $user->update($request->except('password'));
        }

        return redirect()->route('admin.users.index')->with('status', 'Usuario actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('status', 'Usuario eliminado exitosamente');
    }
    /** 
        * Create a new registration for the user
    */
    public function addRegistration(Request $request, $id)
    {
        $request->validate([
            'place_id' => 'required|exists:places,id',
            'registered_at' => 'required|date',
        ]);

        Registration::create([
            'user_id' => $id,
            'place_id' => $request->place_id,
            'registered_at' => $request->registered_at,
            'photo_path' => 'no_path',  // Campo vacío como lo especificaste
        ]);

        return redirect()->route('admin.users.show', $id)->with('status', 'Registro añadido exitosamente');
    }

    /** 
        * Delete a registration from the user
    */
    public function deleteRegistration($id)
    {
        $registration = Registration::findOrFail($id);
        $registration->delete();

        return back()->with('status', 'Registro eliminado exitosamente');
    }
}
