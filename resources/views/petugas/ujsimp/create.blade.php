@extends('layouts.petugas')

@section('content')

<div class="container-page">
    <div class="card-ui">
        <h2 class="card-header text-gray-800 border-b pb-2">
            Form UJSIMP (Uji Simper)
        </h2>

        <form method="POST" action="{{ route('petugas.ujsimp.store') }}">
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
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Perusahaan</label>
                    <input type="text" name="perusahaan" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Unit Kerja / Dept</label>
                    <input type="text" name="unit_kerja" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Jenis Kendaraan</label>
                    <input type="text" name="jenis_kendaraan" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Type Unit</label>
                    <input type="text" name="type_unit" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor Polisi</label>
                    <input type="text" name="nomor_polisi" required>
                </div>
            </div>

            <div class="card-section border-t border-gray-200 pt-6">
                <h3 class="text-md font-semibold text-gray-800 mb-4 border-l-4 border-yellow-400 pl-3">
                    Detail Pengujian
                </h3>

                <div class="form-grid">
                    <div class="form-group">
                        <label class="form-label">Tanggal Uji</label>
                        <input type="date" name="tanggal_uji" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Lokasi Uji</label>
                        <input type="text" name="lokasi_uji" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Hasil Uji</label>
                        <select name="hasil_uji" required>
                            <option value="">-- Pilih --</option>
                            <option value="Lulus">Lulus</option>
                            <option value="Tidak Lulus">Tidak Lulus</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-4">
                <a href="{{ route('petugas.ujsimp.index') }}" class="btn-ui btn-secondary">
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

    /* Table Styles for UJSIMP */
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
        text-align: center;
    }

    .custom-table td {
        padding: 12px;
        border-bottom: 1px solid #e2e8f0;
        color: #334155;
    }

    .custom-table tr:last-child td {
        border-bottom: none;
    }

    .category-header {
        background-color: #f1f5f9;
        font-weight: 700;
        color: var(--primary-blue);
        text-transform: uppercase;
        font-size: 13px;
        letter-spacing: 0.5px;
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
            Form Ujian Praktek SIM Perusahaan
        </div>

        <form method="POST" action="{{ route('petugas.ujsimp.store') }}">
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
                    <label>Nama Peserta</label>
                    <input type="text" name="nama" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>NPK / Nomor Badge</label>
                    <input type="text" name="npk" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Perusahaan / Dept</label>
                    <input type="text" name="perusahaan" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Jenis Kendaraan</label>
                    <input type="text" name="jenis_kendaraan" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Tanggal Ujian</label>
                    <input type="date" name="tanggal_ujian" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Nomor SIM</label>
                    <input type="text" name="nomor_sim" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Jenis SIM</label>
                    <input type="text" name="jenis_sim" class="form-control" required>
                </div>

                <div class="form-group">
                    <label>Jenis SIMPER</label>
                    <input type="text" name="jenis_simper" class="form-control" required>
                </div>

            </div>

            <div class="section-divider">
                Catatan Penguji
            </div>

            <div class="form-group">
                <textarea name="catatan_penguji" rows="3" class="form-control" placeholder="Masukkan catatan tambahan jika ada..."></textarea>
            </div>

            <div class="section-divider">
                Uraian Uji Keterampilan
            </div>

            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th rowspan="2" style="width: 50px;">NO</th>
                            <th rowspan="2" style="text-align: left;">URAIAN UJI KETERAMPILAN</th>
                            <th colspan="4">NILAI</th>
                        </tr>
                        <tr>
                            <th style="width: 60px;">B</th>
                            <th style="width: 60px;">S</th>
                            <th style="width: 60px;">K</th>
                            <th style="width: 80px;">ANGKA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $group)
                            <tr>
                                <td colspan="6" class="category-header">
                                    {{ strtoupper(str_replace('_',' ', $group['kategori'])) }}
                                </td>
                            </tr>

                            @foreach($group['data'] as $nomor => $uraian)
                                <tr>
                                    <td style="text-align: center;">{{ $nomor }}</td>
                                    <td>{{ $uraian }}</td>
                                    <td>
                                        <div class="radio-group">
                                            <input type="radio" name="nilai[{{ $nomor }}][huruf]" value="B" class="radio-input">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="radio-group">
                                            <input type="radio" name="nilai[{{ $nomor }}][huruf]" value="S" class="radio-input">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="radio-group">
                                            <input type="radio" name="nilai[{{ $nomor }}][huruf]" value="K" class="radio-input">
                                        </div>
                                    </td>
                                    <td>
                                        <input type="number" name="nilai[{{ $nomor }}][angka]" min="0" max="100" class="form-control" style="padding: 5px; text-align: center;">
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="form-actions">
                <a href="{{ route('petugas.ujsimp.index') }}" class="btn-back">
                    ← Kembali
                </a>

                <button type="submit" class="btn-submit">
                    Simpan Data Ujian
                </button>
            </div>

        </form>

    </div>

</div>

@endsection

@push('scripts')
<script>
    let lookupTimeout;
    const securityCodeInput = document.getElementById('security_code');
    const feedback = document.getElementById('security_code_feedback');
    const userInfo = document.getElementById('user_info');
    const submitBtn = document.querySelector('button[type="submit"]');
    
    const nameField = document.querySelector('input[name="nama"]');
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
                    const response = await fetch(`/api/identity/${code}?module=ujsimp`, {
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
