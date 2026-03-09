@extends('layouts.petugas')

@section('content')

<div class="container-page">

    <div class="page-header">
        <h1 class="page-title">
            Form RANMOR Kendaraan
        </h1>
    </div>

    <div class="card-ui">

        <form action="{{ route('petugas.ranmor.store') }}" method="POST">
            @csrf

            <!-- SECURITY CODE SECTION -->
            <div class="card-section bg-indigo-50 border border-indigo-200 rounded-xl mb-6">
                <label class="form-label text-indigo-800 font-bold mb-2">Security Code Identity</label>
                <div class="flex gap-2">
                    <input type="text" id="security_code" name="security_code" class="form-control border-indigo-300" placeholder="S-PKT-XXXXXX" required autocomplete="off">
                </div>
                <div id="security_code_feedback" class="mt-2 text-sm"></div>
                
                <div id="user_info" class="hidden mt-4 bg-white p-4 rounded-lg border border-gray-200">
                    <div class="grid grid-cols-[auto_1fr] gap-x-4 gap-y-2 items-center">
                        <span class="text-gray-500 text-sm">Registered Name:</span>
                        <span id="user_name" class="font-bold text-gray-900">-</span>
                        
                        <span class="text-gray-500 text-sm">Account Status:</span>
                        <span id="user_status" class="font-bold">-</span>
                    </div>
                </div>
            </div>

            <div class="card-section">
                <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2">Data Pengemudi & Kendaraan</h3>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Lokasi Kerja (Zonasi)</label>
                        <select name="zona" class="form-control" required>
                            <option value="">-- Pilih Zona --</option>
                            <option value="zona1">Zona 1</option>
                            <option value="zona2">Zona 2</option>
                        </select>
                    </div>
    
                    <div class="form-group">
                        <label class="form-label">Nomor Polisi / Sertifikat</label>
                        <input type="text" name="no_pol" placeholder="Contoh: KT-1548 YW" class="form-control" required>
                    </div>
    
                    <div class="form-group">
                        <label class="form-label">Nomor Lambung</label>
                        <input type="text" name="no_lambung" placeholder="Contoh: ACI-01" class="form-control" required>
                    </div>
    
                    <div class="form-group">
                        <label class="form-label">Tahun Pembuatan</label>
                        <input type="text" name="tahun_pembuatan" placeholder="Tahun" class="form-control">
                    </div>
    
                    <div class="form-group">
                        <label class="form-label">Warna</label>
                        <input type="text" name="warna" placeholder="Warna" class="form-control">
                    </div>
    
                    <div class="form-group">
                        <label class="form-label">Perusahaan / Departemen</label>
                        <input type="text" name="perusahaan" placeholder="Nama Perusahaan" class="form-control">
                    </div>
    
                    <div class="form-group">
                        <label class="form-label">Merk Kendaraan</label>
                        <input type="text" name="merk_kendaraan" placeholder="Contoh: Mitsubishi Xpander" class="form-control">
                    </div>
    
                    <div class="form-group">
                        <label class="form-label">Jenis Kendaraan</label>
                        <input type="text" name="jenis_kendaraan" placeholder="Jenis Kendaraan" class="form-control">
                    </div>
    
                    <div class="form-group">
                        <label class="form-label">Status Kepemilikan</label>
                        <input type="text" name="status_kepemilikan" placeholder="Status Kepemilikan" class="form-control">
                    </div>
    
                    <div class="form-group">
                        <label class="form-label">Nomor Rangka</label>
                        <input type="text" name="no_rangka" placeholder="Nomor Rangka" class="form-control">
                    </div>
    
                    <div class="form-group">
                        <label class="form-label">Nomor Mesin</label>
                        <input type="text" name="no_mesin" placeholder="Nomor Mesin" class="form-control">
                    </div>
    
                    <div class="form-group">
                        <label class="form-label">Pengemudi / Operator</label>
                        <input type="text" name="pengemudi" placeholder="Nama Pengemudi" class="form-control" required>
                    </div>
    
                    <div class="form-group">
                        <label class="form-label">NPK</label>
                        <input type="text" name="npk" placeholder="Nomor Pokok Karyawan" class="form-control" required>
                    </div>
    
                    <div class="form-group">
                        <label class="form-label">Nomor SIM / SIO</label>
                        <input type="text" name="nomor_sim" placeholder="Nomor SIM" class="form-control">
                    </div>
    
                    <div class="form-group">
                        <label class="form-label">Nomor SIMPER / SIOPER</label>
                        <input type="text" name="nomor_simper" placeholder="Nomor SIMPER" class="form-control">
                    </div>
    
                    <div class="form-group">
                        <label class="form-label">Masa Berlaku SIMPER / SIOPER</label>
                        <input type="text" name="masa_berlaku" placeholder="Contoh: JUNI 2026" class="form-control">
                    </div>
    
                    <div class="form-group">
                        <label class="form-label">Tanggal Periksa</label>
                        <input type="date" name="tanggal_periksa" class="form-control" required>
                    </div>
                </div>
            </div>

            <div class="card-section mt-6">
                <h3 class="font-bold text-lg mb-4 text-gray-800 border-b pb-2">Temuan & Catatan</h3>

                <div class="form-group">
                    <label class="form-label">Yang Perlu Dilengkapi (Temuan)</label>
                    <div id="findings-container" class="space-y-3 mb-3">
                        <div class="flex gap-2">
                            <input type="text" name="uraian[]" placeholder="Uraian temuan..." class="form-control">
                            <button type="button" onclick="removeField(this)" class="btn-ui btn-danger">
                                Hapus
                            </button>
                        </div>
                    </div>
    
                    <button type="button" onclick="addField()" class="btn-ui btn-secondary">
                        + Tambah Baris Temuan
                    </button>
                </div>
    
                <div class="form-group mt-4">
                    <label class="form-label">Catatan Tambahan (Opsional)</label>
                    <textarea name="catatan_petugas" rows="3" class="form-control" placeholder="Masukkan catatan tambahan jika ada..."></textarea>
                </div>
            </div>

            <div class="flex justify-between mt-6">
                <a href="{{ route('petugas.ranmor.index') }}" class="btn-ui btn-secondary">
                    ← Kembali
                </a>
                <button type="submit" class="btn-ui btn-primary">
                    Simpan Draft
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function addField() {
        const container = document.getElementById('findings-container');
        const div = document.createElement('div');
        div.className = 'flex gap-2';
        div.innerHTML = `
            <input type="text" name="uraian[]" placeholder="Uraian temuan..." class="form-control">
            <button type="button" onclick="removeField(this)" class="btn-ui btn-danger">
                Hapus
            </button>
        `;
        container.appendChild(div);
    }

    function removeField(button) {
        button.parentElement.remove();
    }
</script>

@endsection

@push('scripts')
<script>
    let lookupTimeout;
    const securityCodeInput = document.getElementById('security_code');
    const feedback = document.getElementById('security_code_feedback');
    const userInfo = document.getElementById('user_info');
    const submitBtn = document.querySelector('button[type="submit"]');
    
    const nameField = document.querySelector('input[name="pengemudi"]');
    const npkField = document.querySelector('input[name="npk"]');
    const deptField = document.querySelector('input[name="perusahaan"]');

    if (securityCodeInput) {
        securityCodeInput.addEventListener('input', function() {
            clearTimeout(lookupTimeout);
            const code = this.value.trim();

            if (code.length < 12) {
                feedback.innerHTML = '';
                userInfo.style.display = 'none';
                if(submitBtn) submitBtn.disabled = true;
                return;
            }

            feedback.innerHTML = '<span style="color: #6366f1;">Checking identity...</span>';
            
            lookupTimeout = setTimeout(async () => {
                try {
                    const response = await fetch(`/api/identity/${code}?module=ranmor`, {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    const data = await response.json();

                    if (data.status === 'valid') {
                        feedback.innerHTML = '<span style="color: #059669; font-weight: 600; background: #ecfdf5; padding: 4px 12px; border-radius: 20px; border: 1px solid #10b981;">✓ VALID IDENTITY</span>';
                        document.getElementById('user_name').textContent = data.data.name;
                        document.getElementById('user_status').innerHTML = '<span style="color: #059669; font-weight: bold;">ACTIVE</span>';
                        userInfo.style.display = 'block';
                        
                        // Auto-fill
                        if (nameField) nameField.value = data.data.name;
                        if (npkField) npkField.value = data.data.npk || '';
                        if (deptField) deptField.value = data.data.department || '';
                        
                        if(submitBtn) submitBtn.disabled = false;
                    } 
                    else if (data.status === 'suspended') {
                        feedback.innerHTML = '<span style="color: #dc2626; font-weight: 600; background: #fef2f2; padding: 4px 12px; border-radius: 20px; border: 1px solid #ef4444;">⚠ SUSPENDED</span>';
                        document.getElementById('user_name').textContent = data.data?.name || '-';
                        document.getElementById('user_status').innerHTML = `<span style="color: #dc2626; font-weight: bold;">SUSPENDED UNTIL ${data.retry_date}</span>`;
                        userInfo.style.display = 'block';
                        if(submitBtn) submitBtn.disabled = true;
                    }
                    else if (data.status === 'duplicate') {
                        feedback.innerHTML = '<span style="color: #d97706; font-weight: 600; background: #fffbeb; padding: 4px 12px; border-radius: 20px; border: 1px solid #f59e0b;">⚠ DUPLICATE EXAM</span>';
                        document.getElementById('user_name').textContent = data.data?.name || '-';
                        document.getElementById('user_status').innerHTML = '<span style="color: #d97706; font-weight: bold;">ACTIVE EXAM EXISTS</span>';
                        userInfo.style.display = 'block';
                        if(submitBtn) submitBtn.disabled = true;
                    }
                    else if (data.status === 'not_found') {
                        feedback.innerHTML = '<span style="color: #6b7280; font-weight: 600; background: #f3f4f6; padding: 4px 12px; border-radius: 20px; border: 1px solid #9ca3af;">✕ NOT FOUND</span>';
                        userInfo.style.display = 'none';
                        if(submitBtn) submitBtn.disabled = true;
                    }
                    else {
                        feedback.innerHTML = '<span class="text-red-600">Invalid security code format</span>';
                        userInfo.style.display = 'none';
                        if(submitBtn) submitBtn.disabled = true;
                    }
                } catch (error) {
                    console.error('Identity lookup error:', error);
                    feedback.innerHTML = '<span class="text-red-600">Connection error</span>';
                }
            }, 500);
        });
    }
</script>
@endpush
