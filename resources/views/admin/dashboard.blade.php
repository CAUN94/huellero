<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Administrador {{ Auth::user()->name }} 
        </h2>
    </x-slot>

    
    <div class="py-12 grid grid-cols-1 sm:grid-cols-3 gap-2">
        <div class="w-full mx-auto sm:px-6 lg:px-8 block">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @if(session('status'))
                    <div>
                        <div class="flash-alert bg-green-500  text-green-100 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Registro Exitoso!</strong>
                        </div>
                    </div>
                @endif 
                <div class="p-6 text-gray-900 dark:text-gray-100">
                        Registros
                </div>
            </div>
        </div>
        <div class="w-full mx-auto sm:px-6 lg:px-8 block">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                        Usuarios
                </div>
            </div>
        </div>
        <div class="w-full mx-auto sm:px-6 lg:px-8 block">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                        Habilitar usuario
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
