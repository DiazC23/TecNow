@extends('layouts.app')

@section('content')

<style>
  .ap-shell {
    background: #f4f6f9;
    min-height: 100vh;
  }

  /* TOPBAR */
  .ap-topbar {
    background: #1e40af;
    border-bottom: 1px solid #1d3fa0;
    padding: 0 24px;
    height: 56px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    position: sticky;
    top: 0;
    z-index: 50;
  }

  .ap-brand {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .ap-brand-icon {
    width: 36px;
    height: 36px;
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.15);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    font-weight: 700;
    color: #fff;
  }

  .ap-brand-name {
    font-size: 15px;
    font-weight: 600;
    color: #fff;
    line-height: 1.2;
  }

  .ap-brand-sub {
    font-size: 11px;
    color: rgba(255, 255, 255, 0.6);
  }

  .ap-topbar-right {
    display: flex;
    align-items: center;
    gap: 16px;
  }

  .ap-topbar-link {
    font-size: 12px;
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    transition: color .15s;
  }

  .ap-topbar-link:hover {
    color: #fff;
  }

  .ap-logout-btn {
    background: none;
    border: none;
    font-size: 12px;
    color: rgba(255, 255, 255, 0.7);
    cursor: pointer;
    transition: color .15s;
    padding: 0;
  }

  .ap-logout-btn:hover {
    color: #fff;
  }

  /* CONTENT */
  .ap-content {
    max-width: 1400px;
    margin: 0 auto;
    padding: 28px 24px;
  }

  /* BREADCRUMB */
  .ap-breadcrumb {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: #9ca3af;
    margin-bottom: 20px;
  }

  .ap-breadcrumb a {
    color: #9ca3af;
    text-decoration: none;
    transition: color .15s;
  }

  .ap-breadcrumb a:hover {
    color: #1e40af;
  }

  .ap-breadcrumb svg {
    width: 14px;
    height: 14px;
    opacity: .5;
  }

  /* PAGE HEADER */
  .ap-page-title {
    font-size: 22px;
    font-weight: 600;
    color: #111827;
  }

  .ap-page-sub {
    font-size: 13px;
    color: #6b7280;
    margin-top: 4px;
  }

  /* TOOLBAR */
  .ap-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 20px;
  }

  .ap-search-input {
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 13px;
    border: 1px solid #e5e7eb;
    background: #fff;
    color: #111827;
    outline: none;
    width: 220px;
    transition: border-color .15s;
  }

  .ap-search-input::placeholder {
    color: #9ca3af;
  }

  .ap-search-input:focus {
    border-color: #1e40af;
  }

  .ap-select {
    padding: 8px 12px;
    border-radius: 8px;
    font-size: 13px;
    border: 1px solid #e5e7eb;
    background: #fff;
    color: #111827;
    outline: none;
    cursor: pointer;
    transition: border-color .15s;
  }

  .ap-select:focus {
    border-color: #1e40af;
  }

  .ap-btn-primary {
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 500;
    background: #1e40af;
    color: #fff;
    border: none;
    cursor: pointer;
    transition: background .15s;
  }

  .ap-btn-primary:hover {
    background: #1d4ed8;
  }

  .ap-btn-secondary {
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 13px;
    background: #fff;
    color: #6b7280;
    border: 1px solid #e5e7eb;
    text-decoration: none;
    transition: background .15s;
  }

  .ap-btn-secondary:hover {
    background: #f3f4f6;
  }

  /* ALERTS */
  .ap-alert-success {
    margin-bottom: 20px;
    padding: 12px 16px;
    border-radius: 8px;
    border: 1px solid #16a34a;
    background: #f0fdf4;
    color: #15803d;
    font-size: 13px;
  }

  /* EMPTY STATE */
  .ap-empty {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 48px 24px;
    text-align: center;
  }

  .ap-empty svg {
    width: 44px;
    height: 44px;
    color: #d1d5db;
    margin: 0 auto 12px;
  }

  .ap-empty p {
    font-size: 13px;
    color: #9ca3af;
  }

  /* POST CARDS */
  .ap-post-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 16px 18px;
    margin-bottom: 10px;
    transition: border-color .15s;
  }

  .ap-post-card:hover {
    border-color: #d1d5db;
  }

  .ap-post-card.fijada {
    border-color: #fbbf24;
    background: #fffbeb;
  }

  .ap-post-inner {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 16px;
  }

  .ap-post-body {
    flex: 1;
    min-width: 0;
  }

  .ap-badge-fijada {
    display: inline-flex;
    align-items: center;
    gap: 4px;
    font-size: 11px;
    padding: 2px 8px;
    border-radius: 20px;
    margin-bottom: 6px;
    background: #fef3c7;
    color: #d97706;
    font-weight: 500;
  }

  .ap-post-title {
    font-size: 14px;
    font-weight: 600;
    color: #111827;
    text-decoration: none;
    display: block;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    transition: color .15s;
  }

  .ap-post-title:hover {
    color: #1e40af;
  }

  .ap-post-meta {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
    margin-top: 4px;
  }

  .ap-post-meta span {
    font-size: 11px;
    color: #9ca3af;
  }

  .ap-post-meta .name {
    color: #374151;
  }

  .ap-post-meta .sep {
    color: #d1d5db;
  }

  .ap-post-excerpt {
    font-size: 11px;
    color: #9ca3af;
    margin-top: 6px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }

  /* ACTION BUTTONS */
  .ap-actions {
    display: flex;
    align-items: center;
    gap: 6px;
    flex-shrink: 0;
  }

  .ap-action-btn {
    position: relative;
    padding: 7px;
    border-radius: 8px;
    background: none;
    border: none;
    cursor: pointer;
    transition: background .15s;
  }

  .ap-action-btn svg {
    width: 15px;
    height: 15px;
    display: block;
  }

  .ap-action-btn .tooltip {
    position: absolute;
    bottom: calc(100% + 6px);
    left: 50%;
    transform: translateX(-50%);
    background: #1f2937;
    color: #fff;
    font-size: 10px;
    padding: 3px 7px;
    border-radius: 5px;
    white-space: nowrap;
    pointer-events: none;
    opacity: 0;
    transition: opacity .15s;
  }

  .ap-action-btn:hover .tooltip {
    opacity: 1;
  }

  .ap-btn-pin {
    color: #9ca3af;
  }

  .ap-btn-pin:hover {
    background: #fef3c7;
    color: #d97706;
  }

  .ap-btn-pin.active {
    background: #fef3c7;
    color: #d97706;
  }

  .ap-btn-del {
    color: #ef4444;
  }

  .ap-btn-del:hover {
    background: #fee2e2;
  }
</style>

<div class="ap-shell">

  {{-- TOPBAR --}}
  <header class="ap-topbar">
    <div class="ap-brand">
      <div class="ap-brand-icon">T</div>
      <div>
        <div class="ap-brand-name">TecNow</div>
        <div class="ap-brand-sub">Panel de Administración</div>
      </div>
    </div>
    <div class="ap-topbar-right">
      <a href="{{ route('admin.index') }}" class="ap-topbar-link">← Dashboard</a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="ap-logout-btn">Cerrar sesión</button>
      </form>
    </div>
  </header>

  <div class="ap-content">

    {{-- Breadcrumb --}}
    <nav class="ap-breadcrumb">
      <a href="{{ route('dashboard') }}">Inicio</a>
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
      <a href="{{ route('admin.index') }}">Administración</a>
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
      <span style="color:#6b7280">Publicaciones</span>
    </nav>

    {{-- Header + filtros --}}
    <div class="ap-toolbar">
      <div>
        <h1 class="ap-page-title">Gestión de Publicaciones</h1>
        <p class="ap-page-sub">Fija posts destacados y modera el contenido del foro.</p>
      </div>
      <form method="GET" action="{{ route('admin.posts') }}" style="display:flex;gap:8px;flex-wrap:wrap;align-items:center">
        <input type="text" name="buscar" value="{{ request('buscar') }}"
          placeholder="Buscar publicación..." class="ap-search-input">
        <select name="filtro" onchange="this.form.submit()" class="ap-select">
          <option value="" {{ request('filtro') === ''        ? 'selected' : '' }}>Todos</option>
          <option value="fijados" {{ request('filtro') === 'fijados' ? 'selected' : '' }}>Solo fijados</option>
        </select>
        <button type="submit" class="ap-btn-primary">Buscar</button>
        @if(request('buscar') || request('filtro'))
        <a href="{{ route('admin.posts') }}" class="ap-btn-secondary">Limpiar</a>
        @endif
      </form>
    </div>

    {{-- Alerta éxito --}}
    @if(session('success'))
    <div class="ap-alert-success">{{ session('success') }}</div>
    @endif

    {{-- Sin resultados --}}
    @if($posts->isEmpty())
    <div class="ap-empty">
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
      </svg>
      <p>No hay publicaciones que mostrar.</p>
    </div>

    @else
    {{-- Lista de posts --}}
    @foreach($posts as $post)
    <div class="ap-post-card {{ $post->fijada ? 'fijada' : '' }}">
      <div class="ap-post-inner">
        <div class="ap-post-body">
          @if($post->fijada)
          <span class="ap-badge-fijada">📌 Fijado</span>
          @endif
          <a href="{{ route('posts.show', $post) }}" target="_blank" class="ap-post-title">
            {{ $post->title }}
          </a>
          <div class="ap-post-meta">
            <span>Por</span>
            <span class="name">{{ $post->user?->name ?? 'Desconocido' }}</span>
            <span class="sep">·</span>
            <span>{{ $post->created_at->format('d/m/Y') }}</span>
            <span class="sep">·</span>
            <span>💬 {{ $post->comments_count }} comentario{{ $post->comments_count !== 1 ? 's' : '' }}</span>
            <span class="sep">·</span>
            <span>↑ {{ $post->votes_count }} voto{{ $post->votes_count !== 1 ? 's' : '' }}</span>
          </div>
          <p class="ap-post-excerpt">{{ $post->content }}</p>
        </div>

        <div class="ap-actions">
          {{-- Fijar / Desfijar --}}
          <form action="{{ route('admin.posts.fijar', $post) }}" method="POST">
            @csrf @method('PATCH')
            <button type="submit" class="ap-action-btn ap-btn-pin {{ $post->fijada ? 'active' : '' }}"
              title="{{ $post->fijada ? 'Desfijar' : 'Fijar' }}">
              <svg fill="{{ $post->fijada ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z" />
              </svg>
              <span class="tooltip">{{ $post->fijada ? 'Desfijar' : 'Fijar' }}</span>
            </button>
          </form>

          {{-- Eliminar --}}
          <form action="{{ route('admin.posts.eliminar', $post) }}" method="POST"
            onsubmit="return confirm('¿Eliminar esta publicación? Esta acción es permanente.')">
            @csrf @method('DELETE')
            <button type="submit" class="ap-action-btn ap-btn-del" title="Eliminar">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
              </svg>
              <span class="tooltip">Eliminar</span>
            </button>
          </form>
        </div>
      </div>
    </div>
    @endforeach

    <div class="mt-6">{{ $posts->links() }}</div>
    @endif

  </div>
</div>
@endsection