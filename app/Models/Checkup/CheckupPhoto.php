<?php

namespace App\Models\Checkup;

use Illuminate\Database\Eloquent\Model;

class CheckupPhoto extends Model
{
    protected $table = 'checkup_photos';

    protected $fillable = [
        'checkup_document_id',
        'file_path',
    ];

    public function document()
    {
        return $this->belongsTo(CheckupDocument::class,'checkup_document_id');
    }
}