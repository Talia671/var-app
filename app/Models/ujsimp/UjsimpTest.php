<?php

namespace App\Models\Ujsimp;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UjsimpTest extends Model
{
    protected $table = 'ujsimp_tests';

    protected $fillable = [
        'security_code',
        'petugas_id',
        'nama',
        'npk',
        'perusahaan',
        'jenis_kendaraan',
        'tanggal_ujian',
        'nomor_sim',
        'jenis_sim',
        'jenis_simper',
        'status',
        'nilai_total',
        'nilai_rata_rata',
        'catatan_penguji',
        'workflow_status',
        'submitted_by',
        'submitted_at',
        'verified_by',
        'verified_at',
        'approved_by',
        'approved_at',
        'is_locked',
        'rejected_by',
        'rejected_at',
        'rejected_reason',
    ];

    protected $casts = [
        'tanggal_ujian' => 'date',
        'submitted_at' => 'datetime',
        'verified_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'is_locked' => 'boolean',
    ];

    public function submitter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'submitted_by');
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function rejecter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'rejected_by');
    }

    public function scores()
    {
        return $this->hasMany(UjsimpScore::class);
    }

    public function checker(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    // Alias for standardization
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
    }

    public function examiner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'petugas_id');
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

    public function isVerified()
    {
        return $this->workflow_status === 'verified';
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

    public function canBeVerified()
    {
        return $this->workflow_status === 'submitted';
    }

    public function canBeApproved()
    {
        return $this->workflow_status === 'verified' && ! $this->is_locked;
    }
}
