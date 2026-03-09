@extends('layouts.petugas')

@section('content')

<div class="container-page">
    <div class="card-ui">
        <h2 class="card-header text-gray-800 border-b pb-2">
            Form Pengajuan SIMPER
        </h2>

        <form method="POST" action="{{ route('petugas.simper.store') }}">
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
                <div class="md:col-span-2 form-group">
                    <label class="form-label">Lokasi Kerja (Zonasi)</label>
                    <div class="flex gap-6 items-center">
                        <label class="inline-flex items-center">
                            <input type="radio" name="zona" value="zona_1" class="form-radio text-blue-600" required>
                            <span class="ml-2 text-sm text-gray-700">Zona 1</span>
                        </label>
                        <label class="inline-flex items-center">
                            <input type="radio" name="zona" value="zona_2" class="form-radio text-blue-600">
                            <span class="ml-2 text-sm text-gray-700">Zona 2</span>
                        </label>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Nama</label>
                    <input type="text" name="nama" required>
                </div>

                <div class="form-group">
                    <label class="form-label">NPK</label>
                    <input type="text" name="npk" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Perusahaan / Dept</label>
                    <input type="text" name="perusahaan" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Jenis Kendaraan / Alat</label>
                    <input type="text" name="jenis_kendaraan" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Nomor SIM / SIO</label>
                    <input type="text" name="nomor_sim" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Jenis SIM / SIO</label>
                    <input type="text" name="jenis_sim" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Jenis SIMPER</label>
                    <select name="jenis_simper" required>
                        <option value="">-- Pilih --</option>
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal Uji</label>
                    <input type="date" name="tanggal_uji" required>
                </div>
            </div>

            <div class="card-section border-t border-gray-200 pt-6">
                <h3 class="text-md font-semibold text-gray-800 mb-4 border-l-4 border-yellow-400 pl-3">
                    Yang Perlu Dilatih / Diperbaiki
                </h3>

                <div id="notes-container" class="space-y-3">
                    <div class="note-row">
                        <input type="text" name="notes[]" placeholder="Uraian catatan">
                    </div>
                </div>
                
                <button type="button" id="add-note" class="mt-3 text-sm text-blue-600 hover:text-blue-800 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    Tambah Catatan
                </button>
            </div>

            <div class="mt-8 flex justify-end gap-4">
                <a href="{{ route('petugas.simper.index') }}" class="btn-ui btn-secondary">
                    Batal
                </a>
                <button type="submit" class="btn-ui btn-primary">
                    Submit Pengajuan
                </button>
            </div>
        </form>
    </div>
</div>
                </div>
            </div>

            <button type="button" class="mt-3 text-sm text-blue-600 font-medium hover:text-blue-800 hover:underline flex items-center" onclick="addNote()">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Catatan
            </button>
        </div>

        <div class="mt-8 flex justify-end gap-3">
            <a href="{{ route('petugas.simper.index') }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300 text-sm font-medium">
                Batal
            </a>
            <button type="submit" class="btn-submit px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm font-medium shadow-sm">
                Kirim Pengajuan
            </button>
        </div>
    </form>
</div>

<script>
    function addNote() {
        const container = document.getElementById('notes-container');
        const div = document.createElement('div');
        div.className = 'note-row';
        div.innerHTML = `<input type="text" name="notes[]" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" placeholder="Uraian catatan">`;
        container.appendChild(div);
    }

    let lookupTimeout;
    const securityCodeInput = document.getElementById('security_code');
    const feedback = document.getElementById('security_code_feedback');
    const userInfo = document.getElementById('user_info');
    const submitBtn = document.querySelector('.btn-submit');
    
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
                    const response = await fetch(`/api/identity/${code}?module=simper`, {
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
                        feedback.innerHTML = '<span style="color: #dc2626;">Invalid security code format</span>';
                        userInfo.style.display = 'none';
                        if(submitBtn) submitBtn.disabled = true;
                    }
                } catch (error) {
                    console.error('Identity lookup error:', error);
                    feedback.innerHTML = '<span style="color: #dc2626;">Connection error</span>';
                }
            }, 500);
        });
    }
</script>

@endsection