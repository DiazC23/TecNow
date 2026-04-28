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
            <h2 class="text-2xl font-bold text-center text-gray-900 mb-6">Verifica tu identidad</h2>

            @if ($errors->any())
            <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3 mb-5">
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="{{ route('recover.reset') }}" class="space-y-4">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}" />

                <div class="bg-blue-50 border border-blue-200 rounded-lg px-4 py-3">
                    <p class="text-sm text-blue-800 font-medium">{{ $question }}</p>
                </div>

                <div>
                    <label class="block text-sm mb-2 text-gray-700">Tu respuesta</label>
                    <input type="text" name="answer" value="{{ old('answer') }}"
                        placeholder="Escribe tu respuesta..."
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary outline-none text-gray-900" />
                    <p class="text-xs text-gray-400 mt-1">No distingue mayúsculas ni minúsculas.</p>
                </div>

                <div>
                    <label class="block text-sm mb-2 text-gray-700">Nueva contraseña</label>
                    <input type="password" name="password" placeholder="Mínimo 8 caracteres"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary outline-none text-gray-900" />
                </div>

                <div>
                    <label class="block text-sm mb-2 text-gray-700">Confirmar nueva contraseña</label>
                    <input type="password" name="password_confirmation" placeholder="Repite tu contraseña"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary outline-none text-gray-900" />
                </div>

                <button type="submit" class="w-full py-3 rounded-lg text-white font-medium transition-transform hover:scale-105"
                    style="background-color: #1e40af;">
                    Cambiar contraseña
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-sm text-primary hover:underline">← Volver al login</a>
            </div>
        </div>
    </div>
</div>
@endsection