<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TokenViewLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'token_id',
        'viewed_by',
        'ip_address',
        'viewed_at',
    ];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    public function token()
    {
        return $this->belongsTo(RegistrationToken::class, 'token_id');
    }

    public function viewer()
    {
        return $this->belongsTo(User::class, 'viewed_by');
    }
}
