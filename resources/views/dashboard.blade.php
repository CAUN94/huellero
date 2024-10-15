<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Registrar entrada de {{ Auth::user()->name }} 
            {{-- if isset $distance isset and is true show message "Registro realizado" --}}
            @if (isset($distance) && $distance)
                <span class="text-green">Registro realizado</span>
            @endif
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('entries.store') }}" method="POST" x-data="geolocationApp()">
                        @csrf
                        <!-- Select con lugares de ejemplo -->
                        <div class="mb-4">
                            <label for="place" class="block text-gray-700 dark:text-gray-300 font-bold mb-2 ">Selecciona un lugar:</label>
                            <select id="place" name="place" x-model="selectedPlace" class="border-gray-300 rounded-lg mt-2 p-2 w-full text-gray-900">
                                <option value="" disabled selected>-- Selecciona un lugar --</option>
                                @foreach ($places as $place)
                                    <option value="{{ $place->id }}">{{ $place->name }}</option>
                                @endforeach
                            </select>
                        </div>
                
                        <!-- Botón para geolocalizar -->
                        <div class="flex">
                            <button type="button" @click="getGeolocation" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 w-full rounded">
                                Geolocalizar
                            </button>
                        </div>
                
                        <!-- Mostrar coordenadas -->
                        <div x-show="latitude && longitude" class="mt-4 mb-4 p-4 bg-gray-100 rounded shadow-md text-gray-900
                        ">
                            <p><strong>Coordenadas de la ubicación seleccionada:</strong></p>
                            <p>Latitud: <span x-text="latitude"></span></p>
                            <p>Longitud: <span x-text="longitude"></span></p>
                        </div>

                        <div x-show="showMap" id="map" class="h-64 w-full rounded-lg shadow-md"></div>
                        <div class="my-4">
                            <label for="photo" class="block text-gray-700 dark:text-gray-200">Sube una foto:</label>
                            <input type="file" id="photo" name="photo" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" accept="image/*">
                        </div>
                        {{-- send longitude and latitude value --}}
                        <input type="hidden" name="latitude" x-model="latitude">
                        <input type="hidden" name="longitude" x-model="longitude">
                        <div class="mt-4">
                            <input type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded w-full" value="Registrar entrada">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>

    <script>
        function geolocationApp() {
            return {
                selectedPlace: '',  // Almacena el lugar seleccionado
                latitude: null,     // Coordenada de latitud
                longitude: null,    // Coordenada de longitud
                showMap: false,     // Controla si se muestra el contenedor del mapa
                map: null,          // Referencia al mapa de Leaflet
                marker: null,       // Referencia al marcador de Leaflet
    
                // Función para obtener la ubicación del usuario
                getGeolocation() {
                    if (!this.selectedPlace) {
                        alert('Por favor, selecciona un lugar antes de obtener la geolocalización.');
                        return;
                    }
    
                    // Verificar si el navegador soporta la geolocalización
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition((position) => {
                            // Guardar latitud y longitud
                            this.latitude = position.coords.latitude;
                            this.longitude = position.coords.longitude;
    
                            // Mostrar el mapa y la ubicación actual
                            this.showMap = true;  // Mostrar el contenedor del mapa
    
                            // Usar setTimeout para asegurar que el contenedor esté completamente visible antes de inicializar el mapa
                            setTimeout(() => {
                                this.showMapOnScreen();
                            }, 300);  // Un pequeño retraso para asegurar que el contenedor esté visible
                        }, (error) => {
                            switch (error.code) {
                                case error.PERMISSION_DENIED:
                                    alert("Permiso denegado por el usuario. Habilita la ubicación en la configuración de tu navegador.");
                                    break;
                                case error.POSITION_UNAVAILABLE:
                                    alert("La información de ubicación no está disponible.");
                                    break;
                                case error.TIMEOUT:
                                    alert("La solicitud de ubicación ha expirado.");
                                    break;
                                case error.UNKNOWN_ERROR:
                                    alert("Ha ocurrido un error desconocido.");
                                    break;
                            }
                        });
                    } else {
                        alert("La geolocalización no es soportada por este navegador.");
                    }
                },
    
                // Función para mostrar el mapa con Leaflet
                showMapOnScreen() {
                    // Inicializar el mapa si no existe
                    if (!this.map) {
                        this.map = L.map('map').setView([this.latitude, this.longitude], 15);  // Zoom nivel 15
    
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            maxZoom: 19,
                            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                        }).addTo(this.map);
                    }
    
                    // Si ya existe un marcador, actualizarlo
                    if (this.marker) {
                        this.marker.setLatLng([this.latitude, this.longitude]);
                    } else {
                        // Crear un nuevo marcador en la ubicación actual
                        this.marker = L.marker([this.latitude, this.longitude]).addTo(this.map);
                    }
    
                    // Mover el mapa a la nueva ubicación
                    this.map.setView([this.latitude, this.longitude], 15);
    
                    // Invalidar el tamaño para corregir el problema de mapa gris
                    setTimeout(() => {
                        this.map.invalidateSize();  // Asegura que el mapa se renderice correctamente
                    }, 100);
                }
            }
        }
    </script>
</x-app-layout>
