@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center p-4"
        style="background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 40%, #000000 100%);">
        <div class="w-full max-w-md">

            {{-- Logo arriba --}}
            <div class="text-center mb-8">
                <div class="bg-white w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-2xl">
                    <span class="text-4xl font-bold text-primary">T</span>
                </div>
                <h1 class="text-4xl font-bold text-white mb-2">TecNow</h1>
                <p class="text-blue-200">Tecnológico Superior de Jalisco</p>
                <p class="text-blue-300 text-sm mt-1">Tu comunidad, tu voz, en tiempo real</p>
            </div>

            {{-- Card --}}
            <div class="bg-white rounded-2xl shadow-2xl p-8">
                <h2 class="text-2xl font-bold text-center text-gray-900 mb-6">Iniciar Sesión</h2>

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3 mb-5">
                        {{ $errors->first() }}
                    </div>
                @endif

                @if (session('status'))
                    <div class="bg-green-50 border border-green-200 text-green-700 text-sm rounded-lg px-4 py-3 mb-5">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label class="block text-sm mb-2 text-gray-700">Correo institucional</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <input type="email" name="email" value="{{ old('email') }}"
                                placeholder="tucorreo@tecmm.edu.mx"
                                class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all text-gray-900" />
                        </div>
                    </div>
                    <div x-data="{ show: false }">
                        <label class="block text-sm mb-2 text-gray-700">Contraseña</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            <input :type="show ? 'text' : 'password'" name="password" placeholder="••••••••"
                                class="w-full pl-11 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none transition-all text-gray-900" />
                            <button type="button" @click="show = !show"
                                class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600">
                                <svg x-show="!show" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="show" class="w-5 h-5" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-primary" />
                            <span class="text-gray-600">Recordarme</span>
                        </label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('recover.show') }}" class="text-sm text-primary hover:underline">¿Olvidaste tu
                                contraseña?</a>
                        @endif
                    </div>
                    <button type="submit"
                        class="w-full justify-center hover:scale-105 transition-transform text-sm flex items-center gap-2 px-4 py-2 rounded-lg font-medium"
                        style="border: 3px solid #1e40af; background-color: #1e40af; color: white;">
                        Iniciar Sesión
                    </button>
                </form>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <p class="text-center text-sm text-gray-600">
                        ¿No tienes cuenta?
                        <a href="{{ route('register') }}" class="text-primary hover:underline font-medium">
                            Regístrate con tu correo institucional
                        </a>
                    </p>
                </div>

                <div class="mt-4 space-y-2">
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <span>Solo correos @instituto.tecmm.edu.mx</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <div class="w-2 h-2 bg-primary rounded-full"></div>
                        <span>Acceso verificado por la institución</span>
                    </div>
                </div>
            </div>

            <p class="text-center text-xs text-blue-200 mt-6">
                Al iniciar sesión, aceptas nuestros términos de servicio y política de privacidad
            </p>
        </div>
    </div>
@endsection
