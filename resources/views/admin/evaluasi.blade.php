@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Evaluasi & Analisis Sentimen</h1>
            <p class="text-gray-500 text-sm">Monitoring ulasan penonton menggunakan Naive Bayes</p>
        </div>
        <form action="{{ route('admin.sentiment.process') }}" method="POST">
            @csrf
            <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-6 py-2.5 rounded-xl flex items-center gap-2 shadow-lg shadow-red-200 transition-all active:scale-95">
                <i class="fa-solid fa-microchip"></i>
                <span>Jalankan Analisis AI</span>
            </button>
        </form>
    </div>

    @if(session('success'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-md">
            <div class="flex items-center">
                <i class="fa-solid fa-check-circle text-green-500 mr-3"></i>
                <p class="text-green-700 font-medium">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50/50 border-b border-gray-100">
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Info User</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider">Ulasan Clean</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Status Filter</th>
                    <th class="px-6 py-4 text-xs font-bold text-gray-500 uppercase tracking-wider text-center">Sentimen AI</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($reviews as $r)
                <tr class="hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="font-bold text-gray-900">{{ $r->nama_user }}</div>
                        <div class="text-xs text-gray-400">{{ $r->judul_berita }}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600 max-w-md">
                        {{ Str::limit($r->isi_ulasan_clean, 100) }}
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex justify-center gap-1">
                            @if($r->is_spam)
                                <span class="px-2 py-0.5 bg-orange-100 text-orange-600 rounded text-[10px] font-bold">SPAM</span>
                            @endif
                            @if($r->is_kasar)
                                <span class="px-2 py-0.5 bg-red-100 text-red-600 rounded text-[10px] font-bold">KASAR</span>
                            @endif
                            @if(!$r->is_spam && !$r->is_kasar)
                                <span class="px-2 py-0.5 bg-blue-100 text-blue-600 rounded text-[10px] font-bold">AMAN</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        @if($r->sentimen == 'Positif')
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-emerald-100 text-emerald-700 rounded-full text-xs font-bold">
                                <i class="fa-solid fa-face-smile"></i> POSITIF
                            </span>
                        @elseif($r->sentimen == 'Negatif')
                            <span class="inline-flex items-center gap-1 px-3 py-1 bg-red-100 text-red-700 rounded-full text-xs font-bold">
                                <i class="fa-solid fa-face-frown"></i> NEGATIF
                            </span>
                        @else
                            <span class="text-gray-300 text-xs italic">Menunggu AI...</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-6 py-10 text-center text-gray-400 italic">Belum ada ulasan yang masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection