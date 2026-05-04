<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
  public function up(): void
  {
    // Agrega rol y activo a usuarios si no existen
    Schema::table('users', function (Blueprint $table) {
      if (!Schema::hasColumn('users', 'rol')) {
        $table->enum('rol', ['estudiante', 'docente', 'admin'])->default('estudiante')->after('email');
      }
      if (!Schema::hasColumn('users', 'activo')) {
        $table->boolean('activo')->default(true)->after('rol');
      }
    });

    // Agrega fijada a posts si no existe
    Schema::table('posts', function (Blueprint $table) {
      if (!Schema::hasColumn('posts', 'fijada')) {
        $table->boolean('fijada')->default(false)->after('content');
      }
    });
  }

  public function down(): void
  {
    Schema::table('users', function (Blueprint $table) {
      $table->dropColumn(['rol', 'activo']);
    });
    Schema::table('posts', function (Blueprint $table) {
      $table->dropColumn('fijada');
    });
  }
};
