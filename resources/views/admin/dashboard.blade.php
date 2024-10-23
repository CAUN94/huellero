<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Administrador {{ Auth::user()->name }} 
        </h2>
    </x-slot>

    
    <div class="py-12 grid grid-cols-1 lg:grid-cols-3 gap-2">
        <div class="w-full mx-auto sm:px-6 lg:px-8 block">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg text-lg">
                @if(session('status'))
                    <div>
                        <div class="flash-alert bg-green-500  text-green-100 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Registro Exitoso!</strong>
                        </div>
                    </div>
                @endif 
                <div class="px-6 pt-6 pb-4 text-gray-900 dark:text-gray-100">
                        Lugares ({{ $places->total() }})
                </div>
                @foreach ($places as $place)
                    <div class="mb-4 mx-6 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        <p class="text-sm text-gray-900 dark:text-gray-100">
                            Lugar: {{ $place->name}} registros: {{ $place->registrations->count() }}
                            {{-- Cantidad de registros en este lugar: {{  }} --}}
                        </p>
                    </div>
                @endforeach
        
                <!-- Mostrar la paginación -->
                <div class="px-6 pt-2 pb-4 text-gray-900 dark:text-gray-100">
                    {{ $places->appends([
                        'users_page' => request('users_page'), 
                        'users_not_approved_page' => request('users_not_approved_page')
                    ])->links() }}
                </div>
            </div>
        </div>
        <div class="w-full mx-auto sm:px-6 lg:px-8 block">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                        Usuarios ({{ $users->total() }})
                </div>
                @foreach ($users as $user)
                    <div class="mb-4 mx-6 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg flex gap-2 items-center">
                        <p class="text-sm text-gray-900 dark:text-gray-100">
                            Usuario: {{ $user->name}} registros: {{ $user->registrations->count() }}
                        </p>
                        {{-- form to update aprove value with confirm botton --}}
                        <form action="{{ route('admin.users_aprove.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white text-sm font-bold px-2 py-0.5 rounded-full" 
                            {{-- confirm --}}
                            onclick="return confirm('¿Estás seguro de desaprobar este usuario?')">Desaprobar</button>
                        </form>
                    </div>
                @endforeach
        
                <!-- Mostrar la paginación -->
                <div class="px-6 pt-2 pb-4 text-gray-900 dark:text-gray-100">
                    {{ $users->appends([
                        'places_page' => request('places_page'), 
                        'users_not_approved_page' => request('users_not_approved_page')
                    ])->links() }}
                </div>
            </div>
        </div>
        <div class="w-full mx-auto sm:px-6 lg:px-8 block">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                        Habilitar usuario ({{$users_not_approved->total()}})
                </div>
                @foreach ($users_not_approved as $user)
                    <div class="mb-4 mx-6 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg flex gap-2 items-center">
                        <p class="text-sm text-gray-900 dark:text-gray-100">
                            Usuario: {{ $user->name}} 
                        </p>
                            {{-- form to update aprove value with confirm botton --}}
                        <form action="{{ route('admin.users_aprove.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold px-2 py-0.5 rounded-full" 
                            {{-- confirm --}}
                            onclick="return confirm('¿Estás seguro de aprobar este usuario?')">Aprobar</button>
                        </form>
                        {{-- Delete user woth confirm button --}}
                        <form action="{{ route('admin.users_aprove.destroy', $user->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white text-sm font-bold px-2 py-0.5 rounded-full">Eliminar</button>
                        </form>
                    </div>
                @endforeach

                <div class="px-6 pt-2 pb-4 text-gray-900 dark:text-gray-100">
                    {{ $users_not_approved->appends([
                        'places_page' => request('places_page'), 
                        'users_page' => request('users_page')
                    ])->links() }}
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script src="//unpkg.com/alpinejs" defer></script>

    <script>
        setTimeout(function() {
            document.querySelector('.flash-alert ').style.display = 'none';
        }, 3000);
    </script>
</x-app-layout>
