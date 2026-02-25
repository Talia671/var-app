<?php

namespace App\Models\Simper;

use Illuminate\Database\Eloquent\Model;

class SimperDocument extends Model
{
    protected $table = 'simper_documents';

    protected $fillable = [
        'template_id',
        'petugas_id',
        'zona',
        'nama',
        'npk',
        'perusahaan',
        'jenis_kendaraan',
        'nomor_sim',
        'jenis_sim',
        'jenis_simper',
        'tanggal_uji',
        'penguji_nama',
        'catatan_umum',
        'status',
        'workflow_status',
        'is_locked',
        'approved_by',
        'approved_at',
        'rejected_by',
        'rejected_reason',
        'rejected_at',
        'data_json'
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'tanggal_uji' => 'date',
        'data_json' => 'array'
    ];

    // Property accessors for compatibility with view
    public function getNameAttribute()
    {
        return $this->attributes['nama'] ?? null;
    }

    public function getCompanyAttribute()
    {
        return $this->attributes['perusahaan'] ?? null;
    }

    public function getVehicleTypeAttribute()
    {
        return $this->attributes['jenis_kendaraan'] ?? null;
    }

    public function getSimNumberAttribute()
    {
        return $this->attributes['nomor_sim'] ?? null;
    }

    public function getSimTypeAttribute()
    {
        return $this->attributes['jenis_sim'] ?? null;
    }

    public function getSimperTypeAttribute()
    {
        return $this->attributes['jenis_simper'] ?? null;
    }

    public function getTestDateAttribute()
    {
        return $this->attributes['tanggal_uji'] ?? null;
    }

    public function getZona1Attribute()
    {
        $zona = $this->attributes['zona'] ?? '';
        return strpos($zona, 'zona_1') !== false || strpos($zona, '1') !== false;
    }

    public function getZona2Attribute()
    {
        $zona = $this->attributes['zona'] ?? '';
        return strpos($zona, 'zona_2') !== false || strpos($zona, '2') !== false;
    }

    public function notes()
    {
        return $this->hasMany(SimperNote::class);
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
