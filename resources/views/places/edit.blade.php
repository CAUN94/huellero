<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Editar Lugar') }}
        </h2>
    </x-slot>

    <div class="py-12 flex gap-2">
        <div class="w-1/2 mx-auto sm:px-6 lg:px-8 block">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <section>
                        <header>
                            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                                {{ __('Editar Información del Lugar') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                {{ __("Modifica los datos del lugar seleccionado.") }}
                            </p>
                        </header>

                        <form method="POST" action="{{ route('admin.places.update', $place->id) }}" class="mt-6 space-y-6">
                            @csrf
                            @method('PATCH')

                            <div>
                                <x-input-label for="name" :value="__('Nombre del Lugar')" />
                                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $place->name)" required autofocus />
                                <x-input-error class="mt-2" :messages="$errors->get('name')" />
                            </div>

                            <div>
                                <x-input-label for="latitude" :value="__('Latitud')" />
                                <x-text-input id="latitude" name="latitude" type="text" class="mt-1 block w-full" :value="old('latitude', $place->latitude)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('latitude')" />
                            </div>

                            <div>
                                <x-input-label for="longitude" :value="__('Longitud')" />
                                <x-text-input id="longitude" name="longitude" type="text" class="mt-1 block w-full" :value="old('longitude', $place->longitude)" required />
                                <x-input-error class="mt-2" :messages="$errors->get('longitude')" />
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>{{ __('Actualizar Lugar') }}</x-primary-button>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
