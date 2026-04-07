@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Edit Anggota Tim</h1>
        <a href="{{ route('admin.tim.index') }}" class="text-gray-600 hover:text-gray-900">← Kembali</a>
    </div>

    <form action="{{ route('admin.tim.update', $member) }}" method="POST" class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
        @csrf @method('PUT')
        
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Nama</label>
                <input type="text" name="nama" value="{{ $member->nama }}" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:border-red-600">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Posisi</label>
                    <input type="text" name="posisi" value="{{ $member->posisi }}" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:border-red-600">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Departemen</label>
                    <select name="departemen" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:border-red-600">
                        <option value="Produksi" {{ $member->departemen == 'Produksi' ? 'selected' : '' }}>Produksi</option>
                        <option value="Teknis" {{ $member->departemen == 'Teknis' ? 'selected' : '' }}>Teknis</option>
                        <option value="Redaksi" {{ $member->departemen == 'Redaksi' ? 'selected' : '' }}>Redaksi</option>
                        <option value="Marketing" {{ $member->departemen == 'Marketing' ? 'selected' : '' }}>Marketing</option>
                        <option value="IT" {{ $member->departemen == 'IT' ? 'selected' : '' }}>IT</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" value="{{ $member->email }}" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:border-red-600">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Telepon</label>
                    <input type="tel" name="telepon" value="{{ $member->telepon }}" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:border-red-600">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:border-red-600">
                    <option value="Aktif" {{ $member->status == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                    <option value="Cuti" {{ $member->status == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                    <option value="Tidak Aktif" {{ $member->status == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>
        </div>

        <div class="mt-8 flex gap-3">
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-xl font-bold transition">Update</button>
            <a href="{{ route('admin.tim.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-xl font-bold transition">Batal</a>
        </div>
    </form>
</div>
@endsection
