<!-- FOOTER -->
<div style="background:#0f172a; color:#cbd5e1; padding:40px 50px;">
    <div style="display:flex; justify-content:space-between; flex-wrap:wrap; gap:30px;">

        <!-- BRAND -->
        <div style="max-width:300px;">
            <h3 style="color:white;">RBTV Review System</h3>
            <p style="font-size:14px; margin-top:10px;">
                Platform untuk memberikan ulasan dan feedback terhadap program berita RBTV.
            </p>
        </div>

        <!-- LINK CEPAT -->
        <div>
            <h4 style="color:white;">Link Cepat</h4>
            <p><a href="{{ url('/') }}" style="color:#cbd5e1;">Beranda</a></p>
            <p><a href="{{ url('/program') }}" style="color:#cbd5e1;">Program</a></p>
            <p><a href="{{ url('/ulasan') }}" style="color:#cbd5e1;">Ulasan</a></p>
            <p><a href="{{ url('/tentang') }}" style="color:#cbd5e1;">Tentang</a></p>
        </div>

        <!-- KONTAK -->
        <div>
            <h4 style="color:white;">Kontak</h4>
            <p>Email: info@rbtv.co.id</p>
            <p>Phone: +62 21 1234 5678</p>
            <p>Alamat: Bengkulu, Indonesia</p>
        </div>

    </div>

    <!-- COPYRIGHT -->
    <div style="text-align:center; margin-top:30px; font-size:13px;">
        © {{ date('Y') }} RBTV. All rights reserved.
    </div>
</div>