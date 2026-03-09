@extends('layouts.petugas')

@section('content')

<div class="container-page">
    <div class="card-ui">
        <h2 class="card-header text-gray-800 border-b pb-2">
            Form Checklist (Checkup)
        </h2>

        <form method="POST" action="{{ route('petugas.checkup.store') }}">
            @csrf

            <!-- SECURITY CODE SECTION -->
            <div class="bg-indigo-50 p-4 rounded-lg border border-indigo-200 mb-6">
                <div class="form-group">
                    <label class="form-label text-indigo-800">Security Code Identity</label>
                    <div class="flex gap-2">
                        <input type="text" id="security_code" name="security_code" class="flex-1" placeholder="S-PKT-XXXXXX" required autocomplete="off">
                    </div>
                    <div id="security_code_feedback" class="mt-2 text-sm"></div>
                </div>
                
                <div id="user_info" class="hidden mt-4 bg-white p-4 rounded-md border border-gray-200">
                    <div class="grid grid-cols-[auto_1fr] gap-x-4 gap-y-2 items-center text-sm">
                        <span class="text-gray-500">Registered Name:</span>
                        <span id="user_name" class="font-semibold text-gray-900">-</span>
                        
                        <span class="text-gray-500">Account Status:</span>
                        <span id="user_status" class="font-semibold">-</span>
                    </div>
                </div>
            </div>

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Nama Pengemudi</label>
                    <input type="text" name="nama_pengemudi" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Perusahaan</label>
                    <input type="text" name="perusahaan" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Departemen</label>
                    <input type="text" name="departemen" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Jenis Kendaraan</label>
                    <input type="text" name="jenis_kendaraan" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor Polisi</label>
                    <input type="text" name="nomor_polisi" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor Lambung</label>
                    <input type="text" name="nomor_lambung" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Lokasi Pemeriksaan</label>
                    <input type="text" name="lokasi_pemeriksaan" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal Pemeriksaan</label>
                    <input type="date" name="tanggal_pemeriksaan" required>
                </div>
            </div>

            <div class="card-section border-t border-gray-200 pt-6">
                <h3 class="text-md font-semibold text-gray-800 mb-4 border-l-4 border-yellow-400 pl-3">
                    Item Checklist
                </h3>

                <div class="form-group">
                    <label class="form-label">Catatan Tambahan</label>
                    <textarea name="catatan" rows="3" placeholder="Masukkan catatan jika ada..."></textarea>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-4">
                <a href="{{ route('petugas.checkup.index') }}" class="btn-ui btn-secondary">
                    Batal
                </a>
                <button type="submit" class="btn-ui btn-primary">
                    Submit Pengajuan
                </button>
            </div>
        </form>
    </div>
</div>

    .btn-back {
        background: #e5e7eb;
        padding: 8px 20px;
        border-radius: 25px;
        text-decoration: none;
        color: #333;
        font-size: 13px;
    }

    .btn-back:hover {
        background: #d1d5db;
    }

    /* Table Styles */
    .table-container {
        overflow-x: auto;
        margin-top: 15px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .custom-table th {
        background-color: #f8fafc;
        color: var(--text-dark);
        font-weight: 600;
        padding: 12px;
        border-bottom: 2px solid #e2e8f0;
        text-align: left;
    }

    .custom-table td {
        padding: 12px;
        border-bottom: 1px solid #e2e8f0;
        color: #334155;
    }

    .custom-table tr:last-child td {
        border-bottom: none;
    }

    .radio-group {
        display: flex;
        justify-content: center;
        align-items: center;
    }
    
    .radio-input {
        width: 18px;
        height: 18px;
        cursor: pointer;
    }

    @media(max-width: 992px){
        .form-grid {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media(max-width: 600px){
        .form-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="form-wrapper">

    <div class="form-card">

        <div class="form-title">
            Form CheckUp Kendaraan
        </div>

        <form action="{{ route('petugas.checkup.store') }}" 
              method="POST" 
              enctype="multipart/form-data">
            @csrf

            <!-- SECURITY CODE SECTION -->
            <div style="background: #eef2ff; padding: 20px; border-radius: 12px; border: 1px solid #c7d2fe; margin-bottom: 30px;">
                <label style="font-weight: 700; color: #3730a3; display: block; margin-bottom: 10px;">Security Code Identity</label>
                <div style="display: flex; gap: 10px;">
                    <input type="text" id="security_code" name="security_code" class="form-control" style="flex: 1; border-color: #6366f1;" placeholder="S-PKT-XXXXXX" required autocomplete="off">
                </div>
                <div id="security_code_feedback" style="margin-top: 10px; font-size: 14px;"></div>
                
                <div id="user_info" style="display: none; margin-top: 15px; background: white; padding: 15px; border-radius: 8px; border: 1px solid #e5e7eb;">
                    <div style="display: grid; grid-template-columns: auto 1fr; gap: 10px; align-items: center;">
                        <span style="color: #6b7280; font-size: 13px;">Registered Name:</span>
                        <span id="user_name" style="font-weight: 600; color: #111827;">-</span>
                        
                        <span style="color: #6b7280; font-size: 13px;">Account Status:</span>
                        <span id="user_status" style="font-weight: 600;">-</span>
                    </div>
                </div>
            </div>

            <div class="form-grid">

                <div class="form-group">
                    <label>Nama Pengemudi</label>
                    <input type="text" name="nama_pengemudi" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>NPK</label>
                    <input type="text" name="npk" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Nomor SIM</label>
                    <input type="text" name="nomor_sim" class="form-control">
                </div>

                <div class="form-group">
                    <label>Nomor SIMPER</label>
                    <input type="text" name="nomor_simper" class="form-control">
                </div>

                <div class="form-group">
                    <label>Masa Berlaku</label>
                    <input type="text" name="masa_berlaku" class="form-control">
                </div>

                <div class="form-group">
                    <label>Nomor Polisi</label>
                    <input type="text" name="no_pol" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Nomor Lambung</label>
                    <input type="text" name="no_lambung" class="form-control">
                </div>

                <div class="form-group">
                    <label>Perusahaan</label>
                    <input type="text" name="perusahaan" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Jenis Kendaraan</label>
                    <input type="text" name="jenis_kendaraan" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Tanggal Pemeriksaan</label>
                    <input type="date" name="tanggal_pemeriksaan" class="form-control" required>
                </div>

            </div>

            <div class="section-divider">
                Checklist Pemeriksaan
            </div>

            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th style="width: 50px; text-align: center;">No</th>
                            <th>Objek Pemeriksaan</th>
                            <th>Standard</th>
                            <th style="width: 80px; text-align: center;">Baik</th>
                            <th style="width: 80px; text-align: center;">Tidak Baik</th>
                            <th style="width: 250px;">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $item)
                        <tr>
                            <td style="text-align: center;">{{ $item->item_number }}</td>
                            <td>{{ $item->item_name }}</td>
                            <td>{{ $item->standard }}</td>
                            <td style="text-align: center;">
                                <div class="radio-group">
                                    <input type="radio" name="hasil[{{ $item->id }}]" value="baik" class="radio-input" required>
                                </div>
                            </td>
                            <td style="text-align: center;">
                                <div class="radio-group">
                                    <input type="radio" name="hasil[{{ $item->id }}]" value="tidak_baik" class="radio-input">
                                </div>
                            </td>
                            <td>
                                <input type="text" name="tindakan_perbaikan[{{ $item->id }}]" class="form-control" style="padding: 6px;">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="section-divider">
                Rekomendasi & Catatan
            </div>

            <div class="form-grid" style="grid-template-columns: 1fr 1fr;">
                <div class="form-group">
                    <label>Status Kendaraan</label>
                    <select name="rekomendasi" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="layak">Layak</option>
                        <option value="tidak_layak">Tidak Layak</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Zona</label>
                    <select name="zona" class="form-control">
                        <option value="">-- Pilih --</option>
                        <option value="zona1">Zona 1</option>
                        <option value="zona2">Zona 2</option>
                    </select>
                </div>
            </div>

            <div class="form-group" style="margin-top: 20px;">
                <label>Catatan Tambahan (Opsional)</label>
                <textarea name="catatan_petugas" rows="3" class="form-control" placeholder="Masukkan catatan tambahan jika ada..."></textarea>
            </div>

            <div class="section-divider">
                Upload Foto Kendaraan
            </div>

            <div class="form-group">
                <label>Foto Dokumentasi</label>
                <input type="file" name="photos[]" multiple accept=".jpg,.jpeg" class="form-control">
                <div id="photoPreview" class="mt-3"></div>
            </div>

            <div class="form-actions">
                <a href="{{ route('petugas.checkup.index') }}" class="btn-back">
                    ← Kembali
                </a>

                <button type="submit" class="btn-submit">
                    Simpan Draft
                </button>
            </div>

        </form>

    </div>

</div>

@endsection

@push('scripts')
<script>
    document.querySelector('input[name="photos[]"]').addEventListener('change', function(event){
        const preview = document.getElementById('photoPreview');
        preview.innerHTML = '';

        Array.from(event.target.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = function(e){
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.width = '100%';
                img.style.marginBottom = '10px';
                img.style.borderRadius = '8px';
                preview.appendChild(img);
            };
            reader.readAsDataURL(file);
        });
    });

    let lookupTimeout;
    const securityCodeInput = document.getElementById('security_code');
    const feedback = document.getElementById('security_code_feedback');
    const userInfo = document.getElementById('user_info');
    const submitBtn = document.querySelector('button[type="submit"]');
    
    const nameField = document.querySelector('input[name="nama_pengemudi"]');
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
                    const response = await fetch(`/api/identity/${code}?module=checkup`, {
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
