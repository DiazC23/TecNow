<header style="background:#1e40af; border-bottom:1px solid #1d3fa0;" class="sticky top-0 z-50">
  <div class="max-w-[1400px] mx-auto px-6 py-3 flex items-center justify-between">

    {{-- Logo + búsqueda --}}
    <div class="flex items-center gap-8">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg flex items-center justify-center" style="background:rgba(255,255,255,0.15)">
          <span class="text-xl font-bold text-white">T</span>
        </div>
        <div>
          <p class="text-lg font-medium leading-tight text-white">TecNow</p>
          <p class="text-xs" style="color:rgba(255,255,255,0.6)">TSJ Lagos</p>
        </div>
      </div>

      <div class="hidden md:flex relative">
        <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4" style="color:rgba(255,255,255,0.5)"
          fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M21 21l-4.35-4.35M17 11A6 6 0 1 1 5 11a6 6 0 0 1 12 0z" />
        </svg>
        <input type="text" placeholder="Buscar en TecNow..."
          style="background:rgba(255,255,255,0.12); color:#fff; border:1px solid rgba(255,255,255,0.2);"
          class="pl-10 pr-4 py-2 rounded-lg w-80 focus:outline-none focus:border-white/50 placeholder-white/40 text-sm transition-colors" />
      </div>
    </div>

    {{-- Acciones --}}
    <div class="flex items-center gap-2">

      {{-- Campana --}}
      <button class="relative p-2 rounded-lg transition-colors" style="color:rgba(255,255,255,0.8)"
        onmouseover="this.style.background='rgba(255,255,255,0.12)'"
        onmouseout="this.style.background='transparent'">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
        </svg>
        <span class="absolute top-1 right-1 w-2 h-2 rounded-full" style="background:#fff"></span>
      </button>

      {{-- Usuario --}}
      <a href="{{ route('perfil') }}"
        class="flex items-center gap-3 px-3 py-2 rounded-lg transition-colors"
        style="color:#fff"
        onmouseover="this.style.background='rgba(255,255,255,0.12)'"
        onmouseout="this.style.background='transparent'">
        <div class="w-8 h-8 rounded-full overflow-hidden border-2 relative" style="border-color:rgba(255,255,255,0.5)">
          <img src="{{ asset('avatars/' . Auth::user()->avatar) }}" class="w-full h-full object-cover" />
          @if(Auth::user()->marco)
          <img src="{{ asset('marcos/' . Auth::user()->marco) }}"
            class="absolute inset-0 w-full h-full object-cover z-10" />
          @endif
        </div>
        <div class="hidden lg:block">
          <p class="text-sm leading-tight text-white">{{ Auth::user()->name }}</p>
          <p class="text-xs" style="color:rgba(255,255,255,0.6)">&#64;{{ Auth::user()->username }}</p>
        </div>
      </a>

      {{-- Cerrar sesión --}}
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit"
          class="text-xs hidden lg:block transition-colors px-2 py-1 rounded"
          style="color:rgba(255,255,255,0.7)"
          onmouseover="this.style.color='#fff'"
          onmouseout="this.style.color='rgba(255,255,255,0.7)'">
          Cerrar sesión
        </button>
      </form>

    </div>
  </div>
</header>