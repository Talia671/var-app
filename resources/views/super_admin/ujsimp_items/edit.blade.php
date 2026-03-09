@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Edit Item UJSIMP</h2>
    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Ubah data item penilaian UJSIMP</p>
</div>

<div class="bg-white dark:bg-night-card rounded-xl shadow-lg border border-gray-100 dark:border-night-border overflow-hidden p-6">
    <form action="{{ route('super-admin.ujsimp-items.update', $item->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Kategori</label>
                <select name="category" id="category" required 
                        class="block w-full px-4 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-secondary focus:border-secondary sm:text-sm rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                    <option value="teknik" {{ $item->category == 'teknik' ? 'selected' : '' }}>Teknik</option>
                    <option value="rambu" {{ $item->category == 'rambu' ? 'selected' : '' }}>Rambu</option>
                </select>
                @error('category')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="urutan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Urutan</label>
                <input type="number" name="urutan" id="urutan" value="{{ old('urutan', $item->urutan) }}" required 
                       class="block w-full px-4 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-secondary focus:border-secondary sm:text-sm rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white @error('urutan') border-red-500 @enderror">
                @error('urutan')
                    <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="mb-4">
            <label for="uraian" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Uraian</label>
            <textarea name="uraian" id="uraian" rows="3" required 
                      class="block w-full px-4 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-secondary focus:border-secondary sm:text-sm rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white @error('uraian') border-red-500 @enderror">{{ old('uraian', $item->uraian) }}</textarea>
            @error('uraian')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex gap-4">
            <button type="submit" class="bg-primary hover:bg-primary-dark text-white font-medium rounded-lg text-sm px-4 py-2.5 transition-colors">
                Perbarui
            </button>
            <a href="{{ route('super-admin.ujsimp-items.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg text-sm px-4 py-2.5 transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
