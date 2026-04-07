@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Berita</h1>
            <p class="text-gray-500 text-sm">Kelola berita dan artikel di RBTV</p>
        </div>
        <button onclick="openCreateModal()" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-xl flex items-center gap-2 shadow-sm transition">
            <i class="fa-solid fa-plus"></i> Tambah Berita
        </button>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 p-4 rounded-xl">
        <i class="fa-solid fa-check-circle mr-2"></i> {{ session('success') }}
    </div>
    @endif

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Judul</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Kategori</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Tanggal</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-700 uppercase tracking-wider">Gambar</th>
                    <th class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody id="beritasContainer" class="divide-y divide-gray-100">
                @forelse($beritas as $berita)
                <tr id="berita-{{ $berita->id_berita }}" class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $berita->id_berita }}</td>
                    <td class="px-6 py-4">
                        <div>
                            <p class="text-sm font-bold text-gray-900">{{ $berita->judul_berita }}</p>
                            <p class="text-xs text-gray-500 mt-1 line-clamp-1">{{ $berita->caption_berita }}</p>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded text-xs font-bold">{{ $berita->kategori_berita }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">{{ $berita->tanggal_berita }}</td>
                    <td class="px-6 py-4">
                        @if($berita->gambar_berita)
                        <img src="{{ asset('uploads/' . $berita->gambar_berita) }}" alt="{{ $berita->judul_berita }}" class="h-10 w-10 object-cover rounded">
                        @else
                        <span class="text-xs text-gray-400">Tidak ada gambar</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-2">
                            <button onclick="openEditModal({{ $berita->id_berita }})" type="button" class="p-2 text-gray-400 hover:text-blue-600 transition">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </button>
                            <button onclick="deleteBerita({{ $berita->id_berita }})" type="button" class="p-2 text-gray-400 hover:text-red-600 transition">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="px-6 py-12 text-center">
                        <p class="text-gray-500">Belum ada berita. <button onclick="openCreateModal()" class="text-red-600 font-bold">Buat yang pertama</button></p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL CREATE/EDIT -->
<div id="beritaModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-2xl w-full max-w-md mx-4 max-h-screen overflow-y-auto">
        <div class="sticky top-0 bg-white border-b border-gray-100 p-6 flex justify-between items-center">
            <h2 class="text-xl font-bold text-gray-900" id="modalTitle">Tambah Berita</h2>
            <button onclick="closeModal()" type="button" class="text-gray-400 hover:text-gray-600">
                <i class="fa-solid fa-times text-xl"></i>
            </button>
        </div>

        <form id="beritaForm" class="p-6 space-y-4" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="beritaId" name="id_berita">
            <input type="hidden" id="methodField" name="_method" value="POST">

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Judul Berita</label>
                <input type="text" id="judul_berita" name="judul_berita" placeholder="Masukkan judul berita" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:border-red-600" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                <select id="kategori_berita" name="kategori_berita" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:border-red-600" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Malam">Malam</option>
                    <option value="Daerah">Daerah</option>
                    <option value="Pekaro">Pekaro</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Tanggal Berita</label>
                <input type="date" id="tanggal_berita" name="tanggal_berita" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:border-red-600" required>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Caption Berita</label>
                <textarea id="caption_berita" name="caption_berita" rows="3" placeholder="Masukkan caption atau ringkasan berita" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:border-red-600" required></textarea>
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">Gambar</label>
                <input type="file" id="gambar_berita" name="gambar_berita" accept="image/*" class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:outline-none focus:border-red-600">
                <p class="text-xs text-gray-500 mt-1">Format: JPG, PNG, GIF, WebP (max 5MB)</p>
                <img id="gambarPreview" class="mt-2 rounded max-h-32 hidden">
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-xl font-bold transition">Simpan</button>
                <button type="button" onclick="closeModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-xl font-bold transition">Batal</button>
            </div>
        </form>
    </div>
</div>

<style>
    #beritaModal {
        backdrop-filter: blur(4px);
    }
</style>

<script>
const modal = document.getElementById('beritaModal');
const form = document.getElementById('beritaForm');
const beritaId = document.getElementById('beritaId');
const methodField = document.getElementById('methodField');
const modalTitle = document.getElementById('modalTitle');
const gambarInput = document.getElementById('gambar_berita');
const gambarPreview = document.getElementById('gambarPreview');

// Preview gambar
gambarInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            gambarPreview.src = e.target.result;
            gambarPreview.classList.remove('hidden');
        };
        reader.readAsDataURL(file);
    }
});

function openCreateModal() {
    form.reset();
    beritaId.value = '';
    methodField.value = 'POST';
    modalTitle.textContent = 'Tambah Berita Baru';
    gambarPreview.classList.add('hidden');
    modal.classList.remove('hidden');
}

function openEditModal(id) {
    // Fetch berita data
    fetch(`/admin/beritas/${id}/edit`)
        .then(response => response.json())
        .then(data => {
            beritaId.value = data.id_berita;
            document.getElementById('judul_berita').value = data.judul_berita;
            document.getElementById('kategori_berita').value = data.kategori_berita;
            document.getElementById('tanggal_berita').value = data.tanggal_berita;
            document.getElementById('caption_berita').value = data.caption_berita || '';
            
            if (data.gambar_berita) {
                gambarPreview.src = `/uploads/${data.gambar_berita}`;
                gambarPreview.classList.remove('hidden');
            } else {
                gambarPreview.classList.add('hidden');
            }
            
            methodField.value = 'PUT';
            modalTitle.textContent = 'Edit Berita';
            modal.classList.remove('hidden');
        })
        .catch(error => alert('Gagal memuat data berita'));
}

function closeModal() {
    modal.classList.add('hidden');
    form.reset();
    gambarPreview.classList.add('hidden');
}

form.addEventListener('submit', function(e) {
    e.preventDefault();
    
    const id = beritaId.value;
    const url = id ? `/admin/beritas/${id}` : '/admin/beritas';
    const method = id ? 'PUT' : 'POST';
    
    const formData = new FormData(form);
    
    // Debug: log form data
    console.log('Submitting form with method:', method);
    console.log('URL:', url);
    for (let [key, value] of formData.entries()) {
        console.log(`${key}:`, value);
    }
    
    fetch(url, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json',
        },
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            return response.json().then(data => {
                const errorMsg = data.message || JSON.stringify(data.errors) || 'Gagal menyimpan berita';
                throw new Error(errorMsg);
            });
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert('Berita berhasil disimpan!');
            location.reload();
        } else {
            alert('Gagal menyimpan berita: ' + (data.message || 'Error tidak diketahui'));
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan: ' + error.message);
    });
});

function deleteBerita(id) {
    if (!confirm('Yakin ingin menghapus berita ini?')) return;
    
    fetch(`/admin/beritas/${id}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json',
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById(`berita-${id}`).remove();
            alert('Berita berhasil dihapus!');
        } else {
            alert('Gagal menghapus berita');
        }
    })
    .catch(error => {
        alert('Terjadi kesalahan');
        console.error(error);
    });
}

// Close modal when clicking outside
modal.addEventListener('click', function(e) {
    if (e.target === modal) {
        closeModal();
    }
});
</script>
@endsection
