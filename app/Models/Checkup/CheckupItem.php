<?php

namespace App\Models\Checkup;

use Illuminate\Database\Eloquent\Model;

class CheckupItem extends Model
{
    protected $table = 'checkup_items';

    protected $fillable = [
        'item_number',
        'item_name',
        'standard',
        'category',
        'field_type',
        'options',
        'is_active',
    ];

    protected $casts = [
        'options' => 'array',
        'is_active' => 'boolean',
    ];

    public function results()
    {
        return $this->hasMany(CheckupResult::class);
    }
}
