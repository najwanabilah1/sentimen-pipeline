@extends('layouts.admin')

@section('content')
<style>
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in {
        animation: fadeInUp 0.5s ease-out forwards;
    }

    .hero-gradient {
        background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
        position: relative;
        overflow: hidden;
    }
</style>

<div class="px-2 sm:px-4 lg:px-6 pt-2 pb-8 max-w-7xl mx-auto">
    
    <!-- Hero Header -->
    <div class="hero-gradient rounded-[2rem] p-8 md:p-10 shadow-xl animate-fade-in relative mb-6">
        <div class="absolute top-0 right-0 w-64 h-64 bg-red-500/10 blur-[80px] rounded-full pointer-events-none"></div>
        <div class="absolute bottom-0 left-10 w-48 h-48 bg-blue-500/10 blur-[60px] rounded-full pointer-events-none"></div>

        <div class="relative z-10 flex flex-col md:flex-row items-center justify-between gap-6">
            <div class="text-center md:text-left flex-1">
                <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white/5 border border-white/10 text-white/80 text-[10px] font-bold uppercase tracking-widest mb-4 backdrop-blur-md">
                    <span class="relative flex h-1.5 w-1.5">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-rose-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-1.5 w-1.5 bg-rose-500"></span>
                    </span>
                    Informasi Redaksi
                </div>
                <h1 class="text-3xl md:text-4xl font-black text-white leading-tight mb-3">
                    Manajemen <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-400 to-rose-300">Tim Redaksi</span>
                </h1>
                <p class="text-slate-400 text-sm md:text-base leading-relaxed opacity-80 max-w-xl mx-auto md:mx-0">
                    Kelola struktur organisasi secara terpusat. Atur divisi, posisi, hingga status keaktifan dari <strong class="text-white">{{ count($members) }} anggota</strong> tim redaksi.
                </p>
            </div>
            
            <!-- Stat Box (Visible on MD+) -->
            <div class="hidden md:flex bg-white/5 border border-white/10 p-5 rounded-3xl backdrop-blur-md items-center justify-center min-w-[140px] shadow-inner">
                <div class="text-center">
                    <i class="fa-solid fa-users text-rose-400 text-xl mb-2"></i>
                    <h3 class="text-3xl font-black text-white leading-none mb-1">{{ count($members) }}</h3>
                    <p class="text-white/50 text-[10px] font-bold uppercase tracking-widest">Total Tim</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Action Toolbar (Search & Filter) -->
    <div class="bg-white p-4 rounded-2xl border border-slate-100 shadow-sm flex flex-col md:flex-row justify-between items-center gap-4 animate-fade-in mb-8" style="animation-delay: 0.1s">
        <!-- Search -->
        <div class="relative w-full md:w-96 group">
            <i class="fa-solid fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm transition-colors group-focus-within:text-red-500"></i>
            <input type="text" id="searchInput" oninput="filterTim()" placeholder="Cari nama atau posisi..." class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-500 transition-all shadow-inner">
        </div>
        
        <!-- Filters & Action -->
        <div class="flex flex-col sm:flex-row items-center gap-3 w-full md:w-auto">
            <div class="relative w-full sm:w-48">
                <select id="filterDepartemen" onchange="filterTim()" class="w-full bg-slate-50 border border-slate-200 text-slate-600 text-sm font-bold rounded-xl pl-4 pr-10 py-3 focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-500 appearance-none shadow-sm cursor-pointer transition-all">
                    <option value="">Semua Divisi</option>
                    <option value="produksi">Produksi</option>
                    <option value="teknis">Teknis</option>
                    <option value="redaksi">Redaksi</option>
                    <option value="marketing">Marketing</option>
                    <option value="it">IT</option>
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-slate-400">
                    <i class="fa-solid fa-chevron-down text-xs"></i>
                </div>
            </div>
            
            <button onclick="openCreateModal()" class="w-full sm:w-auto bg-red-600 hover:bg-red-700 text-white px-6 py-3 rounded-xl text-sm font-bold shadow-lg shadow-red-200 hover:-translate-y-0.5 transition-all duration-300 whitespace-nowrap flex items-center justify-center gap-2">
                <i class="fa-solid fa-plus text-xs"></i> Tambah
            </button>
        </div>
    </div>

    <!-- Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-7" id="timGrid">
        @forelse($members as $m)
        <div class="tim-card bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 overflow-hidden group relative animate-fade-in flex flex-col" style="animation-delay: {{ $loop->index * 0.05 }}s" data-nama="{{ strtolower($m->nama) }}" data-posisi="{{ strtolower($m->posisi) }}" data-departemen="{{ strtolower($m->departemen) }}">
            <!-- Decorative background blob -->
            <div class="absolute top-0 right-0 w-32 h-32 bg-red-50 blur-[50px] rounded-full pointer-events-none group-hover:bg-red-100 transition-colors"></div>
            
            <div class="p-6 lg:p-8 relative z-10 flex flex-col flex-1">
                <!-- Header Card -->
                <div class="flex justify-between items-start mb-6">
                    <div class="flex items-center gap-4 w-full">
                        <div class="w-14 h-14 bg-gradient-to-br from-slate-50 to-slate-100 border border-slate-200 rounded-2xl flex items-center justify-center text-slate-500 group-hover:from-red-50 group-hover:to-red-100 group-hover:text-red-500 group-hover:border-red-200 transition-all duration-300 shadow-sm shrink-0">
                            <span class="text-xl font-black">{{ strtoupper(substr($m->nama, 0, 1)) }}</span>
                        </div>
                        <div class="flex-1 min-w-0 pr-2">
                            <h4 class="text-lg font-black text-gray-800 leading-tight group-hover:text-red-600 transition-colors line-clamp-1" title="{{ $m->nama }}">{{ $m->nama }}</h4>
                            <p class="text-sm font-bold text-red-500 flex items-center gap-1.5 mt-1 truncate">
                                <i class="fa-solid fa-briefcase text-[11px] opacity-70"></i> {{ $m->posisi }}
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="absolute top-6 right-6">
                    <span class="text-[10px] font-black px-2.5 py-1.5 {{ $m->status == 'Aktif' ? 'bg-emerald-50 text-emerald-600 border border-emerald-100' : 'bg-slate-50 text-slate-500 border border-slate-200' }} rounded-xl uppercase tracking-widest shadow-sm">
                        {{ $m->status }}
                    </span>
                </div>
                
                <!-- Contact Summary -->
                <div class="space-y-3 mb-6 bg-slate-50/70 p-4 rounded-2xl border border-slate-100/50 mt-auto">
                    <div class="flex items-center gap-3 text-sm text-slate-600 font-medium">
                        <div class="w-7 h-7 rounded-lg bg-white flex items-center justify-center text-slate-400 shadow-sm border border-slate-100/50 shrink-0">
                            <i class="fa-regular fa-envelope text-[11px]"></i>
                        </div>
                        <span class="truncate block" title="{{ $m->email }}">{{ $m->email }}</span>
                    </div>
                    <div class="flex items-center gap-3 text-sm text-slate-600 font-medium">
                        <div class="w-7 h-7 rounded-lg bg-white flex items-center justify-center text-slate-400 shadow-sm border border-slate-100/50 shrink-0">
                            <i class="fa-solid fa-phone text-[11px]"></i>
                        </div>
                        <span class="truncate">{{ $m->telepon ?: '-' }}</span>
                    </div>
                </div>
                
                <!-- Footer Card -->
                <div class="flex justify-between items-center pt-4 border-t border-slate-100 mt-2">
                    <span class="text-[11px] font-bold text-slate-500 tracking-widest uppercase flex items-center gap-2">
                        <i class="fa-solid fa-building text-[10px] opacity-70"></i> {{ $m->departemen }}
                    </span>
                    <div class="flex gap-2">
                        <button type="button" data-member="{{ json_encode($m) }}" data-url="{{ route('admin.tim.update', $m) }}" onclick="openEditModal(this)" class="w-9 h-9 rounded-xl bg-slate-50 hover:bg-blue-50 text-slate-400 hover:text-blue-600 flex items-center justify-center transition-all border border-transparent hover:border-blue-100" title="Edit Data">
                            <i class="fa-solid fa-pencil text-xs"></i>
                        </button>
                        <button type="button" onclick="confirmDelete('{{ $m->id }}')" class="w-9 h-9 rounded-xl bg-slate-50 hover:bg-rose-50 text-slate-400 hover:text-rose-600 flex items-center justify-center transition-all border border-transparent hover:border-rose-100" title="Hapus Anggota">
                            <i class="fa-solid fa-trash text-xs"></i>
                        </button>
                        <form id="delete-form-{{ $m->id }}" method="POST" action="{{ route('admin.tim.destroy', $m) }}" style="display:none;">
                            @csrf @method('DELETE')
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full bg-white p-12 md:p-16 rounded-[2rem] border border-slate-100 shadow-sm text-center animate-fade-in">
            <div class="w-24 h-24 mx-auto bg-red-50 rounded-full flex items-center justify-center text-red-300 mb-6">
                <i class="fa-solid fa-users-slash text-4xl"></i>
            </div>
            <h3 class="text-xl font-black text-gray-800 mb-2">Belum ada anggota tim</h3>
            <p class="text-slate-500 mb-6 max-w-sm mx-auto font-medium">Mulai tambahkan anggota tim Anda untuk mengelola peran dan tanggung jawab masing-masing divisi.</p>
            <button onclick="openCreateModal()" class="bg-red-600 text-white px-6 py-3 rounded-xl font-bold hover:bg-red-700 hover:shadow-lg hover:shadow-red-200 transition-all duration-300 inline-flex items-center gap-2">
                <i class="fa-solid fa-plus"></i> Tambah Anggota Sekarang
            </button>
        </div>
        @endforelse
    </div>
</div>

<!-- Modal Dialog -->
<div id="timModal" class="fixed inset-0 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300" style="background-color: rgba(15, 23, 42, 0.6); backdrop-filter: blur(4px);">
    <div class="bg-white rounded-[2rem] w-full max-w-xl mx-4 overflow-hidden shadow-2xl transform scale-95 transition-all duration-300" id="timModalContent">
        <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
            <div>
                <h3 class="text-xl font-black text-gray-800 tracking-tight" id="modalTitle">Tambah Anggota Tim</h3>
                <p class="text-xs font-bold text-slate-400 mt-1" id="modalSubtitle">Lengkapi data informasi anggota baru</p>
            </div>
            <button onclick="closeModal()" type="button" class="w-8 h-8 rounded-full bg-white border border-slate-200 text-slate-400 hover:text-red-600 hover:border-red-200 hover:bg-red-50 flex items-center justify-center transition-all">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>
        <form id="timForm" action="{{ route('admin.tim.store') }}" method="POST" class="p-8">
            @csrf
            <input type="hidden" name="_method" id="formMethod" value="POST">
            
            <div class="space-y-5">
                <div>
                    <label class="block text-xs font-black text-slate-600 uppercase tracking-widest mb-2">Nama Lengkap</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-regular fa-id-card text-sm"></i>
                        </div>
                        <input type="text" name="nama" id="nama" required placeholder="Contoh: John Doe" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-500 transition-all font-medium text-slate-700">
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-black text-slate-600 uppercase tracking-widest mb-2">Posisi</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-briefcase text-sm"></i>
                            </div>
                            <input type="text" name="posisi" id="posisi" required placeholder="Contoh: Editor" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-500 transition-all font-medium text-slate-700">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-600 uppercase tracking-widest mb-2">Departemen</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-building text-sm"></i>
                            </div>
                            <select name="departemen" id="departemen" required class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-500 transition-all font-medium text-slate-700 appearance-none">
                                <option value="">Pilih Departemen</option>
                                <option value="Produksi">Produksi</option>
                                <option value="Teknis">Teknis</option>
                                <option value="Redaksi">Redaksi</option>
                                <option value="Marketing">Marketing</option>
                                <option value="IT">IT</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-black text-slate-600 uppercase tracking-widest mb-2">Email</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-regular fa-envelope text-sm"></i>
                            </div>
                            <input type="email" name="email" id="email" required placeholder="email@contoh.com" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-500 transition-all font-medium text-slate-700">
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-black text-slate-600 uppercase tracking-widest mb-2">No. Telepon</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                                <i class="fa-solid fa-phone text-sm"></i>
                            </div>
                            <input type="tel" name="telepon" id="telepon" placeholder="Contoh: 0812..." class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-500 transition-all font-medium text-slate-700">
                        </div>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-black text-slate-600 uppercase tracking-widest mb-2">Status</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-toggle-on text-sm"></i>
                        </div>
                        <select name="status" id="status" class="w-full pl-11 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-red-100 focus:border-red-500 transition-all font-medium text-slate-700 appearance-none">
                            <option value="Aktif">Aktif</option>
                            <option value="Cuti">Cuti</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-400">
                            <i class="fa-solid fa-chevron-down text-xs"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 flex justify-end gap-3 pt-6 border-t border-slate-100">
                <button type="button" onclick="closeModal()" class="bg-white border border-slate-200 hover:bg-slate-50 hover:border-slate-300 text-slate-700 px-6 py-2.5 rounded-xl font-bold transition-all duration-200">Batal</button>
                <button type="submit" id="btnSubmit" class="bg-red-600 hover:bg-red-700 hover:shadow-lg hover:shadow-red-200/50 hover:-translate-y-0.5 text-white px-8 py-2.5 rounded-xl font-bold transition-all duration-200 flex items-center gap-2">
                    <i class="fa-solid fa-save"></i> Simpan Data
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // SweetAlert Validasi & Flash Message
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        customClass: { popup: 'rounded-xl shadow-lg border border-slate-100' },
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    @if(session('success'))
        Toast.fire({
            icon: 'success',
            title: '{{ session('success') }}'
        });
    @endif

    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Ups! Terjadi Kesalahan',
            html: `
                <div class="text-left text-sm text-slate-600 mt-2 bg-red-50 p-4 rounded-xl border border-red-100">
                    <ul class="space-y-1 list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            `,
            confirmButtonColor: '#e11d48',
            customClass: {
                popup: 'rounded-[2rem]',
                confirmButton: 'rounded-xl font-bold px-8 py-3'
            }
        });
    @endif

    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Anggota?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48',
            cancelButtonColor: '#94a3b8',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            reverseButtons: true,
            customClass: {
                popup: 'rounded-[2rem]',
                confirmButton: 'rounded-xl font-bold px-6 py-2.5',
                cancelButton: 'rounded-xl font-bold px-6 py-2.5'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + id).submit();
            }
        })
    }
    // Fitur Pencarian & Filter Realtime
    function filterTim() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const filterDept = document.getElementById('filterDepartemen').value.toLowerCase();
        const cards = document.querySelectorAll('.tim-card');
        
        cards.forEach(card => {
            const nama = card.getAttribute('data-nama');
            const posisi = card.getAttribute('data-posisi');
            const departemen = card.getAttribute('data-departemen');
            
            const matchSearch = nama.includes(input) || posisi.includes(input) || departemen.includes(input);
            const matchDept = filterDept === '' || departemen === filterDept;
            
            if (matchSearch && matchDept) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Modal Logic
    function openCreateModal() {
        const modal = document.getElementById('timModal');
        const modalContent = document.getElementById('timModalContent');
        
        document.getElementById('modalTitle').innerText = 'Tambah Anggota Tim';
        document.getElementById('modalSubtitle').innerText = 'Lengkapi data informasi anggota baru';
        document.getElementById('timForm').action = "{{ route('admin.tim.store') }}";
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('btnSubmit').innerHTML = '<i class="fa-solid fa-save"></i> Simpan Data';
        
        document.getElementById('timForm').reset();
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalContent.classList.remove('scale-95');
        }, 10);
    }

    function openEditModal(btn) {
        const member = JSON.parse(btn.getAttribute('data-member'));
        const actionUrl = btn.getAttribute('data-url');
        
        const modal = document.getElementById('timModal');
        const modalContent = document.getElementById('timModalContent');
        
        document.getElementById('modalTitle').innerText = 'Edit Anggota Tim';
        document.getElementById('modalSubtitle').innerText = 'Perbarui data informasi anggota tim';
        document.getElementById('timForm').action = actionUrl;
        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('btnSubmit').innerHTML = '<i class="fa-solid fa-check"></i> Update Data';
        
        document.getElementById('nama').value = member.nama;
        document.getElementById('posisi').value = member.posisi;
        document.getElementById('departemen').value = member.departemen;
        document.getElementById('email').value = member.email;
        document.getElementById('telepon').value = member.telepon || '';
        document.getElementById('status').value = member.status;
        
        modal.classList.remove('hidden');
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalContent.classList.remove('scale-95');
        }, 10);
    }

    function closeModal() {
        const modal = document.getElementById('timModal');
        const modalContent = document.getElementById('timModalContent');
        
        modal.classList.add('opacity-0');
        modalContent.classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
</script>
@endsection