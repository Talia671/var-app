<?php

namespace App\Models\Checkup;

use Illuminate\Database\Eloquent\Model;

class CheckupItem extends Model
{
    protected $table = 'checkup_items';

    protected $fillable = [
        'uraian',
        'urutan',
    ];

    public function results()
    {
        return $this->hasMany(CheckupResult::class);
    }
}