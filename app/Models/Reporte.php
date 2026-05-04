<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reporte extends Model
{
  protected $table = 'reportes';

  protected $fillable = [
    'motivo',
    'descripcion',
    'estado',
    'user_id',
    'post_id',
  ];

  // Usuario que reportó
  public function usuario()
  {
    return $this->belongsTo(User::class, 'user_id');
  }

  // Publicación reportada
  public function post()
  {
    return $this->belongsTo(Post::class, 'post_id');
  }
}
