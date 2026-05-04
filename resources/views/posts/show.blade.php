@extends('layouts.app')

@section('content')
<x-navbar />

{{-- BODY --}}
<div x-data="{ showCommunityModal: false, showAddAdminModal: false, selectedCommunityId: null }"
  class="flex max-w-[1400px] mx-auto">

  {{-- SIDEBAR IZQUIERDO --}}
  <aside class="hidden lg:block w-64 border-r border-border bg-sidebar px-4 py-6 sticky top-[73px] h-[calc(100vh-73px)] overflow-y-auto">
    <nav class="space-y-1 mb-6">
      <a href="{{ route('dashboard') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-sidebar-accent transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0h6" />
        </svg>
        <span>Inicio</span>
      </a>
      <a href="#"
        class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-sidebar-accent transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
        </svg>
        <span>Popular</span>
      </a>
      <a href="#"
        class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-sidebar-accent transition-colors">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
        <span>Comunidades</span>
      </a>
    </nav>
    <div class="border-t border-sidebar-border pt-4">
      <div class="flex items-center justify-between mb-3 px-3">
        <p class="text-sm text-muted-foreground">Mis Comunidades</p>
      </div>
      <div class="space-y-1">
        @foreach ($communities as $community)
        <button class="w-full flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-sidebar-accent transition-colors text-left">
          <span class="text-lg">{{ $community->icon }}</span>
          <div class="flex-1 min-w-0">
            <p class="text-sm truncate">{{ $community->name }}</p>
            <p class="text-xs text-muted-foreground">{{ $community->users_count }} miembros</p>
          </div>
          @php
          $isForumAdmin = $community->users()->where('user_id', Auth::id())->wherePivot('role', 'admin')->exists();
          $isGlobalAdmin = Auth::user()->global_role === 'admin';
          @endphp
          @if($isForumAdmin || $isGlobalAdmin)
          <button type="button"
            @click.prevent="selectedCommunityId = {{ $community->id }}; showAddAdminModal = true"
            class="text-xs text-primary hover:text-blue-400 p-1 bg-gray-800 rounded z-10 relative">
            +Admin
          </button>
          @endif
        </button>
        @endforeach
      </div>
      <button class="w-full mt-3 px-3 py-2 text-sm text-primary hover:bg-sidebar-accent rounded-lg transition-colors">
        Ver todas las comunidades
      </button>
      @if(Auth::user()->global_role === 'admin')
      <button @click="showCommunityModal = true"
        class="w-full mt-3 px-3 py-2 text-sm bg-primary text-white hover:bg-blue-700 rounded-lg transition-colors">
        + Crear Comunidad
      </button>
      @endif
    </div>
  </aside>

  {{-- MAIN --}}
  <main class="flex-1 px-4 lg:px-6 py-6">

    {{-- Breadcrumb / volver --}}
    <a href="{{ url()->previous() }}"
      class="inline-flex items-center gap-2 text-sm text-gray-400 hover:text-blue-400 transition-colors mb-6">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
      </svg>
      Volver
    </a>

    {{-- Post --}}
    @php
    $karma = $post->votes->sum('vote');
    $userVote = $post->votes->where('user_id', Auth::id())->first()?->vote;
    $isAuthor = $post->user_id === Auth::id();
    $community = $post->communities->first();
    $isForumAdmin = $community
    ? $community->users()->where('user_id', Auth::id())->wherePivot('role', 'admin')->exists()
    : false;
    $isGlobalAdmin = Auth::user()->global_role === 'admin';
    @endphp

    <div class="bg-card border border-border rounded-lg p-6">

      {{-- Autor + acciones --}}
      <div class="flex items-center justify-between mb-4">
        <div class="flex items-center gap-3">
          <div class="w-10 h-10 rounded-full bg-gray-200 overflow-hidden relative border border-gray-300">
            <img src="{{ asset('avatars/'.$post->user->avatar) }}" class="w-full h-full object-cover">
            @if($post->user->marco)
            <img src="{{ asset('marcos/'.$post->user->marco) }}" class="absolute inset-0 w-full h-full object-cover z-10" />
            @endif
          </div>
          <div>
            <p class="text-sm font-semibold">
              {{ $post->user->name }}
              @if($post->communities->isNotEmpty())
              <span class="text-gray-500 font-normal text-xs">en</span>
              {{ $post->communities->first()->name }}
              @endif
            </p>
            <p class="text-xs text-muted-foreground">{{ $post->created_at->diffForHumans() }}</p>
          </div>
        </div>

        {{-- Editar / Eliminar --}}
        @if($isAuthor || $isForumAdmin || $isGlobalAdmin)
        <div class="flex items-center gap-2">
          @if($isAuthor)
          <a href="{{ route('posts.edit', $post) }}"
            class="relative group p-1.5 rounded-lg text-blue-500 hover:bg-blue-500/10 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            <span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded
                                                 opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
              Editar
            </span>
          </a>
          @endif
          <form action="{{ route('posts.destroy', $post) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit"
              onclick="return confirm('¿Eliminar esta publicación?')"
              class="relative group p-1.5 rounded-lg text-red-500 hover:bg-red-500/10 transition-colors">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
              <span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded
                                                 opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
                Eliminar
              </span>
            </button>
          </form>
        </div>
        @endif
      </div>

      {{-- Título y contenido --}}
      <h1 class="text-xl font-bold mb-3">{{ $post->title }}</h1>
      <p class="text-sm text-foreground whitespace-pre-wrap leading-relaxed">{{ $post->content }}</p>

      {{-- Karma --}}
      <div class="flex items-center gap-1 mt-2"
        x-data="{
                                karma: {{ $karma }},
                                userVote: {{ $userVote ?? 'null' }},
                                loading: false,
                                async vote(value) {
                                    if (this.loading) return;
                                    this.loading = true;
                                    try {
                                        const res = await fetch('{{ route('posts.vote', $post) }}', {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                            },
                                            body: JSON.stringify({ vote: value }),
                                        });
                                        const data = await res.json();
                                        this.karma = data.karma;
                                        this.userVote = data.user_vote;

                                    } finally {
                                        this.loading = false;
                                    }
                                }
                            }">

        {{-- Upvote --}}
        <button type="button" @click="vote(1)"
          :disabled="loading"
          :class="userVote === 1
                                        ? 'text-orange-400 bg-orange-500/10'
                                        : 'text-gray-400 hover:text-orange-400 hover:bg-orange-500/10'"
          class="relative group p-1.5 rounded-lg transition-colors">
          <svg class="w-4 h-4" :fill="userVote === 1 ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
          </svg>
          <span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded
                                             opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
            Upvote
          </span>
        </button>

        {{-- Contador --}}
        <span class="text-sm font-semibold min-w-[2rem] text-center"
          :class="karma > 0 ? 'text-orange-400' : karma < 0 ? 'text-blue-400' : 'text-gray-400'"
          x-text="karma">
        </span>

        {{-- Downvote --}}
        <button type="button" @click="vote(-1)"
          :disabled="loading"
          :class="userVote === -1
                                        ? 'text-blue-400 bg-blue-500/10'
                                        : 'text-gray-400 hover:text-blue-400 hover:bg-blue-500/10'"
          class="relative group p-1.5 rounded-lg transition-colors">
          <svg class="w-4 h-4" :fill="userVote === -1 ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
          </svg>
          <span class="absolute -top-8 left-1/2 -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded
                                             opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap pointer-events-none">
            Downvote
          </span>
        </button>
      </div>
    </div>
  </main>

  {{-- ASIDE DERECHO --}}
  <aside class="hidden xl:block w-80 px-6 py-6">
    <div class="bg-card border border-border rounded-lg p-6 sticky top-24">
      <div class="mb-4">
        <h3 class="mb-2">Bienvenido a TecNow</h3>
        <p class="text-sm text-muted-foreground">Tu comunidad, tu voz, en tiempo real.</p>
      </div>
      <div class="space-y-3 mb-6 bg-secondary rounded-lg p-4">
        @foreach ([['📝', 'Comparte ideas y recursos académicos'], ['💬', 'Comenta y participa en debates'], ['⬆️', 'Vota el mejor contenido'], ['👥', 'Únete a comunidades']] as [$icon, $text])
        <div class="flex items-start gap-3 text-sm">
          <span class="text-xl">{{ $icon }}</span>
          <span class="text-muted-foreground">{{ $text }}</span>
        </div>
        @endforeach
      </div>
      <div class="border-t border-border pt-4 mb-6">
        <h4 class="mb-3 text-sm">Reglas de la comunidad</h4>
        <ul class="text-xs text-muted-foreground space-y-2">
          @foreach (['Respeto entre todos los miembros', 'No spam ni contenido inapropiado', 'Usa las comunidades correctas', 'Verifica información antes de compartir'] as $rule)
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
          @foreach ([['Miembros activos', '2,450'], ['Publicaciones hoy', '127'], ['Comunidades', '24']] as [$label, $val])
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

{{-- MODAL crear comunidad --}}
<div x-show="showCommunityModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
  <div class="absolute inset-0 bg-black/60" @click="showCommunityModal = false"></div>
  <div class="relative bg-card border border-border rounded-lg p-6 w-full max-w-lg mx-4 z-10">
    <div class="flex items-center justify-between mb-4">
      <h3>Crear Comunidad</h3>
      <button @click="showCommunityModal = false" class="text-muted-foreground hover:text-foreground">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
    <form action="{{ route('communities.store') }}" method="POST" class="space-y-4">
      @csrf
      <input type="text" name="name" placeholder="Nombre del foro" required
        class="w-full px-3 py-2 rounded-lg border border-border bg-muted focus:border-primary focus:outline-none text-gray-900" />
      <textarea rows="2" name="description" placeholder="Descripción breve"
        class="w-full px-3 py-2 rounded-lg border border-border bg-muted focus:border-primary focus:outline-none resize-none text-gray-900"></textarea>
      <div class="flex justify-end gap-3">
        <button type="button" @click="showCommunityModal = false"
          class="px-4 py-2 rounded-lg border border-border hover:bg-muted transition-colors text-sm text-gray-900 bg-white">
          Cancelar
        </button>
        <button type="submit"
          class="px-4 py-2 rounded-lg bg-primary text-white hover:bg-blue-700 transition-colors text-sm">
          Crear
        </button>
      </div>
    </form>
  </div>
</div>

{{-- MODAL añadir admin --}}
<div x-show="showAddAdminModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center">
  <div class="absolute inset-0 bg-black/60" @click="showAddAdminModal = false"></div>
  <div class="relative bg-card border border-border rounded-lg p-6 w-full max-w-sm mx-4 z-10">
    <h3>Añadir Administrador al Foro</h3>
    <form :action="'/communities/' + selectedCommunityId + '/add-admin'" method="POST" class="space-y-4 mt-4">
      @csrf
      <input type="text" name="username" placeholder="Username del usuario" required
        class="w-full px-3 py-2 rounded-lg border border-border bg-muted text-gray-900 focus:outline-none focus:border-primary" />
      <div class="flex justify-end gap-3">
        <button type="button" @click="showAddAdminModal = false"
          class="px-4 py-2 border rounded-lg text-sm bg-white text-black hover:bg-gray-100">Cancelar</button>
        <button type="submit"
          class="px-4 py-2 bg-primary text-white hover:bg-blue-700 rounded-lg text-sm">Añadir</button>
      </div>
    </form>
  </div>
</div>

@endsection
