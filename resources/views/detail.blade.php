@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('assets/css/detail.css') }}">

<div class="detail-container">

    <!-- BACK -->
    <a href="{{ url('/program') }}" class="btn-back">← Kembali ke Program</a>

    @if(!$data)
        <h2 style="padding:50px">Berita tidak ditemukan</h2>
    @else

    <!-- MAIN CARD -->
    <div class="detail-card">

        <!-- IMAGE -->
        <div class="detail-hero">
            <img src="{{ asset('images/'.$data->gambar_berita) }}">
        </div>

        <!-- CONTENT -->
        <div class="detail-content">

            <span class="kategori">{{ $data->kategori_berita }}</span>

            <h1>{{ $data->judul_berita }}</h1>

            <!-- META -->
            <div class="meta">
                <span>
                    {{ \Carbon\Carbon::parse($data->tanggal_berita)->translatedFormat('l, d F Y') }}
                </span>

                <span class="rating-summary">
                    ⭐ {{ $avg }} ({{ $count }} ulasan)
                </span>
            </div>

            <hr>

            <p class="caption">
                {!! nl2br(e($data->caption_berita)) !!}
            </p>

            <!-- BUTTON -->
            <div class="action-btn">
                <a href="{{ url('/ulasan') }}" class="btn-primary">Beri Ulasan</a>
                <a href="{{ url('/program') }}" class="btn-secondary">Lihat Program Lain</a>
            </div>

        </div>

    </div>

    <!-- ULASAN -->
    <div class="ulasan-section">

        <h2>Ulasan Pengguna</h2>

        @if($count > 0)
            <div class="ulasan-list">

                @foreach($ulasan as $row)
                <div class="ulasan-card">

                    <!-- TOP -->
                    <div class="ulasan-top">
                        <div class="rating">
                            @for($i=1;$i<=5;$i++)
                                {{ $i <= $row->rating ? '⭐' : '☆' }}
                            @endfor
                        </div>

                        <span class="tanggal">
                            {{ \Carbon\Carbon::parse($row->waktu_kirim)->format('d F Y') }}
                        </span>
                    </div>

                    <!-- ISI -->
                    <p class="ulasan-text">
                        {{ $row->isi_ulasan_raw }}
                    </p>

                    <!-- USER -->
                    <div class="user">
                        {{ $row->nama_user }}
                    </div>

                </div>
                @endforeach

            </div>    
        @else
            <p class="no-ulasan">Belum ada ulasan untuk berita ini</p>
        @endif

    </div>

    @endif

</div>

<script src="{{ asset('assets/js/detail.js') }}"></script>

@endsection