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
        <i class="fa-solid fa-check-circle mr-2"></i> {{ $message }}
    </div>
    @endif

    @if($message = session('info'))
    <div class="bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded-xl">
        <i class="fa-solid fa-info-circle mr-2"></i> {{ $message }}
    </div>
    @endif

    @if($message = session('error'))
    <div class="bg-red-50 border border-red-200 text-red-800 p-4 rounded-xl">
        <i class="fa-solid fa-exclamation-circle mr-2"></i> {{ $message }}
    </div>
    @endif

    <!-- Summary Stats -->
    <div class="grid grid-cols-4 gap-4">
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-xs text-gray-500 uppercase font-bold mb-2">Total Ulasan</p>
            <p class="text-3xl font-bold text-gray-900">{{ $reviews->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-xs text-gray-500 uppercase font-bold mb-2">Positif</p>
            <p class="text-3xl font-bold text-green-600">{{ $reviews->where('sentimen', 'Positif')->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-xs text-gray-500 uppercase font-bold mb-2">Netral</p>
            <p class="text-3xl font-bold text-blue-600">{{ $reviews->where('sentimen', 'Netral')->count() }}</p>
        </div>
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm">
            <p class="text-xs text-gray-500 uppercase font-bold mb-2">Negatif</p>
            <p class="text-3xl font-bold text-red-600">{{ $reviews->where('sentimen', 'Negatif')->count() }}</p>
        </div>
    </div>

    <!-- Reviews Table -->
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-100">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Judul Berita</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Penonton</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Rating</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Ulasan</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Sentimen</th>
                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-700 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($reviews as $review)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-gray-900 line-clamp-1">{{ $review->judul_berita }}</p>
                            <p class="text-xs text-gray-500">{{ $review->kategori_berita }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm text-gray-900">{{ $review->nama_user }}</p>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-1">
                                @if($review->rating)
                                    @for($i = 0; $i < $review->rating; $i++)
                                    <i class="fa-solid fa-star text-yellow-400 text-xs"></i>
                                    @endfor
                                @else
                                    <span class="text-xs text-gray-400">-</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-6 py-4 max-w-xs">
                            <p class="text-sm text-gray-600 line-clamp-2">{{ $review->isi_ulasan_clean ?? $review->isi_ulasan_raw }}</p>
                        </td>
                        <td class="px-6 py-4">
                            @if($review->sentimen)
                                @php
                                    $sentimentColor = match($review->sentimen) {
                                        'Positif' => 'bg-green-100 text-green-700',
                                        'Netral' => 'bg-blue-100 text-blue-700',
                                        'Negatif' => 'bg-red-100 text-red-700',
                                        default => 'bg-gray-100 text-gray-700'
                                    };
                                @endphp
                                <span class="inline-block px-3 py-1 text-xs font-bold rounded-full {{ $sentimentColor }}">
                                    {{ $review->sentimen }}
                                </span>
                            @else
                                <span class="inline-block px-3 py-1 text-xs font-bold rounded-full bg-yellow-100 text-yellow-700">
                                    Pending
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-xs text-gray-500">
                                {{ $review->waktu_analisis ? $review->waktu_analisis->diffForHumans() : '-' }}
                            </p>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <p class="text-gray-500">Belum ada ulasan untuk dianalisis</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
