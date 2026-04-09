@extends('layouts.admin')

@section('content')
<style>
    /* --- ANIMASI & STYLE --- */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in { animation: fadeInUp 0.5s ease-out forwards; }
    .delay-100 { animation-delay: 100ms; opacity: 0; }
    .delay-200 { animation-delay: 200ms; opacity: 0; }

    #beritaModal { backdrop-filter: blur(8px); }
    
    /* Custom Scrollbar untuk Modal */
    .custom-scroll::-webkit-scrollbar { width: 5px; }
    .custom-scroll::-webkit-scrollbar-track { background: #f1f1f1; }
    .custom-scroll::-webkit-scrollbar-thumb { background: #ef4444; border-radius: 10px; }
</style>

<div class="px-4 sm:px-6 lg:px-8 py-8 max-w-7xl mx-auto">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8 animate-fade-in">
        <div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-800 tracking-tight">Manajemen Berita</h1>
            <p class="text-sm md:text-base text-gray-500 mt-1 flex items-center gap-2">
                <span class="w-2 h-2 bg-red-500 rounded-full animate-pulse"></span>
                Kelola konten artikel dan publikasi RBTV
            </p>
        </div>
        <button onclick="openCreateModal()" class="bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-700 hover:to-rose-700 text-white px-6 py-3 rounded-2xl flex items-center justify-center gap-2 shadow-lg shadow-red-200 transition-all active:scale-95 font-bold text-sm">
            <i class="fa-solid fa-plus"></i> Tambah Berita Baru
        </button>
    </div>

    @if(session('success'))
    <div class="mb-6 animate-fade-in bg-emerald-50 border-l-4 border-emerald-500 text-emerald-800 p-4 rounded-xl shadow-sm flex items-center justify-between">
        <div class="flex items-center">
            <i class="fa-solid fa-circle-check mr-3 text-emerald-500 text-lg"></i>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    @endif

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden animate-fade-in delay-100">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Konten Berita</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Kategori</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Tanggal Rilis</th>
                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="beritasContainer" class="divide-y divide-gray-50">
                    @forelse($beritas as $berita)
                    <tr id="berita-{{ $berita->id_berita }}" class="hover:bg-gray-50/80 transition-colors group">
                        <td class="px-6 py-5">
                            <div class="flex items-center gap-4">
                                <div class="relative h-14 w-14 flex-shrink-0">
                                    @if($berita->gambar_berita)
                                        <img src="{{ asset('uploads/' . $berita->gambar_berita) }}" class="h-full w-full object-cover rounded-xl shadow-sm border border-gray-100">
                                    @else
                                        <div class="h-full w-full bg-gray-100 rounded-xl flex items-center justify-center text-gray-400">
                                            <i class="fa-solid fa-image"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="max-w-xs md:max-w-md">
                                    <p class="text-sm font-bold text-gray-800 line-clamp-1 group-hover:text-red-600 transition-colors">{{ $berita->judul_berita }}</p>
                                    <p class="text-xs text-gray-400 mt-1 line-clamp-1 italic">{{ $berita->caption_berita ?? 'Tidak ada deskripsi.' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-5">
                            @php
                                $colors = [
                                    'Malam' => 'bg-indigo-50 text-indigo-600 border-indigo-100',
                                    'Daerah' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                    'Pekaro' => 'bg-amber-50 text-amber-600 border-amber-100',
                                ];
                                $colorClass = $colors[$berita->kategori_berita] ?? 'bg-gray-50 text-gray-600 border-gray-100';
                            @endphp
                            <span class="px-3 py-1.5 {{ $colorClass }} border rounded-lg text-[10px] font-extrabold uppercase tracking-wider">
                                {{ $berita->kategori_berita }}
                            </span>
                        </td>
                        <td class="px-6 py-5">
                            <div class="flex flex-col">
                                <span class="text-sm font-semibold text-gray-700 italic">{{ date('d M Y', strtotime($berita->tanggal_berita)) }}</span>
                                <span class="text-[10px] text-gray-400 uppercase font-bold tracking-tighter">ID: #{{ $berita->id_berita }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-5 text-center">
                            <div class="flex justify-center gap-1">
                                <button onclick="openEditModal({{ $berita->id_berita }})" class="w-9 h-9 flex items-center justify-center rounded-xl text-gray-400 hover:bg-blue-50 hover:text-blue-600 transition-all">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </button>
                                <button onclick="deleteBerita({{ $berita->id_berita }})" class="w-9 h-9 flex items-center justify-center rounded-xl text-gray-400 hover:bg-red-50 hover:text-red-600 transition-all">
                                    <i class="fa-solid fa-trash-can"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-20 text-center">
                            <div class="flex flex-col items-center">
                                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4 text-gray-300">
                                    <i class="fa-solid fa-newspaper text-3xl"></i>
                                </div>
                                <h3 class="text-lg font-bold text-gray-800">Belum Ada Berita</h3>
                                <p class="text-gray-400 text-sm max-w-xs mx-auto mt-2">Mulai publikasikan informasi menarik hari ini melalui tombol tambah berita.</p>
                                <button onclick="openCreateModal()" class="mt-4 text-red-600 font-bold hover:underline">Buat yang pertama &rarr;</button>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="beritaModal" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-gray-900/40 backdrop-blur-sm"></div>
    
    <div class="relative bg-white rounded-[2.5rem] w-full max-w-lg shadow-2xl overflow-hidden animate-fade-in flex flex-col max-h-[90vh]">
        <div class="p-8 pb-4 flex justify-between items-center border-b border-gray-50">
            <div>
                <h2 class="text-2xl font-extrabold text-gray-800" id="modalTitle">Tambah Berita</h2>
                <p class="text-xs text-gray-400 mt-1 uppercase tracking-widest font-bold">Informasi Konten</p>
            </div>
            <button onclick="closeModal()" class="w-10 h-10 bg-gray-50 text-gray-400 hover:text-gray-600 rounded-full flex items-center justify-center transition-colors">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <form id="beritaForm" class="p-8 pt-6 space-y-5 overflow-y-auto custom-scroll" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="beritaId" name="id_berita">
            <input type="hidden" id="methodField" name="_method" value="POST">

            <div class="space-y-2">
                <label class="text-xs font-extrabold text-gray-500 uppercase tracking-wider ml-1">Judul Berita</label>
                <input type="text" id="judul_berita" name="judul_berita" placeholder="Contoh: Kejadian di Bengkulu Hari Ini" class="w-full px-5 py-4 bg-gray-50 border-transparent focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl transition-all outline-none text-sm font-semibold" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="text-xs font-extrabold text-gray-500 uppercase tracking-wider ml-1">Kategori</label>
                    <select id="kategori_berita" name="kategori_berita" class="w-full px-5 py-4 bg-gray-50 border-transparent focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl transition-all outline-none text-sm font-semibold appearance-none cursor-pointer" required>
                        <option value="">Pilih...</option>
                        <option value="Malam">Malam</option>
                        <option value="Daerah">Daerah</option>
                        <option value="Pekaro">Pekaro</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="text-xs font-extrabold text-gray-500 uppercase tracking-wider ml-1">Tanggal</label>
                    <input type="date" id="tanggal_berita" name="tanggal_berita" class="w-full px-5 py-4 bg-gray-50 border-transparent focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl transition-all outline-none text-sm font-semibold" required>
                </div>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-extrabold text-gray-500 uppercase tracking-wider ml-1">Ringkasan / Caption</label>
                <textarea id="caption_berita" name="caption_berita" rows="3" placeholder="Tuliskan intisari berita..." class="w-full px-5 py-4 bg-gray-50 border-transparent focus:bg-white focus:border-red-500 focus:ring-4 focus:ring-red-500/10 rounded-2xl transition-all outline-none text-sm font-semibold resize-none" required></textarea>
            </div>

            <div class="space-y-2">
                <label class="text-xs font-extrabold text-gray-500 uppercase tracking-wider ml-1">Cover Berita</label>
                <div class="relative group">
                    <input type="file" id="gambar_berita" name="gambar_berita" accept="image/*" class="absolute inset-0 opacity-0 cursor-pointer z-10">
                    <div class="border-2 border-dashed border-gray-200 rounded-2xl p-6 text-center group-hover:border-red-400 transition-colors">
                        <i class="fa-solid fa-cloud-arrow-up text-2xl text-gray-300 mb-2 group-hover:text-red-500 transition-colors"></i>
                        <p class="text-xs font-bold text-gray-400 group-hover:text-gray-600">Klik atau drag gambar ke sini</p>
                    </div>
                </div>
                <div id="previewContainer" class="mt-4 relative hidden">
                    <img id="gambarPreview" class="rounded-2xl w-full h-40 object-cover border-4 border-white shadow-md">
                    <button type="button" onclick="resetImage()" class="absolute top-2 right-2 bg-red-600 text-white w-8 h-8 rounded-full shadow-lg">
                        <i class="fa-solid fa-times text-xs"></i>
                    </button>
                </div>
            </div>

            <div class="flex gap-4 pt-4 sticky bottom-0 bg-white">
                <button type="button" onclick="closeModal()" class="flex-1 px-6 py-4 rounded-2xl font-bold text-gray-500 hover:bg-gray-50 transition-colors">Batal</button>
                <button type="submit" class="flex-1 px-6 py-4 bg-red-600 hover:bg-red-700 text-white rounded-2xl font-bold shadow-lg shadow-red-200 transition-all active:scale-95">Simpan Data</button>
            </div>
        </form>
    </div>
</div>

<script>
// --- LOGIKA MODAL & CRUD ---
const modal = document.getElementById('beritaModal');
const form = document.getElementById('beritaForm');
const previewContainer = document.getElementById('previewContainer');
const gambarPreview = document.getElementById('gambarPreview');

function openCreateModal() {
    form.reset();
    document.getElementById('beritaId').value = '';
    document.getElementById('methodField').value = 'POST';
    document.getElementById('modalTitle').textContent = 'Tambah Berita';
    previewContainer.classList.add('hidden');
    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Reset Image Preview
function resetImage() {
    document.getElementById('gambar_berita').value = '';
    previewContainer.classList.add('hidden');
}

// Preview Logic
document.getElementById('gambar_berita').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            gambarPreview.src = e.target.result;
            previewContainer.classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
});

function openEditModal(id) {
    fetch(`/admin/beritas/${id}/edit`)
        .then(res => res.json())
        .then(data => {
            document.getElementById('beritaId').value = data.id_berita;
            document.getElementById('judul_berita').value = data.judul_berita;
            document.getElementById('kategori_berita').value = data.kategori_berita;
            document.getElementById('tanggal_berita').value = data.tanggal_berita;
            document.getElementById('caption_berita').value = data.caption_berita || '';
            
            if (data.gambar_berita) {
                gambarPreview.src = `/uploads/${data.gambar_berita}`;
                previewContainer.classList.remove('hidden');
            } else {
                previewContainer.classList.add('hidden');
            }
            
            document.getElementById('methodField').value = 'PUT';
            document.getElementById('modalTitle').textContent = 'Ubah Berita';
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        });
}

form.addEventListener('submit', function(e) {
    e.preventDefault();
    const id = document.getElementById('beritaId').value;
    const url = id ? `/admin/beritas/${id}` : '/admin/beritas';
    const formData = new FormData(this);

    // Kirim menggunakan POST tapi sertakan _method untuk Laravel spoofing
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            location.reload();
        } else {
            alert('Kesalahan: ' + (data.message || 'Gagal menyimpan data'));
        }
    })
    .catch(err => console.error(err));
});

function deleteBerita(id) {
    if (confirm('Hapus berita ini secara permanen?')) {
        fetch(`/admin/beritas/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) {
                document.getElementById(`berita-${id}`).style.opacity = '0';
                setTimeout(() => document.getElementById(`berita-${id}`).remove(), 300);
            }
        });
    }
}
</script>
@endsection