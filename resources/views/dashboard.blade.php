@extends('layouts.app')

@section('content')

{{-- HEADER --}}
<header class="bg-black text-white border-b border-gray-800 sticky top-0 z-50">
    <div class="max-w-[1400px] mx-auto px-6 py-3 flex items-center justify-between">
        <div class="flex items-center gap-8">
            <div class="flex items-center gap-3">
                <div class="bg-primary w-10 h-10 rounded-lg flex items-center justify-center">
                    <span class="text-xl font-bold text-white">T</span>
                </div>
                <div>
                    <p class="text-lg font-medium leading-tight">TecNow</p>
                    <p class="text-xs text-gray-400">TSJ Lagos</p>
                </div>
            </div>
            <div class="hidden md:flex relative">
                <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z"/>
                </svg>
                <input type="text" placeholder="Buscar en TecNow..."
                    class="bg-gray-900 text-white pl-10 pr-4 py-2 rounded-lg w-80 border border-gray-700 focus:border-blue-500 focus:outline-none" />
            </div>
        </div>
        <div class="flex items-center gap-4">
            <button class="relative hover:bg-gray-900 p-2 rounded-lg transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="absolute top-1 right-1 w-2 h-2 bg-primary rounded-full"></span>
            </button>
            <div class="flex items-center gap-3 hover:bg-gray-900 px-3 py-2 rounded-lg transition-colors">
                <div class="w-8 h-8 rounded-full overflow-hidden border-2 border-primary">
    <img src="{{ asset('avatars/' . Auth::user()->avatar) }}"
        alt="avatar"
        class="w-full h-full object-cover" />
</div>
                <div class="hidden lg:block">
                    <p class="text-sm leading-tight">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-400">&#64;{{ Auth::user()->username }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-xs text-gray-400 hover:text-white transition-colors hidden lg:block">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </div>
</header>

{{-- BODY --}}
<div x-data="{ filter: 'popular', showModal: false }" class="flex max-w-[1400px] mx-auto">

    {{-- SIDEBAR --}}
    <aside class="hidden lg:block w-64 border-r border-border bg-sidebar px-4 py-6 sticky top-[73px] h-[calc(100vh-73px)] overflow-y-auto">
        <nav class="space-y-1 mb-6">
            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg bg-secondary text-secondary-foreground">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6"/></svg>
                <span>Inicio</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-sidebar-accent transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                <span>Popular</span>
            </a>
            <a href="#" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-sidebar-accent transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                <span>Comunidades</span>
            </a>
        </nav>
        <div class="border-t border-sidebar-border pt-4">
            <div class="flex items-center justify-between mb-3 px-3">
                <p class="text-sm text-muted-foreground">Mis Comunidades</p>
                <button class="text-primary hover:text-blue-400">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </button>
            </div>
            <div class="space-y-1">
                @foreach([
                    ['💻','ISC','450'],
                    ['⚙️','Mecatrónica','320'],
                    ['🏭','Industrial','280'],
                    ['🌐','Programación Web','520'],
                    ['📐','Matemáticas','410'],
                    ['📢','Avisos Oficiales','890'],
                    ['🎭','Eventos y Cultura','340'],
                    ['⚽','Deportes TSJ','210'],
                ] as [$icon, $name, $members])
                <button class="w-full flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-sidebar-accent transition-colors text-left">
                    <span class="text-lg">{{ $icon }}</span>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm truncate">{{ $name }}</p>
                        <p class="text-xs text-muted-foreground">{{ $members }} miembros</p>
                    </div>
                </button>
                @endforeach
            </div>
            <button class="w-full mt-3 px-3 py-2 text-sm text-primary hover:bg-sidebar-accent rounded-lg transition-colors">
                Ver todas las comunidades
            </button>
        </div>
    </aside>

    {{-- MAIN --}}
    <main class="flex-1 px-4 lg:px-6 py-6">
        <div class="mb-6 flex items-center justify-between flex-wrap gap-4">
            <div class="flex gap-2">
                @foreach(['popular' => 'Popular', 'reciente' => 'Reciente', 'trending' => 'Trending'] as $key => $label)
                <button
                    @click="filter = '{{ $key }}'"
                    :class="filter === '{{ $key }}' ? 'bg-primary text-white' : 'bg-card hover:bg-muted text-foreground border border-border'"
                    class="px-4 py-2 rounded-lg transition-colors text-sm">
                    {{ $label }}
                </button>
                @endforeach
            </div>
            <button @click="showModal = true"
                class="bg-primary text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>Crear publicación</span>
            </button>
        </div>

        {{-- Posts vacíos por ahora --}}
        <div class="space-y-4">
            <div class="bg-card border border-border rounded-lg p-12 text-center">
                <svg class="w-12 h-12 text-muted-foreground mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/></svg>
                <p class="text-muted-foreground text-sm">No hay publicaciones todavía.</p>
                <p class="text-muted-foreground text-xs mt-1">¡Sé el primero en publicar algo!</p>
            </div>
        </div>
    </main>

    {{-- ASIDE derecho --}}
    <aside class="hidden xl:block w-80 px-6 py-6">
        <div class="bg-card border border-border rounded-lg p-6 sticky top-24">
            <div class="mb-4">
                <h3 class="mb-2">Bienvenido a TecNow</h3>
                <p class="text-sm text-muted-foreground">Tu comunidad, tu voz, en tiempo real.</p>
            </div>
            <div class="space-y-3 mb-6 bg-secondary rounded-lg p-4">
                @foreach([
                    ['📝','Comparte ideas y recursos académicos'],
                    ['💬','Comenta y participa en debates'],
                    ['⬆️','Vota el mejor contenido'],
                    ['👥','Únete a comunidades'],
                ] as [$icon, $text])
                <div class="flex items-start gap-3 text-sm">
                    <span class="text-xl">{{ $icon }}</span>
                    <span class="text-muted-foreground">{{ $text }}</span>
                </div>
                @endforeach
            </div>
            <div class="border-t border-border pt-4 mb-6">
                <h4 class="mb-3 text-sm">Reglas de la comunidad</h4>
                <ul class="text-xs text-muted-foreground space-y-2">
                    @foreach(['Respeto entre todos los miembros','No spam ni contenido inapropiado','Usa las comunidades correctas','Verifica información antes de compartir'] as $rule)
                    <li class="flex items-start gap-2">
                        <span class="text-primary mt-0.5">•</span>
                        <span>{{ $rule }}</span>
                    </li>
                    @endforeach
                </ul>
            </div>
            <div class="border-t border-border pt-4">
                <h4 class="text-sm mb-2">Estadísticas</h4>
                <div class="space-y-2 text-sm">
                    @foreach([['Miembros activos','2,450'],['Publicaciones hoy','127'],['Comunidades','24']] as [$label, $val])
                    <div class="flex justify-between">
                        <span class="text-muted-foreground">{{ $label }}</span>
                        <span class="font-medium text-primary">{{ $val }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </aside>

</div>

{{-- MODAL crear publicación --}}
<div x-show="showModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
    <div class="absolute inset-0 bg-black/60" @click="showModal = false"></div>
    <div class="relative bg-card border border-border rounded-lg p-6 w-full max-w-lg mx-4 z-10">
        <div class="flex items-center justify-between mb-4">
            <h3>Crear publicación</h3>
            <button @click="showModal = false" class="text-muted-foreground hover:text-foreground">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
        <div class="space-y-4">
            <input type="text" placeholder="Título de la publicación"
                class="w-full px-3 py-2 rounded-lg border border-border bg-muted focus:border-primary focus:outline-none" />
            <select class="w-full px-3 py-2 rounded-lg border border-border bg-muted focus:border-primary focus:outline-none">
                <option value="">Selecciona una comunidad</option>
                @foreach(['ISC','Mecatrónica','Industrial','Programación Web','Matemáticas','Avisos Oficiales'] as $c)
                <option>{{ $c }}</option>
                @endforeach
            </select>
            <textarea rows="4" placeholder="¿Qué quieres compartir?"
                class="w-full px-3 py-2 rounded-lg border border-border bg-muted focus:border-primary focus:outline-none resize-none"></textarea>
            <div class="flex justify-end gap-3">
                <button @click="showModal = false"
                    class="px-4 py-2 rounded-lg border border-border hover:bg-muted transition-colors text-sm">
                    Cancelar
                </button>
                <button @click="showModal = false"
                    class="px-4 py-2 rounded-lg bg-primary text-white hover:bg-blue-700 transition-colors text-sm">
                    Publicar
                </button>
            </div>
        </div>
    </div>
</div>

@endsection