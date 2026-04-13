@extends('layouts.admin')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    /* --- ANIMASI & STYLE ASLI --- */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
    .delay-100 { animation-delay: 100ms; opacity: 0; }
    .delay-200 { animation-delay: 200ms; opacity: 0; }

    /* Custom Scrollbar */
    .custom-scroll::-webkit-scrollbar { width: 5px; }
    .custom-scroll::-webkit-scrollbar-track { background: #f8fafc; }
    .custom-scroll::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    .custom-scroll::-webkit-scrollbar-thumb:hover { background: #ef4444; }

    .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    #beritaModal.hidden { display: none; }
    #beritaModal:not(.hidden) { display: flex; }
</style>

<div class="px-2 sm:px-4 lg:px-6 pt-2 pb-8 max-w-7xl mx-auto space-y-8">
    
    <div class="bg-gradient-to-br from-slate-900 via-[#0f172a] to-blue-950 rounded-[2rem] p-6 lg:p-10 shadow-2xl relative overflow-hidden animate-fade-in group">
        <div class="absolute top-0 right-0 w-72 h-72 bg-red-500/10 blur-[100px] rounded-full pointer-events-none transition-transform duration-700 group-hover:scale-150"></div>
        <div class="absolute bottom-0 left-0 w-56 h-56 bg-indigo-500/10 blur-[80px] rounded-full pointer-events-none transition-transform duration-700 group-hover:scale-150"></div>

        <div class="relative z-10 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6">
            <div>
                <nav class="flex items-center text-[10px] font-black uppercase tracking-[0.2em] text-slate-400 mb-3">
                    <span class="text-red-400 bg-red-400/10 px-2 py-1 rounded-md">Konten</span>
                    <span class="mx-3 text-slate-600">/</span>
                    <span class="text-slate-300">Manajemen Berita</span>
                </nav>
                <h1 class="text-3xl md:text-5xl font-black text-white tracking-tight mb-3">Pusat Publikasi <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-400 to-rose-300">Konten</span></h1>
                <p class="text-slate-400 text-sm md:text-base flex items-center gap-2 font-medium">
                    <i class="fa-solid fa-feather-pointed text-red-500/80"></i>
                    Kelola artikel, berita daerah, dan tayangan investigasi.
                </p>
            </div>
            
            <div class="flex items-center gap-4 w-full lg:w-auto">
                <button onclick="openCreateModal()" class="flex-1 sm:flex-none group relative bg-red-600 hover:bg-red-500 text-white px-7 py-4 rounded-2xl flex items-center justify-center gap-3 shadow-[0_0_40px_-10px_rgba(220,38,38,0.5)] transition-all duration-300 hover:-translate-y-1 active:scale-95 overflow-hidden">
                    <div class="absolute inset-0 bg-white/20 translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-out"></div>
                    <i class="fa-solid fa-plus relative z-10 group-hover:rotate-90 transition-transform duration-500"></i>
                    <span class="font-black tracking-widest uppercase text-xs relative z-10 text-white">Buat Berita</span>
                </button>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 animate-fade-in delay-100">
        <div class="bg-white p-6 rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl transition-all group">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-slate-400 text-xs font-bold uppercase tracking-widest mb-1">Total Berita</p>
                    <h3 class="text-3xl font-black text-slate-800">{{ $beritas->count() }}</h3>
                </div>
                <div class="w-12 h-12 bg-slate-50 text-slate-400 rounded-2xl flex items-center justify-center text-xl group-hover:bg-red-500 group-hover:text-white transition-all shadow-sm">
                    <i class="fa-solid fa-layer-group"></i>
                </div>
            </div>
        </div>

        <div class="bg-indigo-500 p-6 rounded-[2rem] shadow-lg shadow-indigo-200 hover:scale-105 transition-all text-white relative overflow-hidden group">
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-indigo-200 text-xs font-bold uppercase tracking-widest mb-1">Berita Malam</p>
                    <h3 class="text-3xl font-black">{{ $beritas->where('kategori_berita', 'Malam')->count() }}</h3>
                </div>
                <i class="fa-solid fa-moon text-4xl text-indigo-300/40 group-hover:rotate-12 transition-transform"></i>
            </div>
            <div class="absolute top-0 right-0 w-32 h-32 bg-indigo-400 rounded-full mix-blend-multiply filter blur-2xl opacity-50"></div>
        </div>

        <div class="bg-rose-500 p-6 rounded-[2rem] shadow-lg shadow-rose-200 hover:scale-105 transition-all text-white relative overflow-hidden group">
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-rose-200 text-xs font-bold uppercase tracking-widest mb-1">Tayangan Pekaro</p>
                    <h3 class="text-3xl font-black">{{ $beritas->where('kategori_berita', 'Pekaro')->count() }}</h3>
                </div>
                <i class="fa-solid fa-mask text-4xl text-rose-300/40 group-hover:-rotate-12 transition-transform"></i>
            </div>
            <div class="absolute top-0 right-0 w-32 h-32 bg-rose-400 rounded-full mix-blend-multiply filter blur-2xl opacity-50"></div>
        </div>

        <div class="bg-emerald-500 p-6 rounded-[2rem] shadow-lg shadow-emerald-200 hover:scale-105 transition-all text-white relative overflow-hidden group">
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-emerald-200 text-xs font-bold uppercase tracking-widest mb-1">Berita Daerah</p>
                    <h3 class="text-3xl font-black">{{ $beritas->where('kategori_berita', 'Daerah')->count() }}</h3>
                </div>
                <i class="fa-solid fa-map-location-dot text-4xl text-emerald-300/40 group-hover:scale-110 transition-transform"></i>
            </div>
            <div class="absolute top-0 right-0 w-32 h-32 bg-emerald-400 rounded-full mix-blend-multiply filter blur-2xl opacity-50"></div>
        </div>
    </div>

    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden animate-fade-in delay-200">
        <div class="overflow-x-auto custom-scroll">
            <table class="w-full text-left min-w-[800px]">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-8 py-5 text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.2em]">Info Konten</th>
                        <th class="px-6 py-5 text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.2em]">Kategori</th>
                        <th class="px-6 py-5 text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.2em]">Tanggal & ID</th>
                        <th class="px-8 py-5 text-[10px] font-extrabold text-slate-400 uppercase tracking-[0.2em] text-center">Tindakan</th>
                    </tr>
                </thead>
                <tbody id="beritasContainer" class="divide-y divide-slate-50">
                    @forelse($beritas as $berita)
                    <tr id="berita-{{ $berita->id_berita }}" class="hover:bg-slate-50/50 transition-all group">
                        <td class="px-8 py-6">
                            <div class="flex items-center gap-5">
                                <div class="relative h-16 w-16 flex-shrink-0 group-hover:scale-110 transition-transform duration-300">
                                    @if($berita->gambar_berita)
                                        <img src="{{ asset('uploads/' . $berita->gambar_berita) }}" class="h-full w-full object-cover rounded-2xl shadow-md border-2 border-white">
                                    @else
                                        <div class="h-full w-full bg-slate-100 rounded-2xl flex items-center justify-center text-slate-300 border-2 border-dashed border-slate-200">
                                            <i class="fa-solid fa-image text-xl"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="max-w-xs md:max-w-md">
                                    <h4 class="text-sm font-bold text-slate-800 line-clamp-1 group-hover:text-red-600 transition-colors">{{ $berita->judul_berita }}</h4>
                                    <p class="text-xs text-slate-400 mt-1 line-clamp-2 leading-relaxed font-medium italic">
                                        "{{ $berita->caption_berita ?? 'Tanpa deskripsi ringkas.' }}"
                                    </p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            @php
                                $colors = ['Malam' => 'bg-indigo-50 text-indigo-600 border-indigo-100', 'Daerah' => 'bg-emerald-50 text-emerald-600 border-emerald-100', 'Pekaro' => 'bg-rose-50 text-rose-600 border-rose-100'];
                                $colorClass = $colors[$berita->kategori_berita] ?? 'bg-slate-50 text-slate-600 border-slate-100';
                            @endphp
                            <span class="px-4 py-2 {{ $colorClass }} border rounded-xl text-[10px] font-black uppercase tracking-widest shadow-sm">
                                {{ $berita->kategori_berita }}
                            </span>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex flex-col gap-1">
                                <span class="text-xs font-bold text-slate-700 flex items-center gap-2">
                                    <i class="fa-regular fa-calendar text-slate-300"></i>
                                    {{ date('d M, Y', strtotime($berita->tanggal_berita)) }}
                                </span>
                                <span class="text-[9px] text-slate-400 font-black uppercase tracking-tighter bg-slate-100 w-fit px-2 py-0.5 rounded">ID: #{{ $berita->id_berita }}</span>
                            </div>
                        </td>
                        <td class="px-8 py-6">
                            <div class="flex justify-center items-center gap-2">
                                <button onclick="openEditModal({{ $berita->id_berita }})" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-blue-600 hover:text-white hover:shadow-lg hover:shadow-blue-200 transition-all duration-300">
                                    <i class="fa-solid fa-pen-to-square text-sm"></i>
                                </button>
                                <button onclick="deleteBerita({{ $berita->id_berita }})" class="w-10 h-10 flex items-center justify-center rounded-xl bg-slate-50 text-slate-400 hover:bg-red-600 hover:text-white hover:shadow-lg hover:shadow-red-200 transition-all duration-300">
                                    <i class="fa-solid fa-trash-can text-sm"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="px-8 py-20 text-center">Data Kosong</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="beritaModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-md transition-opacity" onclick="closeModal()"></div>
    
    <div class="relative bg-white rounded-[3rem] w-full max-w-xl shadow-2xl overflow-hidden animate-fade-in flex flex-col max-h-[90vh]">
        <div class="p-8 pb-6 flex justify-between items-center bg-white sticky top-0 z-10 border-b border-slate-50">
            <div>
                <h2 class="text-2xl font-black text-slate-900 tracking-tight" id="modalTitle">Tambah Berita</h2>
                <div class="flex items-center gap-2 mt-1">
                    <span class="w-8 h-1 bg-red-500 rounded-full"></span>
                    <p class="text-[10px] text-slate-400 uppercase font-black tracking-widest">Konten Editor</p>
                </div>
            </div>
            <button onclick="closeModal()" class="w-12 h-12 bg-slate-50 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-2xl flex items-center justify-center transition-all duration-300">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>

        <form id="beritaForm" class="p-8 pt-4 space-y-6 overflow-y-auto custom-scroll" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="beritaId" name="id_berita">
            <input type="hidden" id="methodField" name="_method" value="POST">

            <div class="group space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Judul Publikasi</label>
                <input type="text" id="judul_berita" name="judul_berita" class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:bg-white focus:border-red-500 rounded-[1.5rem] transition-all outline-none font-bold text-slate-700 placeholder:text-slate-300" required>
            </div>

            <div class="group space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Link Sosmed / Video (Opsional)</label>
                <div class="relative">
                    <input type="url" id="link_berita" name="link_berita" placeholder="https://instagram.com/p/..." 
                        class="w-full pl-14 pr-6 py-4 bg-slate-50 border-2 border-transparent focus:bg-white focus:border-red-500 rounded-[1.5rem] transition-all outline-none font-bold text-slate-700 placeholder:text-slate-300">
                    <div class="absolute left-5 top-1/2 -translate-y-1/2 text-slate-400">
                        <i class="fa-solid fa-link"></i>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Kategori</label>
                    <select id="kategori_berita" name="kategori_berita" class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:bg-white focus:border-red-500 rounded-[1.5rem] transition-all outline-none font-bold text-slate-700 appearance-none cursor-pointer" required>
                        <option value="">Pilih</option>
                        <option value="Malam">Malam</option>
                        <option value="Daerah">Daerah</option>
                        <option value="Pekaro">Pekaro</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Tanggal Terbit</label>
                    <input type="date" id="tanggal_berita" name="tanggal_berita" class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:bg-white focus:border-red-500 rounded-[1.5rem] transition-all outline-none font-bold text-slate-700" required>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] ml-2">Ringkasan Berita</label>
                <textarea id="caption_berita" name="caption_berita" rows="3" class="w-full px-6 py-4 bg-slate-50 border-2 border-transparent focus:bg-white focus:border-red-500 rounded-[1.5rem] transition-all outline-none font-bold text-slate-700 placeholder:text-slate-300 resize-none" required></textarea>
            </div>

            <div class="space-y-3">
                <div class="relative group">
                    <input type="file" id="gambar_berita" name="gambar_berita" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                    <div class="border-4 border-dashed border-slate-100 rounded-[2rem] p-10 text-center group-hover:border-red-200 group-hover:bg-red-50/30 transition-all duration-300">
                        <i class="fa-solid fa-cloud-arrow-up text-2xl text-slate-300 group-hover:text-red-500 mb-2"></i>
                        <p class="text-sm font-black text-slate-500">Klik untuk Ganti Gambar</p>
                    </div>
                </div>
                <div id="previewContainer" class="mt-4 relative hidden">
                    <img id="gambarPreview" class="rounded-[2rem] w-full h-48 object-cover border-8 border-slate-50 shadow-inner">
                    <button type="button" onclick="resetImage()" class="absolute -top-2 -right-2 bg-slate-900 text-white w-10 h-10 rounded-2xl shadow-xl hover:bg-red-600 transition-colors">
                        <i class="fa-solid fa-times text-sm"></i>
                    </button>
                </div>
            </div>

            <div class="flex gap-4 pt-6 sticky bottom-0 bg-white border-t border-slate-50 mt-4">
                <button type="button" onclick="closeModal()" class="flex-1 px-6 py-4 rounded-2xl font-bold text-slate-400 hover:bg-slate-50 transition-all">Batal</button>
                <button type="submit" id="submitBtn" class="flex-[2] px-6 py-4 bg-red-600 hover:bg-red-700 text-white rounded-[1.5rem] font-black tracking-wide shadow-xl shadow-red-100 transition-all active:scale-95">Simpan Publikasi</button>
            </div>
        </form>
    </div>
</div>

<script>
// Fungsi Modal
function openCreateModal() {
    document.getElementById('beritaForm').reset();
    document.getElementById('beritaId').value = '';
    document.getElementById('methodField').value = 'POST';
    document.getElementById('modalTitle').textContent = 'Tambah Berita';
    document.getElementById('previewContainer').classList.add('hidden');
    document.getElementById('beritaModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('beritaModal').classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Preview Image
document.getElementById('gambar_berita').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('gambarPreview').src = e.target.result;
            document.getElementById('previewContainer').classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
});

function resetImage() {
    document.getElementById('gambar_berita').value = '';
    document.getElementById('previewContainer').classList.add('hidden');
}

// Global Toast untuk notifikasi ringan
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

// SweetAlert2 - Simpan/Update
document.getElementById('beritaForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const btn = document.getElementById('submitBtn');
    btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin mr-2"></i> Memproses...';
    btn.disabled = true;

    const id = document.getElementById('beritaId').value;
    const url = id ? `/admin/beritas/${id}` : '/admin/beritas';
    const formData = new FormData(this);

    fetch(url, {
        method: 'POST',
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        if(data.success) {
            Swal.fire({ 
                icon: 'success', 
                title: 'Berhasil!', 
                text: 'Berita telah disimpan.', 
                showConfirmButton: false, 
                timer: 1500,
                customClass: { popup: 'rounded-[2rem]' } 
            }).then(() => location.reload());
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: data.message || 'Terjadi kesalahan.',
                confirmButtonColor: '#e11d48',
                customClass: {
                    popup: 'rounded-[2rem]',
                    confirmButton: 'rounded-xl font-bold px-8 py-3'
                }
            });
            btn.innerHTML = 'Simpan Publikasi';
            btn.disabled = false;
        }
    })
    .catch(() => {
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Koneksi bermasalah.',
            confirmButtonColor: '#e11d48',
            customClass: {
                popup: 'rounded-[2rem]',
                confirmButton: 'rounded-xl font-bold px-8 py-3'
            }
        });
        btn.disabled = false;
    });
});

// SweetAlert2 - Hapus
function deleteBerita(id) {
    Swal.fire({
        title: 'Hapus Berita?',
        text: "Data yang dihapus tidak bisa dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ef4444',
        cancelButtonColor: '#64748b',
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
            fetch(`/admin/beritas/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success) {
                    const row = document.getElementById(`berita-${id}`);
                    row.style.transform = 'translateX(50px)';
                    row.style.opacity = '0';
                    setTimeout(() => {
                        row.remove();
                        Toast.fire({ icon: 'success', title: 'Berita telah dibuang.' });
                    }, 300);
                }
            });
        }
    });
}

function openEditModal(id) {
    fetch(`/admin/beritas/${id}/edit`)
    .then(res => res.json())
    .then(data => {
        document.getElementById('beritaId').value = data.id_berita;
        document.getElementById('judul_berita').value = data.judul_berita;
        document.getElementById('link_berita').value = data.link_berita || '';
        document.getElementById('kategori_berita').value = data.kategori_berita;
        document.getElementById('tanggal_berita').value = data.tanggal_berita;
        document.getElementById('caption_berita').value = data.caption_berita || '';
        
        if (data.gambar_berita) {
            document.getElementById('gambarPreview').src = `/uploads/${data.gambar_berita}`;
            document.getElementById('previewContainer').classList.remove('hidden');
        } else {
            document.getElementById('previewContainer').classList.add('hidden');
        }
        
        document.getElementById('methodField').value = 'PUT';
        document.getElementById('modalTitle').textContent = 'Ubah Publikasi';
        document.getElementById('beritaModal').classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    });
}
</script>
@endsection