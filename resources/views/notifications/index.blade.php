<x-app-layout>
    <div class="max-w-3xl mx-auto py-8 px-4">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold">Notificaciones</h1>

            @if(auth()->user()->unreadNotifications->count())
                <form method="POST" action="{{ route('notifications.readAll') }}">
                    @csrf
                    <button class="text-sm bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                        Marcar todas como leídas
                    </button>
                </form>
            @endif
        </div>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        @forelse($notifications as $notification)
            <div class="mb-3 p-4 rounded-lg border {{ $notification->read_at ? 'bg-white opacity-60' : 'bg-blue-50 border-blue-200' }}">
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="font-semibold">{{ $notification->data['titulo'] }}</p>
                        <p class="text-sm text-gray-600">{{ $notification->data['mensaje'] }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>

                    @if(!$notification->read_at)
                        <form method="POST" action="{{ route('notifications.read', $notification->id) }}">
                            @csrf
                            <button class="text-xs text-blue-600 hover:underline whitespace-nowrap">
                                Marcar leída
                            </button>
                        </form>
                    @else
                        <span class="text-xs text-gray-400">Leída</span>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-center mt-10">No tienes notificaciones.</p>
        @endforelse

        <div class="mt-4">
            {{ $notifications->links() }}
        </div>
    </div>
</x-app-layout>