@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Field SIMPER</h2>
        </div>
        <a href="{{ route('super-admin.master.simper.index') }}" class="text-gray-500 hover:text-gray-700 font-medium text-sm transition-colors">
            &larr; Kembali
        </a>
    </div>

    <div class="bg-white dark:bg-night-card rounded-xl shadow-lg border border-gray-100 dark:border-night-border p-6">
        <form action="{{ route('super-admin.master.simper.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Name -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Field</label>
                    <input type="text" name="name" id="name" value="{{ $item->name }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-primary focus:border-primary" required>
                </div>

                <!-- Category -->
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kategori</label>
                    <input type="text" name="category" id="category" value="{{ $item->category }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-primary focus:border-primary" required>
                </div>

                <!-- Field Type -->
                <div>
                    <label for="field_type" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tipe Field</label>
                    <select name="field_type" id="field_type" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-primary focus:border-primary" onchange="toggleOptions()">
                        <option value="text" {{ $item->field_type == 'text' ? 'selected' : '' }}>Text</option>
                        <option value="dropdown" {{ $item->field_type == 'dropdown' ? 'selected' : '' }}>Dropdown</option>
                        <option value="date" {{ $item->field_type == 'date' ? 'selected' : '' }}>Date</option>
                        <option value="checklist" {{ $item->field_type == 'checklist' ? 'selected' : '' }}>Checklist</option>
                        <option value="number" {{ $item->field_type == 'number' ? 'selected' : '' }}>Number</option>
                    </select>
                </div>

                <!-- Urutan -->
                <div>
                    <label for="urutan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Urutan</label>
                    <input type="number" name="urutan" id="urutan" value="{{ $item->urutan }}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-primary focus:border-primary" required>
                </div>
            </div>

            <!-- Options Container -->
            <div id="options_wrapper" class="mb-6 hidden">
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Opsi Dropdown</label>
                <div id="options_list" class="space-y-2 mb-2">
                    <!-- Options will be added here -->
                </div>
                <button type="button" onclick="addOption()" class="text-sm text-primary hover:text-primary-dark font-medium">+ Tambah Opsi</button>
            </div>

            <!-- Active -->
            <div class="mb-6">
                <label class="inline-flex items-center">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" value="1" class="rounded border-gray-300 text-primary shadow-sm focus:border-primary focus:ring focus:ring-primary focus:ring-opacity-50" {{ $item->is_active ? 'checked' : '' }}>
                    <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Aktif</span>
                </label>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('super-admin.master.simper.index') }}" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-lg hover:bg-gray-300 transition-colors">Batal</a>
                <button type="submit" class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary-dark transition-colors">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleOptions() {
        const type = document.getElementById('field_type').value;
        const wrapper = document.getElementById('options_wrapper');
        if (type === 'dropdown') {
            wrapper.classList.remove('hidden');
        } else {
            wrapper.classList.add('hidden');
        }
    }

    function addOption(value = '') {
        const list = document.getElementById('options_list');
        const div = document.createElement('div');
        div.className = 'flex gap-2';
        div.innerHTML = `
            <input type="text" name="options[]" value="${value}" class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-primary focus:border-primary" placeholder="Nama Opsi">
            <button type="button" onclick="this.parentElement.remove()" class="text-red-500 hover:text-red-700">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        `;
        list.appendChild(div);
    }
    
    document.addEventListener('DOMContentLoaded', function() {
        toggleOptions();
        
        @if($item->options)
            const existingOptions = @json($item->options);
            if (Array.isArray(existingOptions)) {
                existingOptions.forEach(opt => addOption(opt));
            }
        @endif
    });
</script>
@endsection
