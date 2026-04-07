@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('assets/css/program.css') }}">

<div class="program-container">

    <!-- HERO -->
    <div class="program-hero">
        <h1>Program Berita RBTV</h1>
        <p>Jelajahi seluruh program berita terbaru dan terupdate dari RBTV</p>
    </div>

    <!-- FILTER -->
    <div class="filter-bar">
        <input type="text" id="searchInput" placeholder="Cari berita...">

        <select id="sortSelect">
            <option value="terbaru">Terbaru</option>
            <option value="terlama">Terlama</option>
            <option value="az">Judul A-Z</option>
            <option value="za">Judul Z-A</option>
        </select>

        <select id="kategoriSelect">
            <option value="">Semua Kategori</option>
            <option value="Malam">Berita Malam</option>
            <option value="Daerah">Berita Daerah</option>
            <option value="Pekaro">Pekaro</option>
        </select>
    </div>

    <!-- LIST -->
    <div id="beritaList">

        @foreach($berita as $row)
        <div class="berita-item"
            data-judul="{{ strtolower($row->judul_berita) }}"
            data-kategori="{{ $row->kategori_berita }}"
            data-tanggal="{{ $row->tanggal_berita }}"
        >

            <!-- IMAGE -->
            <div class="thumb">
                <img src="{{ asset('images/'.$row->gambar_berita) }}">
            </div>

            <!-- CONTENT -->
            <div class="berita-content">

                <div class="top">
                    <span class="kategori">{{ $row->kategori_berita }}</span>
                </div>

                <h3>{{ $row->judul_berita }}</h3>

                <p>{{ \Illuminate\Support\Str::limit($row->caption_berita, 120) }}</p>

                <div class="meta">
                    {{ \Carbon\Carbon::parse($row->tanggal_berita)->format('d F Y') }}
                </div>
            </div>

            <!-- ACTION -->
            <div class="action">
                <a href="{{ url('detail/'.$row->id_berita) }}" class="btn-detail">
                    Detail
                </a>
            </div>

        </div>
        @endforeach

    </div>

</div>

<script src="{{ asset('assets/js/program.js') }}"></script>

@endsection