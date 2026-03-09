<?php

namespace App\Models\Simper;

use Illuminate\Database\Eloquent\Model;

class SimperResult extends Model
{
    protected $table = 'simper_results';

    protected $fillable = [
        'simper_document_id',
        'simper_item_id',
        'nilai_huruf',
        'nilai_angka',
    ];
}
