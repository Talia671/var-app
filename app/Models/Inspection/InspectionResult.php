<?php

namespace App\Models\Inspection;

use Illuminate\Database\Eloquent\Model;

class InspectionResult extends Model
{
    protected $fillable = [
        'document_id',
        'inspection_item_id',
        'nilai_huruf',
        'nilai_angka',
        'status',
        'tindakan',
    ];

    public function item()
    {
        return $this->belongsTo(InspectionItem::class, 'inspection_item_id');
    }
}
