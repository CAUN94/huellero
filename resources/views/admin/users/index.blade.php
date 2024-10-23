<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Usuarios') }}
        </h2>
    </x-slot>

    <div class="py-12 flex items-center ">
        <div class="w-1/2 mx-auto sm:px-6 lg:px-8 block">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg text-lg">
                @if(session('status'))
                    <div>
                        <div class="flash-alert bg-green-500 text-green-100 px-4 py-3 rounded relative" role="alert">
                            <strong class="font-bold">{{ session('status') }}</strong>
                        </div>
                    </div>
                @endif 
                <div class="px-6 pt-6 pb-4 text-gray-900 dark:text-gray-100 flex justify-between items-center">
                    <span>Usuarios ({{ $users->total() }})</span>
                    <a href="{{ route('admin.users.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white text-sm font-bold px-2 py-0.5 rounded-full">Nuevo</a>
                </div>

                @foreach ($users as $user)
                    <div class="mb-4 mx-6 p-4 bg-gray-100 dark:bg-gray-700 rounded-lg">
                        <div class="flex gap-2 justify-between items-center">
                            <p class="text-sm text-gray-900 dark:text-gray-100">
                                Nombre: {{ $user->name }} - Email: {{ $user->email }}
                            </p>
                            <div class="flex gap-2 items-center justify-between">
                                <a href="{{ route('admin.users.show', $user->id) }}" class="bg-blue-500 text-white text-sm font-bold px-2 py-0.5 rounded-full">Ver</a>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-yellow-500 text-white text-sm font-bold px-2 py-0.5 rounded-full">Editar</a>
                                <form class="bg-red-500 text-white text-sm font-bold px-2 py-0.5 rounded-full" action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este usuario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" >Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
        
                <!-- Mostrar la paginación -->
                <div class="px-6 pt-2 pb-4 text-gray-900 dark:text-gray-100">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
