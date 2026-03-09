<?php

namespace App\Models\Ujsimp;

use Illuminate\Database\Eloquent\Model;

class UjsimpScore extends Model
{
    protected $fillable = [
        'ujsimp_test_id',
        'ujsimp_item_id',
        'nilai_huruf',
        'nilai_angka',
    ];

    public function test()
    {
        return $this->belongsTo(UjsimpTest::class);
    }

    public function item()
    {
        return $this->belongsTo(UjsimpItem::class);
    }
}
