<?php

namespace App\Models\Ranmor;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class RanmorDocument extends Model
{
    protected $fillable = [
        'zona',
        'no_pol',
        'no_lambung',
        'tahun_pembuatan',
        'warna',
        'perusahaan',
        'merk_kendaraan',
        'jenis_kendaraan',
        'no_rangka',
        'no_mesin',
        'status_kepemilikan',
        'pengemudi',
        'npk',
        'nomor_sim',
        'nomor_simper',
        'masa_berlaku',
        'tanggal_periksa',
        'workflow_status',
        'is_locked',
        'approved_by',
        'approved_at',
        'created_by',
    ];

    protected $casts = [
        'tanggal_periksa' => 'date',
        'approved_at' => 'datetime',
        'is_locked' => 'boolean',
    ];

    public function findings()
    {
        return $this->hasMany(RanmorFinding::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /*
    |--------------------------------------------------------------------------
    | WORKFLOW HELPERS
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
        return in_array($this->workflow_status, ['draft', 'rejected']) && !$this->is_locked;
    }

    public function canBeApproved()
    {
        return $this->workflow_status === 'submitted' && !$this->is_locked;
    }
}