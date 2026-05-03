<?php

use App\Models\Post;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->double('hot_score', 15, 8)->default(0)->after('content')->index();
        });

        // Recalcular hot_score para publicaciones existentes
        Post::chunk(100, function ($posts) {
            foreach ($posts as $post) {
                $post->updateHotScore();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropIndex(['hot_score']);
            $table->dropColumn('hot_score');
        });
    }
};
