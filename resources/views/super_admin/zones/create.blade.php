@extends('layouts.admin')

@section('content')
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Tambah Zona</h2>
    <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Tambah data zona baru ke sistem</p>
</div>

<div class="bg-white dark:bg-night-card rounded-xl shadow-lg border border-gray-100 dark:border-night-border overflow-hidden p-6">
    <form action="{{ route('super-admin.zones.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Nama Zona</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                   class="block w-full px-4 py-2 text-base border-gray-300 dark:border-gray-600 focus:outline-none focus:ring-secondary focus:border-secondary sm:text-sm rounded-lg bg-white dark:bg-gray-700 text-gray-900 dark:text-white @error('name') border-red-500 @enderror">
            @error('name')
                <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div class="flex gap-4">
            <button type="submit" class="bg-primary hover:bg-primary-dark text-white font-medium rounded-lg text-sm px-4 py-2.5 transition-colors">
                Simpan
            </button>
            <a href="{{ route('super-admin.zones.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg text-sm px-4 py-2.5 transition-colors">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
