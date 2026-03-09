<?php

namespace App\Models\Ujsimp;

use Illuminate\Database\Eloquent\Model;

class UjsimpItem extends Model
{
    protected $fillable = [
        'kategori',
        'urutan',
        'uraian',
    ];

    public function scores()
    {
        return $this->hasMany(UjsimpScore::class);
    }
}
