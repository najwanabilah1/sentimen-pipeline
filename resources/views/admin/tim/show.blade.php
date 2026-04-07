@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">{{ $member->nama }}</h1>
            <p class="text-gray-500 text-sm mt-1">{{ $member->posisi }} - {{ $member->departemen }}</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.tim.edit', $member) }}" class="bg-blue-600 text-white px-4 py-2 rounded-xl">Edit</a>
            <a href="{{ route('admin.tim.index') }}" class="bg-gray-200 text-gray-800 px-4 py-2 rounded-xl">Kembali</a>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-6">
        <div class="col-span-2 bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
            <h3 class="text-lg font-bold text-gray-800 mb-6">Informasi Detail</h3>
            
            <div class="space-y-6">
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold mb-2">Email</p>
                        <p class="text-gray-900">{{ $member->email }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold mb-2">Telepon</p>
                        <p class="text-gray-900">{{ $member->telepon }}</p>
                    </div>
                </div>
                
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold mb-2">Departemen</p>
                        <p class="text-gray-900 font-medium">{{ $member->departemen }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 uppercase font-bold mb-2">Status</p>
                        <span class="inline-block px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-bold">{{ $member->status }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm h-fit">
            <h3 class="font-bold text-gray-800 mb-4">Informasi Akun</h3>
            <div class="space-y-4 text-sm">
                <div>
                    <p class="text-gray-500 text-xs mb-1">Tergabung</p>
                    <p class="text-gray-900 font-medium">{{ $member->created_at->format('d M Y') }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-xs mb-1">Diupdate</p>
                    <p class="text-gray-900 font-medium">{{ $member->updated_at->format('d M Y H:i') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
