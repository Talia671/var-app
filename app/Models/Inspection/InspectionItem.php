<?php

namespace App\Models\Inspection;

use Illuminate\Database\Eloquent\Model;

class InspectionItem extends Model
{
    protected $fillable = [
        'module',
        'kategori',
        'urutan',
        'uraian',
        'is_active',
    ];

    public function results()
    {
        return $this->hasMany(InspectionResult::class);
    }
}
