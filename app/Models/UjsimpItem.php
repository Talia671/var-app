<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UjsimpItem extends Model
{
    use HasFactory;

    protected $table = 'ujsimp_master_items';

    protected $fillable = ['category', 'urutan', 'uraian', 'field_type', 'options', 'is_active'];

    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean',
    ];
}
