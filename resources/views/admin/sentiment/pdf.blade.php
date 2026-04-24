<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Kinerja Sentimen RBTV</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
            font-size: 11pt;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #ed1b24; /* RBTV Red */
            padding-bottom: 15px;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #ed1b24;
            font-size: 24pt;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 10pt;
        }
        .section-title {
            background-color: #1e293b;
            color: #fff;
            padding: 8px 12px;
            font-size: 12pt;
            font-weight: bold;
            text-transform: uppercase;
            margin-top: 30px;
            margin-bottom: 10px;
        }
        .summary-box {
            border: 1px solid #e2e8f0;
            background-color: #f8fafc;
            padding: 15px;
            margin-bottom: 20px;
            border-left: 5px solid #ed1b24;
        }
        .summary-box.SANGAT-BAIK { border-left-color: #10b981; }
        .summary-box.WASPADA { border-left-color: #ef4444; }
        
        .summary-title {
            font-size: 13pt;
            font-weight: bold;
            margin-bottom: 10px;
            color: #1e293b;
        }
        
        .stats-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .stats-table td {
            text-align: center;
            width: 25%;
            padding: 10px;
            border: 1px solid #cbd5e1;
            background-color: #f1f5f9;
        }
        .stats-table td strong {
            display: block;
            font-size: 18pt;
            color: #334155;
            margin-top: 5px;
        }
        .stats-table td span {
            font-size: 9pt;
            text-transform: uppercase;
            font-weight: bold;
            color: #64748b;
        }
        .stats-table td.positif strong { color: #10b981; }
        .stats-table td.negatif strong { color: #ef4444; }

        table.data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
        }
        table.data-table th, table.data-table td {
            border: 1px solid #e2e8f0;
            padding: 8px;
            vertical-align: top;
        }
        table.data-table th {
            background-color: #f1f5f9;
            color: #475569;
            text-align: left;
            text-transform: uppercase;
        }
        table.data-table tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .badge {
            display: inline-block;
            padding: 3px 6px;
            font-size: 8pt;
            font-weight: bold;
            border-radius: 3px;
        }
        .badge.positif { background-color: #d1fae5; color: #065f46; border: 1px solid #34d399;}
        .badge.negatif { background-color: #fee2e2; color: #991b1b; border: 1px solid #f87171;}
        .badge.netral { background-color: #f1f5f9; color: #334155; border: 1px solid #94a3b8;}
        
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 8pt;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
            padding-top: 10px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h1>Executive Summary: Sentimen RBTV</h1>
        <p>Laporan Analisis Persepsi Pemirsa Berbasis AI - Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y H:i') }}</p>
    </div>

    <!-- AI Insights Area -->
    <div class="summary-box {{ str_contains($insight_status, 'WASPADA') ? 'WASPADA' : (str_contains($insight_status, 'BAIK') ? 'SANGAT-BAIK' : '') }}">
        <div class="summary-title">AI Insight & Rekomendasi Tindakan (Status: {{ $insight_status }})</div>
        <p style="margin-top: 0;"><strong>Analisis Situasi:</strong> {{ $insight_message }}</p>
        <p style="margin-bottom: 0;"><strong>Rekomendasi Kebijakan:</strong><br>
            {!! nl2br(e($action_recommendation)) !!}
        </p>
    </div>

    <div class="section-title">Distribusi Data Sentimen</div>
    <table class="stats-table">
        <tr>
            <td>
                <span>Total Ulasan</span>
                <strong>{{ $total }}</strong>
            </td>
            <td class="positif">
                <span>Sentimen Positif</span>
                <strong>{{ $positif }}</strong>
            </td>
            <td>
                <span>Sentimen Netral</span>
                <strong>{{ $netral }}</strong>
            </td>
            <td class="negatif">
                <span>Sentimen Negatif</span>
                <strong>{{ $negatif }}</strong>
            </td>
        </tr>
    </table>

    <div class="section-title">Log Data Ulasan Terakhir</div>
    <table class="data-table">
        <thead>
            <tr>
                <th width="20%">Judul Berita (Kategori)</th>
                <th width="15%">Pengguna</th>
                <th width="45%">Isi Komentar / Ulasan</th>
                <th width="10%">Sentimen</th>
                <th width="10%">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reviews->take(30) as $rev)
            <tr>
                <td>{{ $rev->judul_berita }} <br> <small>({{ $rev->kategori_berita }})</small></td>
                <td>{{ $rev->nama_user }}</td>
                <td>"{{ $rev->isi_ulasan_clean ?? $rev->isi_ulasan_raw }}"</td>
                <td style="text-align: center;">
                    @if($rev->sentimen == 'Positif')
                        <span class="badge positif">Positif</span>
                    @elseif($rev->sentimen == 'Negatif')
                        <span class="badge negatif">Negatif</span>
                    @elseif($rev->sentimen == 'Netral')
                        <span class="badge netral">Netral</span>
                    @else
                        -
                    @endif
                </td>
                <td>{{ \Carbon\Carbon::parse($rev->waktu_kirim)->format('d M y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p style="font-size: 8pt; color:#666; font-style:italic;">* Hanya menampilkan 30 ulasan terbaru dari total {{ $total }} data sentimen.</p>

    <div class="footer">
        Dicetak secara otomatis oleh Engine RBTV-AI | Laporan Asli Perusahaan
    </div>

</body>
</html>
