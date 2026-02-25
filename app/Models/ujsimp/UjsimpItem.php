<?php

namespace App\Models\Ujsimp;

use Illuminate\Database\Eloquent\Model;
use App\Models\Ujsimp\UjsimpScore;

class UjsimpItem extends Model
{
    protected $fillable = [
        'kategori',
        'urutan',
        'uraian'
    ];

    public function scores()
    {
        return $this->hasMany(UjsimpScore::class);
    }
}