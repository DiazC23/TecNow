@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center p-4" style="background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 40%, #000000 100%);">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="bg-white w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-2xl">
                <span class="text-4xl font-bold text-primary">T</span>
            </div>
            <h1 class="text-4xl font-bold text-white mb-2">TecNow</h1>
            <p class="text-blue-200">Recuperar contraseña</p>
        </div>

        <div class="bg-white rounded-2xl shadow-2xl p-8">
            <h2 class="text-2xl font-bold text-center text-gray-900 mb-2">Recuperar contraseña</h2>
            <p class="text-sm text-gray-500 text-center mb-6">Ingresa tu correo institucional para continuar.</p>

            @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3 mb-5">
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('recover.find') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm mb-2 text-gray-700">Correo institucional</label>
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                        <input type="email" name="email" value="{{ old('email') }}"
                            placeholder="tucorreo@lagos.tecmm.edu.mx"
                            class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary outline-none text-gray-900" />
                    </div>
                </div>
                <button type="submit" class="w-full py-3 rounded-lg text-white font-medium transition-transform hover:scale-105"
                    style="background-color: #1e40af;">
                    Continuar
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-sm text-primary hover:underline">← Volver al login</a>
            </div>
        </div>
    </div>
</div>
@endsection