<?php

namespace App\Models\Checkup;

use Illuminate\Database\Eloquent\Model;

class CheckupDocument extends Model
{
    protected $table = 'checkup_documents';

    protected $fillable = [
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
        'workflow_status',
        'approved_by',
        'approved_at',
        'is_locked',
        'created_by',
    ];

    protected $casts = [
        'tanggal_pemeriksaan' => 'date',
        'approved_at' => 'datetime',
        'is_locked' => 'boolean',
    ];

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
        return in_array($this->workflow_status, ['draft','rejected']) && !$this->is_locked;
    }

    public function canBeApproved()
    {
        return $this->workflow_status === 'submitted' && !$this->is_locked;
    }
}