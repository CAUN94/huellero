<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Registros de {{ Auth::user()->name }} 
        </h2>
    </x-slot>

    
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                @if(session('status'))
                    <div>
                        <div class="flash-alert bg-green-500  text-green-100 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">Registro Exitoso!</strong>
                        </div>
                    </div>
                @endif 
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <ul class="max-w-xl space-y-1 text-gray-500 list-inside dark:text-gray-400 text-sm text-base sm:text-lg">
                        @foreach($registrations as $registration)
                            <li class="flex items-center">
                                <svg class="w-3.5 h-3.5 me-2 text-green-500 dark:text-green-400 flex-shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z"/>
                                </svg>
                                <span>
                                    {{ $registration->place->name }} - Registrado a las: {{ $registration->registered_at->format('d-m-Y H:i ') }} 
                                </span>
                                {{-- registration photo path --}}
                                @if($registration->photo_path)
                                <!-- Botón para abrir el modal -->
                                    <div x-data="{ open: false }"  x-cloak>
                                        <button @click="open = true" type="button" class="ml-2 text-blue-500 dark:text-blue-400">
                                            Ver foto
                                        </button>
                                
                                        <!-- Modal -->
                                        <div x-show="open" x-transition.opacity class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50" x-cloak>
                                            <div class="relative w-full max-w-2xl max-h-full">
                                                <!-- Modal content -->
                                                <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                                    <!-- Modal header -->
                                                    <div class="flex items-center justify-between p-4 border-b rounded-t dark:border-gray-600">
                                                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                                            {{ $registration->place->name }} - Registrado a las: {{ $registration->registered_at->format('d-m-Y H:i ') }}
                                                        </h3>
                                                        <button @click="open = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                            </svg>
                                                            <span class="sr-only">Cerrar</span>
                                                        </button>
                                                    </div>
                                
                                                    <!-- Modal body (imagen de la foto subida) -->
                                                    <div class="p-4 space-y-4">
                                                        <img src="{{ asset($registration->photo_path) }}" alt="Foto no disponible" class="w-full h-auto rounded">
                                                    </div>
                                
                                                    <!-- Modal footer -->
                                                    <div class="flex items-center p-4 border-t border-gray-200 rounded-b dark:border-gray-600">
                                                        <button @click="open = false" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Cerrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            

                            </li>
                        @endforeach
                    </ul>
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
