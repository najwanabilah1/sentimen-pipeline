@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Analisis Sentimen</h1>
            <p class="text-gray-500 text-sm">Analisis sentimen ulasan penonton menggunakan AI</p>
        </div>
        <form action="{{ route('admin.sentiment.process') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-5 py-2 rounded-xl flex items-center gap-2 shadow-sm transition">
                <i class="fa-solid fa-brain"></i> Proses Analisis
            </button>
        </form>
    </div>

    @if($message = session('success'))
    <div class="bg-green-50 border border-green-200 text-green-800 p-4 rounded-xl">
        {{ $message }}
    </div>
    @endif

    @if($message = session('error'))
    <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-xl">
        {{ $message }}
    </div>
    @endif

    <!-- Table -->
    <div class="bg-white rounded-2xl border shadow-sm overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-4 text-left">Judul</th>
                    <th class="p-4">User</th>
                    <th class="p-4">Rating</th>
                    <th class="p-4">Ulasan</th>
                    <th class="p-4">Sentimen</th>
                    <th class="p-4">Waktu</th>
                </tr>
            </thead>

            <tbody>
                @forelse($reviews as $review)
                <tr class="border-t">
                    <td class="p-4">
                        <b>{{ $review->judul_berita }}</b><br>
                        <small>{{ $review->kategori_berita }}</small>
                    </td>

                    <td class="p-4">{{ $review->nama_user }}</td>

                    <td class="p-4">
                        @if($review->rating)
                            ⭐ {{ $review->rating }}
                        @else
                            -
                        @endif
                    </td>

                    <td class="p-4">
                        {{ $review->isi_ulasan_clean ?? $review->isi_ulasan_raw }}
                    </td>

                    <td class="p-4">
                        @if($review->sentimen)
                            <span class="px-2 py-1 rounded 
                                {{ $review->sentimen == 'Positif' ? 'bg-green-100 text-green-700' : '' }}
                                {{ $review->sentimen == 'Negatif' ? 'bg-red-100 text-red-700' : '' }}
                                {{ $review->sentimen == 'Netral' ? 'bg-blue-100 text-blue-700' : '' }}">
                                {{ $review->sentimen }}
                            </span>
                        @else
                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded">
                                Pending
                            </span>
                        @endif
                    </td>

                    <td class="p-4 text-sm text-gray-500">
                        {{ $review->waktu_analisis?->diffForHumans() ?? '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center p-6">
                        Tidak ada data
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection