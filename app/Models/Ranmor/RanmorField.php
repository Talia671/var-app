<?php

namespace App\Models\Ranmor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RanmorField extends Model
{
    use HasFactory;

    protected $table = 'ranmor_fields';

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
