<?php

namespace App\Models\Ujsimp;

use Illuminate\Database\Eloquent\Model;

class UjsimpTest extends Model
{
    protected $table = 'ujsimp_tests';

    protected $fillable = [
        'nama',
        'npk',
        'perusahaan',
        'jenis_kendaraan',
        'tanggal_ujian',
        'nomor_sim',
        'jenis_sim',
        'jenis_simper',
        'workflow_status',
        'approved_by',
        'approved_at',
        'is_locked',
    ];

    protected $casts = [
        'tanggal_ujian' => 'date',
        'approved_at'   => 'datetime',
        'is_locked'     => 'boolean',
    ];

    public function scores()
    {
        return $this->hasMany(UjsimpScore::class);
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
        return in_array($this->workflow_status, ['draft','rejected']) && !$this->is_locked;
    }

    public function canBeApproved()
    {
        return $this->workflow_status === 'submitted' && !$this->is_locked;
    }
}