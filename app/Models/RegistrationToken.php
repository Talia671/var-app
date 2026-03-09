<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

class RegistrationToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'token_lookup',
        'token_hash',
        'token_encrypted',
        'created_by',
        'status',
        'expires_at',
        'used_by',
        'used_at',
        'used_by_security_code',
    ];

    protected $casts = [
        'used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'used_by');
    }

    public function viewLogs()
    {
        return $this->hasMany(TokenViewLog::class, 'token_id');
    }

    /**
     * Check if the token is expired.
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Get the effective status, checking expiration.
     */
    public function getEffectiveStatusAttribute()
    {
        if ($this->status === 'active' && $this->isExpired()) {
            return 'expired';
        }
        return $this->status;
    }
}
