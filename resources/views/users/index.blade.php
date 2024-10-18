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
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <script>
        setTimeout(function() {
            document.querySelector('.flash-alert ').style.display = 'none';
        }, 3000);
    </script>
</x-app-layout>
