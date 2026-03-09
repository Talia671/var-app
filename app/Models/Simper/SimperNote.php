<?php

namespace App\Models\Simper;

use Illuminate\Database\Eloquent\Model;

class SimperNote extends Model
{
    protected $table = 'simper_notes';

    protected $fillable = [
        'simper_document_id',
        'no_urut',
        'uraian',
    ];

    // Property accessor for compatibility with view
    public function getDescriptionAttribute()
    {
        return $this->attributes['uraian'] ?? null;
    }

    public function document()
    {
        return $this->belongsTo(SimperDocument::class);
    }
}
