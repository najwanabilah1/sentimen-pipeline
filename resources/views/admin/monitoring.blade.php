@extends('layouts.admin')

@section('content')
<div class="px-2 sm:px-4 lg:px-6 pt-2 pb-8 max-w-7xl mx-auto space-y-6">
    <!-- HERO SECTION MEGA PREMIUM -->
    <div class="relative bg-gradient-to-br from-slate-900 via-slate-800 to-indigo-900 rounded-[2.5rem] p-8 md:p-12 overflow-hidden shadow-[0_20px_50px_-12px_rgba(30,27,75,0.5)] group">
        <!-- Animated Background Blobs -->
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-blue-500/20 blur-3xl group-hover:scale-110 transition-transform duration-700 ease-in-out"></div>
        <div class="absolute bottom-0 left-10 -ml-20 -mb-20 w-80 h-80 rounded-full bg-red-500/20 blur-3xl group-hover:translate-x-10 transition-transform duration-700 ease-in-out"></div>
        
        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-8">
            <div class="transform group-hover:translate-x-2 transition-transform duration-500">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 bg-white/10 rounded-full text-white/90 text-[10px] font-black uppercase tracking-[0.2em] mb-4 backdrop-blur-md border border-white/20 shadow-inner">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse shadow-[0_0_10px_rgba(52,211,153,0.8)]"></span>
                    Sistem Penjadwalan Live
                </div>
                <h1 class="text-4xl md:text-5xl font-black text-white tracking-tight mb-3">
                    Manajemen <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-400 via-pink-400 to-yellow-400 drop-shadow-sm">Jadwal</span>
                </h1>
                <p class="text-indigo-100/70 text-sm md:text-base max-w-xl leading-relaxed font-medium">
                    Atur jadwal tayangan harian, dan kelola program dalam satu panel.
                </p>
            </div>
            <button onclick="openModal()" class="w-full md:w-auto px-8 py-4 bg-white/10 hover:bg-white/20 text-white border border-white/20 rounded-2xl font-black uppercase tracking-widest shadow-[0_8px_30px_rgb(0,0,0,0.12)] backdrop-blur-md transition-all hover:scale-105 active:scale-95 flex items-center justify-center gap-3 relative overflow-hidden group/btn">
                <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 -translate-x-[150%] skew-x-30 group-hover/btn:animate-[shimmer_1.5s_infinite]"></div>
                <i class="fa-solid fa-satellite-dish"></i> Tambah Tayangan
            </button>
        </div>
    </div>

    <!-- MAIN GRID -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Calendar -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[2rem] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-slate-200/50 transition-shadow duration-500 overflow-hidden h-full flex flex-col">
                <div class="px-8 py-6 border-b border-slate-50 flex items-center justify-between bg-slate-50/50">
                    <h3 class="text-2xl font-black text-slate-800 tracking-tight flex items-center gap-3" id="currentMonthYear">
                        Februari 2026
                    </h3>
                    <div class="flex gap-2">
                        <button onclick="changeMonth(-1)" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-white shadow-sm border border-slate-100 text-slate-400 hover:text-red-500 hover:border-red-200 hover:bg-red-50 transition-all active:scale-90">
                            <i class="fa-solid fa-chevron-left"></i>
                        </button>
                        <button onclick="changeMonth(1)" class="w-12 h-12 flex items-center justify-center rounded-2xl bg-white shadow-sm border border-slate-100 text-slate-400 hover:text-red-500 hover:border-red-200 hover:bg-red-50 transition-all active:scale-90">
                            <i class="fa-solid fa-chevron-right"></i>
                        </button>
                    </div>
                </div>
                <div class="p-8 flex-1">
                    <div class="grid grid-cols-7 gap-2 mb-4">
                        <div class="text-center text-[10px] font-black text-slate-400 py-2 uppercase tracking-widest">Sen</div>
                        <div class="text-center text-[10px] font-black text-slate-400 py-2 uppercase tracking-widest">Sel</div>
                        <div class="text-center text-[10px] font-black text-slate-400 py-2 uppercase tracking-widest">Rab</div>
                        <div class="text-center text-[10px] font-black text-slate-400 py-2 uppercase tracking-widest">Kam</div>
                        <div class="text-center text-[10px] font-black text-slate-400 py-2 uppercase tracking-widest">Jum</div>
                        <div class="text-center text-[10px] font-black text-red-500 py-2 uppercase tracking-widest">Sab</div>
                        <div class="text-center text-[10px] font-black text-red-500 py-2 uppercase tracking-widest">Min</div>
                    </div>
                    <div id="calendarGrid" class="grid grid-cols-7 gap-y-4 gap-x-2"></div>
                </div>
            </div>
        </div>

        <!-- Quick Stats -->
        <div class="space-y-4">
            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-[2rem] p-8 shadow-lg shadow-red-200/50 relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9InJnYmEoMjU1LCAyNTUsIDI1NSwgMC4xKSIvPjwvc3ZnPg==')] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <p class="text-xs text-red-100 mb-1 font-black uppercase tracking-widest">Berita Malam</p>
                <p class="text-4xl font-black text-white" id="count-Malam">0</p>
                <i class="fa-solid fa-video absolute -right-4 -bottom-4 text-7xl text-white/10 group-hover:scale-110 group-hover:rotate-12 transition-transform duration-500"></i>
            </div>
            
            <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-[2rem] p-8 shadow-lg shadow-blue-200/50 relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9InJnYmEoMjU1LCAyNTUsIDI1NSwgMC4xKSIvPjwvc3ZnPg==')] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <p class="text-xs text-blue-100 mb-1 font-black uppercase tracking-widest">Daerah</p>
                <p class="text-4xl font-black text-white" id="count-Daerah">0</p>
                <i class="fa-solid fa-map-location-dot absolute -right-4 -bottom-4 text-7xl text-white/10 group-hover:scale-110 group-hover:-rotate-12 transition-transform duration-500"></i>
            </div>
            
            <div class="bg-gradient-to-br from-violet-500 to-purple-600 rounded-[2rem] p-8 shadow-lg shadow-violet-200/50 relative overflow-hidden group hover:-translate-y-1 transition-transform duration-300">
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9InJnYmEoMjU1LCAyNTUsIDI1NSwgMC4xKSIvPjwvc3ZnPg==')] opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <p class="text-xs text-violet-100 mb-1 font-black uppercase tracking-widest">Pekaro</p>
                <p class="text-4xl font-black text-white" id="count-Pekaro">0</p>
                <i class="fa-solid fa-masks-theater absolute -right-4 -bottom-4 text-7xl text-white/10 group-hover:scale-110 group-hover:rotate-12 transition-transform duration-500"></i>
            </div>
        </div>
    </div>

    <!-- SCHEDULE LIST -->
    <div class="bg-white rounded-[2.5rem] border border-slate-100 shadow-sm overflow-hidden mt-8">
        <div class="px-8 py-6 border-b border-slate-50 flex items-center justify-between bg-slate-50/50">
            <h3 class="text-lg font-black text-slate-800 flex items-center gap-3">
                <div class="w-10 h-10 bg-white shadow-sm border border-slate-100 rounded-xl flex items-center justify-center text-red-500">
                    <i class="fa-regular fa-calendar-check"></i>
                </div>
                Jadwal Penayangan Hari <span id="todayHeader" class="text-red-500 font-black"></span>
            </h3>
        </div>
        <div class="p-8 min-h-[300px]">
             <div class="space-y-4" id="scheduleList"></div>
        </div>
    </div>
</div>

<!-- Modal CRUD Database -->
<div id="crudModal" class="hidden fixed inset-0 z-[100] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>
    <div class="relative bg-white rounded-[2.5rem] w-full max-w-lg shadow-[0_20px_50px_-12px_rgba(0,0,0,0.5)] overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="modalContent">
        <div class="px-8 py-6 border-b border-slate-50 flex justify-between items-center bg-white sticky top-0">
            <h2 class="text-2xl font-black text-slate-800" id="modalTitle">Tambah Tayangan</h2>
            <button onclick="closeModal()" class="w-10 h-10 bg-slate-50 hover:bg-red-50 text-slate-400 hover:text-red-500 rounded-xl flex items-center justify-center transition-all">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <form id="crudForm" class="p-8 space-y-6" onsubmit="saveSchedule(event)">
            <input type="hidden" id="formId">
            <div>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block">Judul Program</label>
                <input type="text" id="formJudul" required class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent focus:bg-white focus:border-red-500 hover:border-slate-200 rounded-[1.5rem] outline-none font-bold text-slate-700 transition-all">
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block">Waktu Mulai</label>
                    <input type="time" id="formWaktu" required class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent focus:bg-white focus:border-red-500 hover:border-slate-200 rounded-[1.5rem] outline-none font-bold text-slate-700 transition-all">
                </div>
                <div>
                    <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block">Durasi (Menit)</label>
                    <input type="number" id="formDurasi" required min="1" class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent focus:bg-white focus:border-red-500 hover:border-slate-200 rounded-[1.5rem] outline-none font-bold text-slate-700 transition-all">
                </div>
            </div>
            <div>
                <label class="text-[10px] font-black text-slate-400 uppercase tracking-widest ml-1 mb-2 block">Kategori / Segmen</label>
                <select id="formKategori" required class="w-full px-5 py-4 bg-slate-50 border-2 border-transparent focus:bg-white focus:border-red-500 hover:border-slate-200 rounded-[1.5rem] outline-none font-bold text-slate-700 transition-all appearance-none cursor-pointer">
                    <option value="Berita Malam">Berita Malam</option>
                    <option value="Daerah">Daerah</option>
                    <option value="Pekaro">Pekaro</option>
                </select>
            </div>
            <div class="pt-4 flex gap-3">
                <button type="button" onclick="closeModal()" class="flex-1 py-4 font-bold text-slate-400 hover:text-slate-600 hover:bg-slate-50 rounded-2xl transition-colors">Batal</button>
                <button type="submit" id="btnSubmit" class="flex-[2] py-4 bg-red-600 hover:bg-red-700 text-white font-black uppercase tracking-widest text-sm rounded-2xl shadow-xl shadow-red-200 transition-transform active:scale-95 flex items-center justify-center gap-2">
                    <span>Simpan ke Database</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    const INITIAL_DATE = new Date(); // Hari ini real
    let currentDate = new Date(INITIAL_DATE.getFullYear(), INITIAL_DATE.getMonth(), 1);
    let selectedDate = new Date(INITIAL_DATE.getTime());

    // Diambil langsung dari Database
    let rawJadwals = @json($jadwals);
    let schedules = rawJadwals.map(function(j) {
        let w = j.waktu.split(':');
        return {
            id: j.id,
            dateStr: j.tanggal,
            waktu: w[0] + ":" + w[1],
            judul: j.judul,
            kategori: j.kategori,
            durasi: j.durasi
        };
    });

    const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    const dayNames = ["Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"];
    
    function formatDateStr(date) {
        return date.getFullYear() + "-" + String(date.getMonth()+1).padStart(2,'0') + "-" + String(date.getDate()).padStart(2,'0');
    }

    function updateStats() {
        const counts = { "Berita Malam": 0, "Daerah": 0, "Pekaro": 0 };
        schedules.filter(s => s.dateStr === formatDateStr(selectedDate)).forEach(s => {
            if(counts[s.kategori] !== undefined) counts[s.kategori]++;
        });
        document.getElementById('count-Malam').innerText = counts["Berita Malam"] + " Prog";
        document.getElementById('count-Daerah').innerText = counts["Daerah"] + " Prog";
        document.getElementById('count-Pekaro').innerText = counts["Pekaro"] + " Prog";
    }

    function renderSchedules() {
        const str = formatDateStr(selectedDate);
        document.getElementById('todayHeader').textContent = dayNames[selectedDate.getDay()] + ", " + selectedDate.getDate() + " " + monthNames[selectedDate.getMonth()] + " " + selectedDate.getFullYear();
        
        const container = document.getElementById('scheduleList');
        const list = schedules.filter(s => s.dateStr === str).sort((a, b) => a.waktu.localeCompare(b.waktu));
        
        updateStats();

        if (list.length === 0) {
            container.innerHTML = `
            <div class="py-16 flex flex-col items-center justify-center border-2 border-dashed border-slate-200 rounded-[2rem] bg-slate-50/50">
                <div class="w-20 h-20 bg-white text-slate-300 rounded-[1.5rem] shadow-sm flex items-center justify-center text-4xl mb-4"><i class="fa-solid fa-satellite-dish"></i></div>
                <h4 class="text-slate-500 font-black text-lg">Jadwal Kosong</h4>
                <p class="text-sm text-slate-400 mt-1 font-medium">Belum ada tayangan tersimpan untuk tanggal ini.</p>
            </div>`;
            return;
        }

        container.innerHTML = list.map(item => {
            let badgeStyle = "bg-slate-500";
            if(item.kategori==="Berita Malam") badgeStyle="bg-gradient-to-r from-red-500 to-red-600 shadow-red-200";
            else if(item.kategori==="Daerah") badgeStyle="bg-gradient-to-r from-blue-600 to-indigo-600 shadow-blue-200";
            else if(item.kategori==="Pekaro") badgeStyle="bg-gradient-to-r from-violet-500 to-purple-600 shadow-violet-200";

            return `
            <div class="group flex flex-col sm:flex-row sm:items-center gap-4 p-5 bg-white border border-slate-100 hover:border-slate-300 shadow-[0_2px_10px_rgb(0,0,0,0.02)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.06)] rounded-2xl transition-all relative overflow-hidden">
                <div class="${badgeStyle} absolute left-0 top-0 bottom-0 w-2 opacity-90 group-hover:w-3 transition-all duration-300"></div>
                <div class="flex items-center gap-3 sm:w-28 flex-shrink-0 ml-4">
                    <span class="font-black text-slate-800 text-2xl tracking-tight">${item.waktu}</span>
                </div>
                <div class="flex-1 min-w-0 pr-20">
                    <h4 class="font-black text-slate-900 mb-2 text-lg lg:text-xl truncate">${item.judul}</h4>
                    <div class="flex items-center flex-wrap gap-3">
                        <span class="${badgeStyle} text-white shadow-sm text-[10px] uppercase font-black tracking-widest px-3 py-1 rounded-md">
                            ${item.kategori}
                        </span>
                        <span class="text-xs text-slate-500 font-bold bg-slate-50 px-2 py-1 rounded border border-slate-100">
                            <i class="fa-solid fa-hourglass-half text-slate-400 mr-1"></i> ${item.durasi} menit
                        </span>
                    </div>
                </div>
                <div class="absolute right-4 top-1/2 -translate-y-1/2 flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-all translate-x-4 group-hover:translate-x-0 bg-white/90 backdrop-blur-sm pl-4 py-3 rounded-l-xl">
                    <button onclick="editSchedule(${item.id})" class="w-10 h-10 bg-slate-50 hover:bg-blue-600 hover:text-white text-slate-400 rounded-xl flex items-center justify-center transition-all shadow-sm active:scale-95">
                        <i class="fa-solid fa-pen text-sm"></i>
                    </button>
                    <button onclick="deleteSchedule(${item.id})" class="w-10 h-10 bg-slate-50 hover:bg-red-600 hover:text-white text-slate-400 rounded-xl flex items-center justify-center transition-all shadow-sm active:scale-95">
                        <i class="fa-solid fa-trash text-sm"></i>
                    </button>
                </div>
            </div>`;
        }).join('');
    }

    function renderCalendar() {
        document.getElementById('currentMonthYear').textContent = `${monthNames[currentDate.getMonth()]} ${currentDate.getFullYear()}`;
        const grid = document.getElementById('calendarGrid');
        grid.innerHTML = '';

        const year = currentDate.getFullYear();
        const month = currentDate.getMonth();
        const daysInMonth = new Date(year, month + 1, 0).getDate();
        let startDay = new Date(year, month, 1).getDay() - 1;
        if (startDay === -1) startDay = 6;
        
        for (let i = 0; i < startDay; i++) {
            const div = document.createElement('div');
            grid.appendChild(div);
        }

        for (let day = 1; day <= daysInMonth; day++) {
            const dateStr = formatDateStr(new Date(year, month, day));
            const isSelected = selectedDate.getDate() === day && selectedDate.getMonth() === month && selectedDate.getFullYear() === year;
            const items = schedules.filter(s => s.dateStr === dateStr);
            const hasItems = items.length > 0;
            const isTodayDate = (day === INITIAL_DATE.getDate() && month === INITIAL_DATE.getMonth() && year === INITIAL_DATE.getFullYear());

            const div = document.createElement('div');
            div.onclick = () => selectDate(day, month, year);
            div.className = "relative text-center py-3.5 text-sm font-black rounded-xl cursor-pointer mx-1 flex items-center justify-center transition-all duration-300 transform outline-none ";
            
            if (isSelected) {
                div.className += "bg-gradient-to-br from-red-500 to-red-600 text-white shadow-lg shadow-red-200 scale-[1.15] z-10 border border-red-500 ";
            } else {
                div.className += "text-slate-600 hover:bg-slate-100 hover:text-slate-900 border border-transparent ";
                if (isTodayDate) div.className += "text-red-600 bg-red-50 border-red-200 ";
            }
            
            div.innerHTML = `<span>${day}</span>`;
            if (hasItems && !isSelected) div.innerHTML += `<div class="absolute bottom-1 w-1.5 h-1.5 bg-blue-500 rounded-full shadow-[0_0_5px_rgba(59,130,246,0.8)]"></div>`;
            grid.appendChild(div);
        }
    }

    function selectDate(d, m, y) {
        selectedDate = new Date(y, m, d);
        renderCalendar();
        renderSchedules();
    }

    function changeMonth(delta) {
        currentDate.setMonth(currentDate.getMonth() + delta);
        renderCalendar();
    }

    function openModal() {
        document.getElementById('formId').value = '';
        document.getElementById('crudForm').reset();
        document.getElementById('modalTitle').textContent = 'Tambah Jadwal Database';
        
        const modal = document.getElementById('crudModal');
        const content = document.getElementById('modalContent');
        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeModal() {
        const modal = document.getElementById('crudModal');
        const content = document.getElementById('modalContent');
        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');
        setTimeout(() => modal.classList.add('hidden'), 300);
    }

    async function saveSchedule(e) {
        e.preventDefault();
        const id = document.getElementById('formId').value;
        const btn = document.getElementById('btnSubmit');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fa-solid fa-circle-notch fa-spin"></i> Menyimpan...';
        btn.disabled = true;

        const payload = {
            tanggal: formatDateStr(selectedDate),
            judul: document.getElementById('formJudul').value,
            waktu: document.getElementById('formWaktu').value,
            durasi: document.getElementById('formDurasi').value,
            kategori: document.getElementById('formKategori').value
        };

        const url = id ? `/admin/monitoring/jadwal/${id}` : `/admin/monitoring/jadwal`;
        const method = id ? 'PUT' : 'POST';

        try {
            const res = await fetch(url, {
                method: method,
                headers: { 
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(payload)
            });
            const data = await res.json();
            
            if(data.success) {
                if (id) {
                    const idx = schedules.findIndex(s => s.id == parseInt(id));
                    if(idx > -1) schedules[idx] = { id: data.data.id, dateStr: data.data.tanggal, ...payload };
                } else {
                    schedules.push({ id: data.data.id, dateStr: data.data.tanggal, ...payload });
                }
                renderSchedules();
                renderCalendar();
                closeModal();
            } else {
                alert("Gagal menyimpan ke database!");
            }
        } catch(err) {
            console.error(err);
            alert("Terjadi kesalahan jaringan.");
        } finally {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    }

    function editSchedule(id) {
        const s = schedules.find(x => x.id === id);
        if(!s) return;
        
        document.getElementById('formId').value = s.id;
        document.getElementById('formJudul').value = s.judul;
        document.getElementById('formWaktu').value = s.waktu;
        document.getElementById('formDurasi').value = s.durasi;
        document.getElementById('formKategori').value = s.kategori;
        
        document.getElementById('modalTitle').textContent = 'Ubah Tanggal/Jadwal';
        const modal = document.getElementById('crudModal');
        const content = document.getElementById('modalContent');
        modal.classList.remove('hidden');
        setTimeout(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    async function deleteSchedule(id) {
        if(confirm('Hapus permanen dari database?')) {
            try {
                const res = await fetch(`/admin/monitoring/jadwal/${id}`, {
                    method: 'DELETE',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' }
                });
                const data = await res.json();

                if(data.success) {
                    schedules = schedules.filter(s => s.id !== id);
                    renderSchedules();
                    renderCalendar();
                }
            } catch(e) {
                alert("Gagal menghapus tayangan.");
            }
        }
    }

    // Init
    renderCalendar();
    renderSchedules();
</script>

<style>
    @keyframes shimmer {
        100% { transform: translateX(150%) skewX(30deg); }
    }
</style>
@endsection