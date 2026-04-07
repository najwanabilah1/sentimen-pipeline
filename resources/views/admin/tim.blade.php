@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-gray-800">Tim Redaksi</h1>
        <div class="flex gap-3">
            <div class="relative">
                <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" placeholder="Cari nama anggota..." class="pl-9 pr-4 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none">
            </div>
            <button class="bg-gray-900 text-white px-4 py-2 rounded-xl text-sm hover:bg-gray-800 transition">Tambah Anggota</button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($members as $m)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden group">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div class="w-12 h-12 bg-gray-100 rounded-full flex items-center justify-center text-gray-400 group-hover:bg-red-50 group-hover:text-red-600 transition">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <span class="text-[10px] font-bold px-2 py-0.5 {{ $m->status == 'Aktif' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }} rounded-full">{{ $m->status }}</span>
                </div>
                <h4 class="font-bold text-gray-900">{{ $m->nama }}</h4>
                <p class="text-xs text-red-600 font-medium mb-4">{{ $m->posisi }}</p>
                
                <div class="space-y-2 mb-6">
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <i class="fa-regular fa-envelope w-4"></i> {{ $m->email }}
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <i class="fa-solid fa-phone w-4"></i> {{ $m->telepon }}
                    </div>
                </div>
                
                <div class="flex justify-between items-center pt-4 border-t border-gray-50">
                    <span class="text-[10px] font-bold text-gray-400 tracking-widest uppercase">{{ $m->departemen }}</span>
                    <div class="flex gap-2">
                        <button class="text-gray-400 hover:text-blue-600 transition"><i class="fa-solid fa-pencil text-xs"></i></button>
                        <button class="text-gray-400 hover:text-red-600 transition"><i class="fa-solid fa-trash text-xs"></i></button>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection