@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center p-4"
        style="background: linear-gradient(135deg, #1e40af 0%, #1d4ed8 40%, #000000 100%);">
        <div class="w-full max-w-md">

            <div class="text-center mb-8">
                <div class="bg-white w-20 h-20 rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-2xl">
                    <span class="text-4xl font-bold text-primary">T</span>
                </div>
                <h1 class="text-4xl font-bold text-white mb-2">TecNow</h1>
                <p class="text-blue-200">Tecnológico Superior de Jalisco</p>
                <p class="text-blue-300 text-sm mt-1">Tu comunidad, tu voz, en tiempo real</p>
            </div>

            <div class="bg-white rounded-2xl shadow-2xl p-8">
                <h2 class="text-2xl font-bold text-center text-gray-900 mb-6">Crear cuenta</h2>

                @if ($errors->any())
                    <div class="bg-red-50 border border-red-200 text-red-700 text-sm rounded-lg px-4 py-3 mb-5">
                        <ul class="space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>• {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register') }}" class="space-y-4" id="registerForm">
                    @csrf

                    <div class="flex flex-col items-center mb-6 gap-4">
                        <p class="text-sm font-medium text-gray-700">Personaliza tu perfil</p>
                        <div class="flex gap-6 items-center">
                            <div class="relative text-center">
                                <p class="text-xs text-gray-500 mb-1">Avatar</p>
                                <div class="relative w-20 h-20">
                                    <img id="avatarPreview" src="/avatars/{{ $avatars[0] ?? 'avatar_default.png' }}"
                                        class="w-full h-full rounded-full border-4 border-primary object-cover shadow-md" />
                                    <button type="button"
                                        onclick="document.getElementById('avatarModal').classList.remove('hidden')"
                                        class="absolute bottom-0 right-0 bg-primary text-white w-7 h-7 rounded-full flex items-center justify-center shadow hover:scale-110 transition-transform z-20">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 012.828 0l.172.172a2 2 0 010 2.828L12 15H9v-3z" />
                                        </svg>
                                    </button>
                                </div>
                                <input type="hidden" name="avatar" id="avatarField" value="{{ $avatars[0] ?? 'avatar_default.png' }}" />
                            </div>

                            <div class="relative text-center">
                                <p class="text-xs text-gray-500 mb-1">Marco</p>
                                <div class="relative w-20 h-20 bg-gray-100 rounded-full border-4 border-gray-200">
                                    <img id="marcoPreview" src=""
                                        class="w-full h-full object-cover z-10 hidden" />
                                    <button type="button"
                                        onclick="document.getElementById('marcoModal').classList.remove('hidden')"
                                        class="absolute bottom-0 right-0 bg-primary text-white w-7 h-7 rounded-full flex items-center justify-center shadow hover:scale-110 transition-transform z-20">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 012.828 0l.172.172a2 2 0 010 2.828L12 15H9v-3z" />
                                        </svg>
                                    </button>
                                </div>
                                <input type="hidden" name="marco" id="marcoField" value="" />
                            </div>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm mb-2 text-gray-700">Nombre completo</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            <input type="text" name="name" value="{{ old('name') }}"
                                placeholder="Tu nombre completo"
                                class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none text-gray-900" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm mb-2 text-gray-700">Username</label>
                        <div class="relative">
                            <span
                                class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 font-medium text-sm">@</span>
                            <input type="text" name="username" value="{{ old('username') }}" placeholder="tu_username"
                                class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none text-gray-900" />
                        </div>
                        <p class="text-xs text-gray-400 mt-1">Solo letras, números y guión bajo. Mínimo 3 caracteres.</p>
                    </div>

                    <div>
                        <label class="block text-sm mb-2 text-gray-700">Correo institucional</label>
                        <div class="relative">
                            <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <input type="email" name="email" value="{{ old('email') }}"
                                placeholder="tucorreo@lagos.tecmm.edu.mx"
                                class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none text-gray-900" />
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm mb-2 text-gray-700">Contraseña</label>
                        <input type="password" name="password" placeholder="Mínimo 8 caracteres"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none text-gray-900" />
                    </div>

                    <div>
                        <label class="block text-sm mb-2 text-gray-700">Confirmar contraseña</label>
                        <input type="password" name="password_confirmation" placeholder="Repite tu contraseña"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none text-gray-900" />
                    </div>

                    {{-- Pregunta de seguridad --}}
                    <div class="border-t border-gray-200 pt-4 mt-2">
                        <p class="text-sm font-medium text-gray-700 mb-1">Pregunta de seguridad</p>
                        <p class="text-xs text-amber-600 bg-amber-50 border border-amber-200 rounded-lg px-3 py-2 mb-3">
                            ⚠️ Recuerda exactamente tu respuesta — la usarás para recuperar tu contraseña si la olvidas.
                        </p>
                        <div class="space-y-3">
                            <select name="security_question"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none text-gray-900 text-sm">
                                <option value="">Selecciona una pregunta...</option>
                                @foreach (['¿Cuál es el nombre de tu mascota?', '¿En qué ciudad naciste?', '¿Cuál es el nombre de tu escuela primaria?', '¿Cuál es tu película favorita?', '¿Cuál es el apellido de tu madre?'] as $q)
                                    <option value="{{ $q }}"
                                        {{ old('security_question') === $q ? 'selected' : '' }}>{{ $q }}</option>
                                @endforeach
                            </select>
                            <div class="relative">
                                <svg class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 w-5 h-5" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                <input type="text" name="security_answer" value="{{ old('security_answer') }}"
                                    placeholder="Tu respuesta (no distingue mayúsculas)"
                                    class="w-full pl-11 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary outline-none text-gray-900" />
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-primary text-white py-3 rounded-lg hover:bg-blue-800 transition-colors font-medium">
                        Crear cuenta
                    </button>
                </form>

                <div class="mt-6 pt-6 border-t border-gray-200 text-center">
                    <p class="text-sm text-gray-600">
                        ¿Ya tienes cuenta?
                        <a href="{{ route('login') }}" class="text-primary hover:underline font-medium">Inicia sesión</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal avatares --}}
    <div id="avatarModal" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-black/60"
            onclick="document.getElementById('avatarModal').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm z-10">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-gray-900">Elige tu avatar</h3>
                <button type="button" onclick="document.getElementById('avatarModal').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="grid grid-cols-4 gap-3">
                @foreach ($avatars as $avatar)
                    <button type="button" onclick="selectAvatar('{{ $avatar }}')"
                        class="rounded-full overflow-hidden aspect-square hover:ring-4 hover:ring-primary hover:ring-offset-2 transition-all">
                        <img src="/avatars/{{ $avatar }}" class="w-full h-full object-cover" />
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    {{-- Modal marcos --}}
    <div id="marcoModal" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4">
        <div class="absolute inset-0 bg-black/60"
            onclick="document.getElementById('marcoModal').classList.add('hidden')"></div>
        <div class="relative bg-white rounded-2xl shadow-2xl p-6 w-full max-w-sm z-10">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-bold text-gray-900">Elige tu marco</h3>
                <button type="button" onclick="document.getElementById('marcoModal').classList.add('hidden')"
                    class="text-gray-400 hover:text-gray-600">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="grid grid-cols-4 gap-3">
                <button type="button" onclick="selectMarco('')" class="rounded-full flex items-center justify-center bg-gray-100 text-gray-500 text-xs aspect-square hover:ring-4 hover:ring-primary hover:ring-offset-2 transition-all">
                    Ninguno
                </button>
                @foreach ($marcos as $marco)
                    <button type="button" onclick="selectMarco('{{ $marco }}')"
                        class="rounded-full overflow-hidden aspect-square hover:ring-4 hover:ring-primary hover:ring-offset-2 transition-all bg-gray-100">
                        <img src="/marcos/{{ $marco }}" class="w-full h-full object-cover" />
                    </button>
                @endforeach
            </div>
        </div>
    </div>

    <script>
        function selectAvatar(filename) {
            document.getElementById('avatarPreview').src = '/avatars/' + filename;
            document.getElementById('avatarField').value = filename;
            document.getElementById('avatarModal').classList.add('hidden');
        }
        function selectMarco(filename) {
            let preview = document.getElementById('marcoPreview');
            if (filename) {
                preview.src = '/marcos/' + filename;
                preview.classList.remove('hidden');
            } else {
                preview.src = '';
                preview.classList.add('hidden');
            }
            document.getElementById('marcoField').value = filename;
            document.getElementById('marcoModal').classList.add('hidden');
        }
    </script>

@endsection
