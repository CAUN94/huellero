<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Detalles del Usuario') }}: {{ $user->name }}
        </h2>
    </x-slot>

    <div class="py-12 grid grid-cols-1 lg:grid-cols-2 gap-4">
        <div class="w-full mx-auto sm:px-6 lg:px-8 block">
            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Añadir Registro</h3>
                <form method="POST" action="{{ route('admin.users.addRegistration', $user->id) }}">
                    @csrf

                    <div class="mt-4">
                        <x-input-label for="place_id" :value="__('Lugar')" />
                        <select name="place_id" id="place_id" class="mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm rounded-lg block w-full p-2.5 text-sm">
                            @foreach ($places as $place)
                                <option value="{{ $place->id }}">{{ $place->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="registered_at" :value="__('Fecha de Registro')" />
                        <x-text-input id="registered_at" name="registered_at" type="date" class="block w-full mt-1" required />
                    </div>

                    <div class="mt-6">
                        <x-primary-button>{{ __('Añadir Registro') }}</x-primary-button>
                    </div>
                </form>
            </div>
        </div>

        <div class="w-full mx-auto sm:px-6 lg:px-8 block">
            <div class="bg-white dark:bg-gray-800 shadow overflow-hidden sm:rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">Registros del Usuario</h3>
                <ul>
                    @foreach ($user->registrations as $registration)
                        <li class="mt-4 bg-gray-100 dark:bg-gray-700 rounded-lg p-4 flex justify-between items-center">
                            <div>
                                <p class="text-sm text-gray-900 dark:text-gray-100">Lugar: {{ $registration->place->name }}</p>
                                <p class="text-sm text-gray-900 dark:text-gray-100">Fecha: {{ $registration->registered_at->format('d/m/Y') }}</p>
                            </div>
                            <form action="{{ route('admin.users.deleteRegistration', $registration->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-lg" onclick="return confirm('¿Estás seguro de eliminar este registro?')">Eliminar</button>
                            </form>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</x-app-layout>
