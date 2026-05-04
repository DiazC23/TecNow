<x-app-layout>
    <div class="max-w-5xl mx-auto py-8 px-4">
        <h1 class="text-2xl font-bold mb-6">Gestión de Usuarios</h1>

        <form method="GET" action="{{ route('admin.users') }}" class="flex gap-3 mb-6">
            <input type="text" name="search" value="{{ request('search') }}"
                placeholder="Buscar por nombre, usuario o email..."
                class="flex-1 border rounded px-3 py-2 text-sm" />
            <select name="role" class="border rounded px-3 py-2 text-sm">
                <option value="">Todos los roles</option>
                <option value="student" {{ request('role') === 'student' ? 'selected' : '' }}>Student</option>
                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
            <button class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">Filtrar</button>
        </form>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 p-3 bg-red-100 text-red-800 rounded">{{ session('error') }}</div>
        @endif

        <div class="overflow-x-auto rounded-lg border">
            <table class="w-full text-sm">
                <thead class="bg-gray-100 text-left">
                    <tr>
                        <th class="px-4 py-3">Usuario</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Rol actual</th>
                        <th class="px-4 py-3">Cambiar rol</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3">
                                <div class="flex items-center gap-2">
                                    <img src="/avatars/{{ $user->avatar ?? 'avatar_default.png' }}" class="w-8 h-8 rounded-full" />
                                    <div>
                                        <p class="font-medium">{{ $user->name }}</p>
                                        <p class="text-gray-400">@{{ $user->username }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $user->email }}</td>
                            <td class="px-4 py-3">
                                <span class="px-2 py-1 rounded-full text-xs font-semibold
                                    {{ $user->global_role === 'admin' ? 'bg-purple-100 text-purple-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ ucfirst($user->global_role) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                @if($user->id !== auth()->id())
                                    <form method="POST" action="{{ route('admin.users.updateRole', $user) }}">
                                        @csrf
                                        @method('PATCH')
                                        <div class="flex gap-2 items-center">
                                            <select name="global_role" class="border rounded px-2 py-1 text-sm">
                                                <option value="student" {{ $user->global_role === 'student' ? 'selected' : '' }}>Student</option>
                                                <option value="admin" {{ $user->global_role === 'admin' ? 'selected' : '' }}>Admin</option>
                                            </select>
                                            <button class="bg-blue-600 text-white px-3 py-1 rounded text-sm hover:bg-blue-700">
                                                Guardar
                                            </button>
                                        </div>
                                    </form>
                                @else
                                    <span class="text-xs text-gray-400">Tú</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-4 py-8 text-center text-gray-400">No se encontraron usuarios.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</x-app-layout>