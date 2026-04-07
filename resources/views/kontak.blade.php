@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('assets/css/kontak.css') }}">

<div class="kontak-container">

    <!-- HERO -->
    <div class="kontak-hero">
        <h1>Hubungi Kami</h1>
        <p>Kami siap membantu Anda terkait sistem review RBTV</p>
    </div>

    <!-- CONTENT -->
    <div class="kontak-content">

        <!-- KONTAK AKSI -->
        <div class="kontak-form">
            <h3>Hubungi Kami Langsung</h3>

            <!-- WHATSAPP -->
            <a href="https://wa.me/6281234567890" target="_blank" class="btn-kirim">
                💬 Chat via WhatsApp
            </a>

            <!-- EMAIL -->
            <a href="mailto:info@rbtv.co.id" class="btn-kirim" style="margin-top:10px;">
                📧 Kirim Email
            </a>

            <!-- INSTAGRAM -->
            <a href="https://instagram.com/rbtv" target="_blank" class="btn-kirim" style="margin-top:10px;">
                📸 Instagram
            </a>

            <!-- YOUTUBE -->
            <a href="https://youtube.com" target="_blank" class="btn-kirim" style="margin-top:10px;">
                ▶️ YouTube
            </a>
        </div>

        <!-- INFO -->
        <div class="kontak-info">
            <h3>Informasi Kontak</h3>

            <div class="info-item">
                <strong>Email</strong>
                <p>info@rbtv.co.id</p>
            </div>

            <div class="info-item">
                <strong>Telepon</strong>
                <p>+62 812 3456 7890</p>
            </div>

            <div class="info-item">
                <strong>Alamat</strong>
                <p>Bengkulu, Indonesia</p>
            </div>
        </div>

    </div>

    <!-- CTA -->
    <div class="cta">
        <h2>Butuh Bantuan Cepat?</h2>
        <p>
            Hubungi kami langsung melalui WhatsApp untuk respon yang lebih cepat.
        </p>

        <a href="https://wa.me/6281234567890" class="btn-cta">
            Chat Sekarang
        </a>
    </div>

</div>

@endsection