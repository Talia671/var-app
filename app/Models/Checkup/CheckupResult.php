<?php

namespace App\Models\Checkup;

use Illuminate\Database\Eloquent\Model;

class CheckupResult extends Model
{
    protected $table = 'checkup_results';

    protected $fillable = [
        'checkup_document_id',
        'checkup_item_id',
        'hasil',
        'tindakan_perbaikan',
    ];

    public function document()
    {
        return $this->belongsTo(CheckupDocument::class, 'checkup_document_id');
    }

    public function item()
    {
        return $this->belongsTo(CheckupItem::class, 'checkup_item_id');
    }
}
