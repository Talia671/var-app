<?php

namespace App\Models\Simper;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimperItem extends Model
{
    use HasFactory;

    protected $table = 'simper_items';

    protected $fillable = [
        'name',
        'category',
        'field_type',
        'options',
        'is_active',
        'urutan',
    ];

    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean',
    ];
}
