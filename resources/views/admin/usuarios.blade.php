@extends('layouts.app')

@section('content')

<style>
  .au-shell {
    background: #f4f6f9;
    min-height: 100vh;
  }

  /* TOPBAR */
  .au-topbar {
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

  .au-brand {
    display: flex;
    align-items: center;
    gap: 12px;
  }

  .au-brand-icon {
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

  .au-brand-name {
    font-size: 15px;
    font-weight: 600;
    color: #fff;
    line-height: 1.2;
  }

  .au-brand-sub {
    font-size: 11px;
    color: rgba(255, 255, 255, 0.6);
  }

  .au-topbar-right {
    display: flex;
    align-items: center;
    gap: 16px;
  }

  .au-topbar-link {
    font-size: 12px;
    color: rgba(255, 255, 255, 0.7);
    text-decoration: none;
    transition: color .15s;
  }

  .au-topbar-link:hover {
    color: #fff;
  }

  .au-logout-btn {
    background: none;
    border: none;
    font-size: 12px;
    color: rgba(255, 255, 255, 0.7);
    cursor: pointer;
    transition: color .15s;
    padding: 0;
  }

  .au-logout-btn:hover {
    color: #fff;
  }

  /* CONTENT */
  .au-content {
    max-width: 1400px;
    margin: 0 auto;
    padding: 28px 24px;
  }

  /* BREADCRUMB */
  .au-breadcrumb {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 12px;
    color: #9ca3af;
    margin-bottom: 20px;
  }

  .au-breadcrumb a {
    color: #9ca3af;
    text-decoration: none;
    transition: color .15s;
  }

  .au-breadcrumb a:hover {
    color: #1e40af;
  }

  .au-breadcrumb svg {
    width: 14px;
    height: 14px;
    opacity: .5;
  }

  /* PAGE HEADER */
  .au-page-title {
    font-size: 22px;
    font-weight: 600;
    color: #111827;
  }

  .au-page-sub {
    font-size: 13px;
    color: #6b7280;
    margin-top: 4px;
  }

  /* TOOLBAR */
  .au-toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 12px;
    margin-bottom: 20px;
  }

  .au-search-input {
    padding: 8px 14px;
    border-radius: 8px;
    font-size: 13px;
    border: 1px solid #e5e7eb;
    background: #fff;
    color: #111827;
    outline: none;
    width: 230px;
    transition: border-color .15s;
  }

  .au-search-input::placeholder {
    color: #9ca3af;
  }

  .au-search-input:focus {
    border-color: #1e40af;
  }

  .au-btn-primary {
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

  .au-btn-primary:hover {
    background: #1d4ed8;
  }

  .au-btn-secondary {
    padding: 8px 16px;
    border-radius: 8px;
    font-size: 13px;
    background: #fff;
    color: #6b7280;
    border: 1px solid #e5e7eb;
    text-decoration: none;
    transition: background .15s;
  }

  .au-btn-secondary:hover {
    background: #f3f4f6;
  }

  /* ALERTS */
  .au-alert-success {
    margin-bottom: 16px;
    padding: 12px 16px;
    border-radius: 8px;
    border: 1px solid #16a34a;
    background: #f0fdf4;
    color: #15803d;
    font-size: 13px;
  }

  .au-alert-error {
    margin-bottom: 16px;
    padding: 12px 16px;
    border-radius: 8px;
    border: 1px solid #dc2626;
    background: #fef2f2;
    color: #dc2626;
    font-size: 13px;
  }

  /* TABLE CARD */
  .au-table-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    overflow: hidden;
  }

  .au-table {
    width: 100%;
    font-size: 13px;
    border-collapse: collapse;
  }

  .au-table thead tr {
    border-bottom: 1px solid #f3f4f6;
  }

  .au-table thead th {
    text-align: left;
    padding: 12px 18px;
    font-size: 11px;
    font-weight: 600;
    color: #9ca3af;
    letter-spacing: .06em;
    text-transform: uppercase;
    background: #f9fafb;
  }

  .au-table thead th.center {
    text-align: center;
  }

  .au-table tbody tr {
    border-bottom: 1px solid #f3f4f6;
    transition: background .15s;
  }

  .au-table tbody tr:last-child {
    border-bottom: none;
  }

  .au-table tbody tr:hover {
    background: #f9fafb;
  }

  .au-table td {
    padding: 12px 18px;
    vertical-align: middle;
  }

  .au-table td.center {
    text-align: center;
  }

  /* USER CELL */
  .au-user-cell {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .au-avatar-wrap {
    position: relative;
    width: 36px;
    height: 36px;
    flex-shrink: 0;
  }

  .au-avatar-wrap img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    border: 1px solid #e5e7eb;
  }

  .au-avatar-wrap .marco {
    position: absolute;
    inset: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
    z-index: 10;
    pointer-events: none;
  }

  .au-user-name {
    font-size: 13px;
    font-weight: 500;
    color: #111827;
    line-height: 1.3;
  }

  .au-user-username {
    font-size: 11px;
    color: #9ca3af;
  }

  /* EMAIL */
  .au-email {
    font-size: 12px;
    color: #6b7280;
  }

  /* ROL SELECT */
  .au-rol-select {
    padding: 5px 10px;
    border-radius: 7px;
    font-size: 12px;
    border: 1px solid #e5e7eb;
    background: #fff;
    color: #374151;
    outline: none;
    cursor: pointer;
    transition: border-color .15s;
  }

  .au-rol-select:focus {
    border-color: #1e40af;
  }

  .au-rol-select:disabled {
    opacity: .5;
    cursor: not-allowed;
    background: #f9fafb;
  }

  /* POSTS COUNT */
  .au-posts-count {
    font-size: 13px;
    color: #6b7280;
    font-weight: 500;
  }

  /* STATUS BADGES */
  .au-badge-activo {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 3px 9px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 500;
    background: #dcfce7;
    color: #16a34a;
  }

  .au-badge-activo span {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #16a34a;
  }

  .au-badge-suspendido {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    padding: 3px 9px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 500;
    background: #fee2e2;
    color: #dc2626;
  }

  .au-badge-suspendido span {
    width: 6px;
    height: 6px;
    border-radius: 50%;
    background: #dc2626;
  }

  /* ACTION BUTTONS */
  .au-btn-suspend {
    padding: 6px 12px;
    border-radius: 7px;
    font-size: 12px;
    font-weight: 500;
    border: 1px solid #fca5a5;
    color: #dc2626;
    background: #fff;
    cursor: pointer;
    transition: background .15s;
  }

  .au-btn-suspend:hover {
    background: #fee2e2;
  }

  .au-btn-reactivate {
    padding: 6px 12px;
    border-radius: 7px;
    font-size: 12px;
    font-weight: 500;
    border: 1px solid #86efac;
    color: #16a34a;
    background: #fff;
    cursor: pointer;
    transition: background .15s;
  }

  .au-btn-reactivate:hover {
    background: #dcfce7;
  }

  .au-self-label {
    font-size: 12px;
    color: #9ca3af;
    font-style: italic;
  }

  /* EMPTY ROW */
  .au-empty-row td {
    padding: 40px 18px;
    text-align: center;
    font-size: 13px;
    color: #9ca3af;
  }
</style>

<div class="au-shell">

  {{-- TOPBAR --}}
  <header class="au-topbar">
    <div class="au-brand">
      <div class="au-brand-icon">T</div>
      <div>
        <div class="au-brand-name">TecNow</div>
        <div class="au-brand-sub">Panel de Administración</div>
      </div>
    </div>
    <div class="au-topbar-right">
      <a href="{{ route('admin.index') }}" class="au-topbar-link">← Dashboard</a>
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="au-logout-btn">Cerrar sesión</button>
      </form>
    </div>
  </header>

  <div class="au-content">

    {{-- Breadcrumb --}}
    <nav class="au-breadcrumb">
      <a href="{{ route('dashboard') }}">Inicio</a>
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
      <a href="{{ route('admin.index') }}">Administración</a>
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
      </svg>
      <span style="color:#6b7280">Usuarios</span>
    </nav>

    {{-- Header + buscador --}}
    <div class="au-toolbar">
      <div>
        <h1 class="au-page-title">Gestión de Usuarios</h1>
        <p class="au-page-sub">Administra roles y accesos de la comunidad TecNow.</p>
      </div>
      <form method="GET" action="{{ route('admin.usuarios') }}" style="display:flex;gap:8px;align-items:center">
        <input type="text" name="buscar" value="{{ request('buscar') }}"
          placeholder="Buscar usuario..." class="au-search-input">
        <button type="submit" class="au-btn-primary">Buscar</button>
        @if(request('buscar'))
        <a href="{{ route('admin.usuarios') }}" class="au-btn-secondary">Limpiar</a>
        @endif
      </form>
    </div>

    {{-- Alertas --}}
    @if(session('success'))
    <div class="au-alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="au-alert-error">{{ session('error') }}</div>
    @endif

    {{-- Tabla --}}
    <div class="au-table-card">
      <div style="overflow-x:auto">
        <table class="au-table">
          <thead>
            <tr>
              <th>Usuario</th>
              <th class="hidden md:table-cell">Correo</th>
              <th>Rol</th>
              <th class="center hidden lg:table-cell">Posts</th>
              <th>Estado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody>
            @forelse($usuarios as $usuario)
            <tr>
              {{-- Usuario --}}
              <td>
                <div class="au-user-cell">
                  <div class="au-avatar-wrap">
                    <img src="{{ asset('avatars/' . $usuario->avatar) }}" alt="{{ $usuario->name }}" />
                    @if($usuario->marco)
                    <img src="{{ asset('marcos/' . $usuario->marco) }}" class="marco" alt="" />
                    @endif
                  </div>
                  <div>
                    <div class="au-user-name">{{ $usuario->name }}</div>
                    <div class="au-user-username">&#64;{{ $usuario->username }}</div>
                  </div>
                </div>
              </td>

              {{-- Correo --}}
              <td class="hidden md:table-cell">
                <span class="au-email">{{ $usuario->email }}</span>
              </td>

              {{-- Rol --}}
              <td>
                <form action="{{ route('admin.usuarios.rol', $usuario) }}" method="POST">
                  @csrf @method('PATCH')
                  <select name="rol" onchange="this.form.submit()" class="au-rol-select"
                    {{ $usuario->id === Auth::id() ? 'disabled' : '' }}>
                    <option value="estudiante" {{ $usuario->rol === 'estudiante' ? 'selected' : '' }}>Estudiante</option>
                    <option value="docente" {{ $usuario->rol === 'docente'    ? 'selected' : '' }}>Docente</option>
                    <option value="admin" {{ $usuario->rol === 'admin'      ? 'selected' : '' }}>Admin</option>
                  </select>
                </form>
              </td>

              {{-- Posts --}}
              <td class="center hidden lg:table-cell">
                <span class="au-posts-count">{{ $usuario->posts_count }}</span>
              </td>

              {{-- Estado --}}
              <td>
                @if($usuario->activo)
                <span class="au-badge-activo"><span></span>Activo</span>
                @else
                <span class="au-badge-suspendido"><span></span>Suspendido</span>
                @endif
              </td>

              {{-- Acciones --}}
              <td>
                @if($usuario->id !== Auth::id())
                <form action="{{ route('admin.usuarios.suspender', $usuario) }}" method="POST"
                  onsubmit="return confirm('¿{{ $usuario->activo ? 'Suspender' : 'Reactivar' }} a {{ $usuario->name }}?')">
                  @csrf @method('PATCH')
                  <button type="submit"
                    class="{{ $usuario->activo ? 'au-btn-suspend' : 'au-btn-reactivate' }}">
                    {{ $usuario->activo ? 'Suspender' : 'Reactivar' }}
                  </button>
                </form>
                @else
                <span class="au-self-label">Tú</span>
                @endif
              </td>
            </tr>
            @empty
            <tr class="au-empty-row">
              <td colspan="6">No se encontraron usuarios.</td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    <div class="mt-6">{{ $usuarios->links() }}</div>

  </div>
</div>
@endsection