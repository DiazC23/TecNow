@extends('layouts.app')

@section('content')

<x-navbar />

{{-- BREADCRUMB --}}
<div class="max-w-[1400px] mx-auto px-6 py-4">
  <div class="flex items-center gap-2 text-sm text-gray-400">
    <a href="{{ route('dashboard') }}" class="hover:text-white transition-colors">Inicio</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
    <a href="{{ route('perfil') }}" class="hover:text-white transition-colors">Mi Perfil</a>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
    </svg>
    <span class="text-gray-700">Editar publicación</span>
  </div>
</div>

{{-- MAIN --}}
<div class="max-w-[1400px] mx-auto px-6 pb-12">
  <div class="max-w-2xl mx-auto" x-data="postForm()">

    {{-- Título de página --}}
    <div class="mb-6">
      <h1 class="text-2xl font-bold text-white">Editar publicación</h1>
      <p class="text-sm text-gray-400 mt-1">Modifica el contenido de tu publicación</p>
    </div>

    {{-- Errores de validación --}}
    @if($errors->any())
    <div class="mb-6 bg-red-400/20 border border-red-700 font-bold rounded-lg p-4">
      <p class="text-sm font-semibold text-red-400 mb-2">Por favor corrige los siguientes errores:</p>
      <ul class="text-sm text-red-500 space-y-1 list-disc list-inside">
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    {{-- FORMULARIO --}}
    <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
      @csrf
      @method('PUT')

      {{-- Tarjeta principal --}}
      <div class="bg-card border border-border rounded-lg overflow-hidden">

        {{-- Info del autor --}}
        <div class="flex items-center gap-3 px-5 py-4 border-b border-border">
          <div class="w-10 h-10 rounded-full overflow-hidden border-2 border-primary relative flex-shrink-0">
            <img src="{{ asset('avatars/' . Auth::user()->avatar) }}" class="w-full h-full object-cover" />
            @if(Auth::user()->marco)
            <img src="{{ asset('marcos/' . Auth::user()->marco) }}" class="absolute inset-0 w-full h-full object-cover z-10" />
            @endif
          </div>
          <div>
            <p class="text-sm font-semibold text-gray-700">{{ Auth::user()->name }}</p>
            <p class="text-xs text-gray-400">&#64;{{ Auth::user()->username }}</p>
          </div>
          {{-- Indicador de edición --}}
          <span class="ml-auto text-xs text-yellow-500 border border-yellow-600 rounded-full px-2 py-0.5">
            Editando
          </span>
        </div>

        <div class="p-5 space-y-4">

          {{-- Título --}}
          <div>
            <label class="block text-sm font-medium text-gray-400 mb-1.5">
              Título <span class="text-red-400">*</span>
            </label>
            <input
              type="text"
              name="title"
              value="{{ old('title', $post->title) }}"
              placeholder="{{ old('title', $post->title ) }}"
              maxlength="150"
              required
              class="w-full px-4 py-2.5 rounded-lg border bg-gray-100 text-gray-800 placeholder-gray-400 focus:outline-none focus:border-primary transition-colors
                                       {{ $errors->has('title') ? 'border-red-500' : 'border-border' }}" />
            @error('title')
            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
          </div>

          {{-- Contenido --}}
          <div>
            <label class="block text-sm font-medium text-gray-400 mb-1.5">
              Contenido <span class="text-red-400">*</span>
            </label>
            <textarea
              name="content"
              rows="6"
              placeholder="{{ old('content', $post->content )  }}"
              required
              class="w-full px-4 py-2.5 rounded-lg border bg-gray-100 text-gray-800 placeholder-gray-400 focus:outline-none focus:border-primary transition-colors resize-none
                                       {{ $errors->has('content') ? 'border-red-500' : 'border-border' }}">{{ old('content', $post->content) }}</textarea>
            <div class="flex justify-between mt-1">
              @error('content')
              <p class="text-xs text-red-400">{{ $message }}</p>
              @else
              <span></span>
              @enderror
              <p class="text-xs text-gray-500 text-right" x-text="content.length + ' caracteres'"></p>
            </div>
          </div>

          {{-- Imagen (opcional) --}}
          <div>
            <label class="block text-sm font-medium text-gray-400 mb-1.5">
              Imagen <span class="text-gray-500 font-normal">(opcional)</span>
            </label>

            {{-- Zona de drop --}}
            <div
              class="relative border-2 border-dashed rounded-lg transition-colors cursor-pointer
                                       {{ $errors->has('image') ? 'border-red-500' : 'border-border hover:border-primary' }}"
              @click="$refs.imageInput.click()"
              @dragover.prevent="dragging = true"
              @dragleave.prevent="dragging = false"
              @drop.prevent="handleDrop($event)"
              :class="dragging ? 'border-primary bg-primary/5' : ''">
              {{-- Preview --}}
              <div x-show="preview" class="relative">
                <img :src="preview" class="w-full max-h-64 object-cover rounded-lg" />
                <button
                  type="button"
                  @click.stop="clearImage()"
                  class="absolute top-2 right-2 bg-black/70 hover:bg-black text-white rounded-full p-1.5 transition-colors">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                  </svg>
                </button>
              </div>

              {{-- Placeholder --}}
              <div x-show="!preview" class="flex flex-col items-center justify-center py-8 px-4 text-center">
                <svg class="w-10 h-10 text-gray-600 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <p class="text-sm text-gray-400">Arrastra una imagen o <span class="text-primary">haz clic para seleccionar</span></p>
                <p class="text-xs text-gray-600 mt-1">PNG, JPG, GIF, WEBP — máx. 2 MB</p>
              </div>

              <input
                type="file"
                name="image"
                accept="image/*"
                class="hidden"
                x-ref="imageInput"
                @change="handleFile($event)" />
            </div>

            @error('image')
            <p class="text-xs text-red-400 mt-1">{{ $message }}</p>
            @enderror
          </div>

        </div>
      </div>

      {{-- Acciones --}}
      <div class="flex items-center justify-between gap-3">
        <a href="{{ route('perfil') }}"
          class="px-5 py-2.5 rounded-lg border border-gray-500 text-gray-500 hover:bg-gray-800 hover:border-gray-800 hover:text-gray-100 transition-colors text-sm">
          Cancelar
        </a>
        <button
          type="submit"
          class="px-6 py-2.5 rounded-lg bg-primary border border-gray-500 text-gray-500 hover:bg-blue-700 hover:text-white hover:border-blue-700 transition-colors text-sm font-medium flex items-center gap-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M5 13l4 4L19 7" />
          </svg>
          Guardar cambios
        </button>
      </div>

    </form>
  </div>
</div>

{{-- Alpine component --}}
<script>
  function postForm() {
    return {
      content: '{{ old('
      content ', addslashes($post->content)) }}',
      preview: null,
      dragging: false,

      handleFile(event) {
        const file = event.target.files[0];
        if (file) this.loadPreview(file);
      },

      handleDrop(event) {
        this.dragging = false;
        const file = event.dataTransfer.files[0];
        if (file && file.type.startsWith('image/')) {
          const dt = new DataTransfer();
          dt.items.add(file);
          this.$refs.imageInput.files = dt.files;
          this.loadPreview(file);
        }
      },

      loadPreview(file) {
        const reader = new FileReader();
        reader.onload = (e) => {
          this.preview = e.target.result;
        };
        reader.readAsDataURL(file);
      },

      clearImage() {
        this.preview = null;
        this.$refs.imageInput.value = '';
      }
    }
  }
</script>

@endsection