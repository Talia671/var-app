<?php

namespace App\Models\Ranmor;

use Illuminate\Database\Eloquent\Model;

class RanmorFinding extends Model
{
    protected $fillable = [
        'ranmor_document_id',
        'uraian',
    ];

    public function document()
    {
        return $this->belongsTo(RanmorDocument::class, 'ranmor_document_id');
    }
}
