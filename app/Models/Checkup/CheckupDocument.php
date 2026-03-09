<?php

namespace App\Models\Checkup;

use Illuminate\Database\Eloquent\Model;

class CheckupDocument extends Model
{
    protected $table = 'checkup_documents';

    protected $fillable = [
        'security_code',
        'nama_pengemudi',
        'npk',
        'nomor_sim',
        'nomor_simper',
        'masa_berlaku',
        'no_pol',
        'no_lambung',
        'perusahaan',
        'jenis_kendaraan',
        'tanggal_pemeriksaan',
        'rekomendasi',
        'zona',
        'catatan_petugas',
        'workflow_status',
        'approved_by',
        'approved_at',
        'is_locked',
        'created_by',
        'verified_by',
        'verified_at',
        'rejected_by',
        'rejected_at',
        'rejected_reason',
    ];

    protected $casts = [
        'tanggal_pemeriksaan' => 'date',
        'approved_at' => 'datetime',
        'verified_at' => 'datetime',
        'rejected_at' => 'datetime',
        'is_locked' => 'boolean',
    ];

    public function verifier()
    {
        return $this->belongsTo(\App\Models\User::class, 'verified_by');
    }

    public function rejecter()
    {
        return $this->belongsTo(\App\Models\User::class, 'rejected_by');
    }

    /*
    |--------------------------------------------------------------------------
    | RELATION
    |--------------------------------------------------------------------------
    */

    public function results()
    {
        return $this->hasMany(CheckupResult::class);
    }

    public function photos()
    {
        return $this->hasMany(CheckupPhoto::class);
    }

    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(\App\Models\User::class, 'approved_by');
    }

    /*
    |--------------------------------------------------------------------------
    | WORKFLOW HELPER (SAMA POLA UJSIMP)
    |--------------------------------------------------------------------------
    */

    public function isDraft()
    {
        return $this->workflow_status === 'draft';
    }

    public function isSubmitted()
    {
        return $this->workflow_status === 'submitted';
    }

    public function isApproved()
    {
        return $this->workflow_status === 'approved';
    }

    public function isRejected()
    {
        return $this->workflow_status === 'rejected';
    }

    public function canBeEdited()
    {
        return in_array($this->workflow_status, ['draft', 'rejected']) && ! $this->is_locked;
    }

    public function canBeApproved()
    {
        return $this->workflow_status === 'submitted' && ! $this->is_locked;
    }
}
