@extends('layouts.app')

@section('content')
<x-navbar />

{{-- BREADCRUMB --}}
<div class="max-w-[1400px] mx-auto px-6 py-4">
  <div class="flex items-center gap-2 text-sm text-gray-400">
    <a href="{{ route('dashboard') }}" class="hover:text-blue-400 transition-colors">Inicio</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>

    <span class="text-gray-700">{{ $user->name }}</span>
  </div>
</div>

<div class="max-w-4xl mx-auto px-4 py-8">

  {{-- Tarjeta principal --}}
  <div class="bg-card border border-border rounded-xl overflow-hidden mb-6">

    {{-- Banner --}}
    @php
    $bannerColors = [
    'avatar_amarillo.png' => 'linear-gradient(135deg, #b45309 0%, #fbbf24 100%)',
    'avatar_azul.png' => 'linear-gradient(135deg, #1e40af 0%, #60a5fa 100%)',
    'avatar_gris.png' => 'linear-gradient(135deg, #374151 0%, #9ca3af 100%)',
    'avatar_morado.png' => 'linear-gradient(135deg, #6b21a8 0%, #c084fc 100%)',
    'avatar_naranja.png' => 'linear-gradient(135deg, #c2410c 0%, #fb923c 100%)',
    'avatar_negro.png' => 'linear-gradient(135deg, #111827 0%, #4b5563 100%)',
    'avatar_rojo.png' => 'linear-gradient(135deg, #991b1b 0%, #f87171 100%)',
    'avatar_verde.png' => 'linear-gradient(135deg, #166534 0%, #4ade80 100%)',
    'avatar_default.png' => 'linear-gradient(135deg, #1e40af 0%, #60a5fa 100%)',
    ];
    $bannerStyle =
    $bannerColors[$user->avatar] ?? 'linear-gradient(135deg, #1e40af 0%, #60a5fa 100%)';
    @endphp

    <div class="h-32" style="background: {{ $bannerStyle }};"></div>


    {{-- Info --}}
    <div class="px-6 pb-6">
      <div class="flex items-end justify-between -mt-12 mb-4 flex-wrap gap-4">
        <div class="relative w-24 h-24">
          <img src="{{ asset('avatars/' . $user->avatar) }}"
            class="w-full h-full rounded-full border-4 border-white object-cover shadow-md" />
          @if($user->marco)
          <img src="{{ asset('marcos/' . $user->marco) }}" class="absolute inset-0 w-full h-full z-10 pointer-events-none" />
          @endif
        </div>
      </div>

      <h1 class="text-xl font-bold text-foreground">{{ $user->name }}</h1>
      <p class="text-muted-foreground text-sm mb-1">&#64;{{ $user->username }}</p>
      <p class="text-muted-foreground text-sm mb-4">{{ $user->email }}</p>

      <div class="flex items-center gap-2 text-xs text-muted-foreground">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
        </svg>
        Miembro desde {{ $user->created_at->format('d/m/Y') }}
      </div>
    </div>
  </div>

  {{-- Stats representativas --}}
  <div class="grid grid-cols-3 gap-4 mb-6">
    @foreach ([[$postsCount, 'Publicaciones'], [$likesCount, 'Likes'], [$commentsCount, 'Comentarios']] as [$num, $label])
    <div class="bg-card border border-border rounded-xl p-4 text-center">
      <p class="text-2xl font-bold text-primary">{{ $num }}</p>
      <p class="text-xs text-muted-foreground mt-1">{{ $label }}</p>
    </div>
    @endforeach
  </div>

  {{-- Publicaciones del usuario --}}
  <div class="bg-card border border-border rounded-xl p-6">
    <div class="mb-4">
      <h2 class="text-base font-semibold">Publicaciones</h2>
    </div>

    @if($posts->isEmpty())
    {{-- Estado vacío --}}
    <div class="text-center py-10">
      <svg class="w-10 h-10 text-muted-foreground mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
          d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
      </svg>
      <p class="text-muted-foreground text-sm">Este usuario aún no tiene publicaciones.</p>
    </div>
    @else
    {{-- Lista de posts --}}
    <div class="space-y-4">
      @foreach($posts as $post)
      <div class="border border-border rounded-lg p-4 hover:bg-muted/30 transition-colors">
        <div class="flex items-start justify-between gap-3">
          <div class="flex-1 min-w-0">
            {{-- Título --}}
            <a href="{{ route('posts.show', $post) }}">
              <h3 class="text-lg font-bold mb-2 hover:text-primary transition-colors">{{ $post->title }}</h3>
            </a>

            {{-- Contenido --}}
            <a href="{{ route('posts.show', $post) }}">
              <p class="text-xs text-gray-400 mt-1 line-clamp-2">{{ $post->content }}</p>
            </a>

            <p class="text-xs text-muted-foreground mt-2">{{ $post->created_at->diffForHumans() }}</p>

            {{-- Gestor de Karma --}}
            {{-- Karma --}}
            @php
            $karma = $post->votes->sum('vote');
            $userVote = $post->votes->where('user_id', Auth::id())->first()?->vote;
            @endphp
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
            {{-- Fin del gestor de Karma--}}

          </div>
        </div>
      </div>
      @endforeach
    </div>
    @endif
  </div>
</div>
@endsection