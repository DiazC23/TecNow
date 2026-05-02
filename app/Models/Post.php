<?php

/*
 * Modelo para gestionar la información de los modelos.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'content'
    ];

    public function communities(): BelongsToMany
    {
        return $this->belongsToMany(Community::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
