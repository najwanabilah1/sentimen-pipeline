@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <h1 class="text-2xl font-bold text-gray-800">Tim Redaksi</h1>
        <div class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">
            <div class="relative w-full sm:w-auto">
                <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-xs"></i>
                <input type="text" placeholder="Cari nama anggota..." class="w-full pl-9 pr-4 py-2 bg-white border border-gray-200 rounded-xl text-sm focus:outline-none">
            </div>
            <button onclick="openCreateModal()" class="w-full sm:w-auto bg-gray-900 text-white px-4 py-2 rounded-xl text-sm hover:bg-gray-800 transition whitespace-nowrap">Tambah Anggota</button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @forelse($members as $m)
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
                        <button onclick="openEditModal({{ htmlspecialchars(json_encode($m)) }}, '{{ route('admin.tim.update', $m) }}')" class="text-gray-400 hover:text-blue-600 transition"><i class="fa-solid fa-pencil text-xs"></i></button>
                        <form method="POST" action="{{ route('admin.tim.destroy', $m) }}" style="display:inline;">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-gray-400 hover:text-red-600 transition" onclick="return confirm('Yakin hapus?')"><i class="fa-solid fa-trash text-xs"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 bg-white p-12 rounded-2xl border border-gray-100 shadow-sm text-center">
            <p class="text-gray-500">Belum ada anggota tim. <button onclick="openCreateModal()" class="text-red-600 font-bold hover:underline">Tambah anggota</button></p>
        </div>
        @endforelse
    </div>
</div>

<!-- Modal -->
<div id="timModal" class="fixed inset-0 z-50 flex items-center justify-center hidden" style="background-color: rgba(0,0,0,0.5);">
    <div class="bg-white rounded-2xl w-full max-w-lg mx-4 overflow-hidden shadow-xl transform transition-all">
        <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-800" id="modalTitle">Tambah Anggota Tim</h3>
            <button onclick="closeModal()" type="button" class="text-gray-400 hover:text-gray-600 transition"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <form id="timForm" action="{{ route('admin.tim.store') }}" method="POST" class="p-6">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Nama</label>
                    <input type="text" name="nama" id="nama" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:border-red-600">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Posisi</label>
                        <input type="text" name="posisi" id="posisi" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:border-red-600">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Departemen</label>
                        <select name="departemen" id="departemen" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:border-red-600">
                            <option value="">Pilih Departemen</option>
                            <option value="Produksi">Produksi</option>
                            <option value="Teknis">Teknis</option>
                            <option value="Redaksi">Redaksi</option>
                            <option value="Marketing">Marketing</option>
                            <option value="IT">IT</option>
                        </select>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                        <input type="email" name="email" id="email" required class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:border-red-600">
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-700 mb-2">Telepon</label>
                        <input type="tel" name="telepon" id="telepon" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:border-red-600">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">Status</label>
                    <select name="status" id="status" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:border-red-600">
                        <option value="Aktif">Aktif</option>
                        <option value="Cuti">Cuti</option>
                        <option value="Tidak Aktif">Tidak Aktif</option>
                    </select>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <button type="button" onclick="closeModal()" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-xl font-bold transition">Batal</button>
                <button type="submit" id="btnSubmit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-xl font-bold transition">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCreateModal() {
        document.getElementById('modalTitle').innerText = 'Tambah Anggota Tim';
        document.getElementById('timForm').action = "{{ route('admin.tim.store') }}";
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('btnSubmit').innerText = 'Simpan';
        
        document.getElementById('timForm').reset();
        
        document.getElementById('timModal').classList.remove('hidden');
    }

    function openEditModal(member, actionUrl) {
        document.getElementById('modalTitle').innerText = 'Edit Anggota Tim';
        document.getElementById('timForm').action = actionUrl;
        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('btnSubmit').innerText = 'Update';
        
        document.getElementById('nama').value = member.nama;
        document.getElementById('posisi').value = member.posisi;
        document.getElementById('departemen').value = member.departemen;
        document.getElementById('email').value = member.email;
        document.getElementById('telepon').value = member.telepon || '';
        document.getElementById('status').value = member.status;
        
        document.getElementById('timModal').classList.remove('hidden');
    }

    function closeModal() {
        document.getElementById('timModal').classList.add('hidden');
    }
</script>
@endsection