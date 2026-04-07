@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Anggota Tim</h1>
        <a href="{{ route('admin.tim.index') }}" class="text-gray-600 hover:text-gray-900">← Kembali</a>
    </div>

    <form action="{{ route('admin.tim.store') }}" method="POST" class="bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
        @csrf
        
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Nama</label>
                <input type="text" name="nama" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:border-red-600">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Posisi</label>
                    <input type="text" name="posisi" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:border-red-600">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Departemen</label>
                    <select name="departemen" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:border-red-600">
                        <option value="">Pilih Departemen</option>
                        <option value="Produksi">Produksi</option>
                        <option value="Teknis">Teknis</option>
                        <option value="Redaksi">Redaksi</option>
                        <option value="Marketing">Marketing</option>
                        <option value="IT">IT</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                    <input type="email" name="email" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:border-red-600">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Telepon</label>
                    <input type="tel" name="telepon" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:border-red-600">
                </div>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Status</label>
                <select name="status" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:border-red-600">
                    <option value="Aktif">Aktif</option>
                    <option value="Cuti">Cuti</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                </select>
            </div>
        </div>

        <div class="mt-8 flex gap-3">
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-xl font-bold transition">Simpan</button>
            <a href="{{ route('admin.tim.index') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-xl font-bold transition">Batal</a>
        </div>
    </form>
</div>
@endsection
