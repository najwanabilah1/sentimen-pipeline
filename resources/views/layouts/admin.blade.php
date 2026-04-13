<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RBTV | Monitoring System</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; transition: background-color 0.3s ease; }
        .sidebar-transition { transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        .nav-active {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
            box-shadow: 0 8px 15px -3px rgba(239, 68, 68, 0.25);
            color: white !important;
        }
    </style>
</head>

<body class="bg-[#F8FAFC] dark:bg-slate-900 text-slate-900 dark:text-slate-100 flex h-screen overflow-hidden">

    <div id="overlay" class="fixed inset-0 bg-slate-900/40 backdrop-blur-sm z-40 hidden md:hidden"></div>

    <aside id="sidebar" class="sidebar-transition fixed md:static z-50 w-72 bg-white dark:bg-slate-800 border-r border-slate-200 dark:border-slate-700 flex flex-col h-full -translate-x-full md:translate-x-0">
        
        <div class="p-8 flex items-center justify-between">
            <img src="{{ asset('images/logo.png') }}" alt="RBTV" class="h-7 w-auto">
            <button id="closeSidebar" class="md:hidden p-2 text-slate-400"><i class="fa-solid fa-xmark"></i></button>
        </div>

        <nav class="flex-1 px-4 space-y-1.5 overflow-y-auto">
            <p class="px-4 text-[10px] font-bold text-slate-400 dark:text-slate-500 uppercase tracking-[0.2em] mb-4">Navigation</p>
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->is('admin') ? 'nav-active' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-slate-900 dark:hover:text-white' }}">
                <i class="fa-solid fa-house-chimney w-5"></i> 
                <span class="text-sm font-bold">Dashboard</span>
            </a>

            <a href="{{ route('admin.monitoring') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.monitoring*') ? 'nav-active' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-slate-900 dark:hover:text-white' }}">
                <i class="fa-regular fa-calendar-days w-5"></i> 
                <span class="text-sm font-bold">Jadwal</span>
            </a>

            <a href="{{ route('admin.beritas.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->is('admin/beritas*') ? 'nav-active' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-slate-900 dark:hover:text-white' }}">
                <i class="fa-solid fa-clapperboard w-5"></i> 
                <span class="text-sm font-bold">Berita</span>
            </a>

            <a href="{{ route('admin.sentiment.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->is('admin/sentiment*') ? 'nav-active' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-slate-900 dark:hover:text-white' }}">
                <i class="fa-solid fa-chart-pie w-5"></i> 
                <span class="text-sm font-bold">Sentimen</span>
            </a>

            <a href="{{ route('admin.tim.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->is('admin/tim*') ? 'nav-active' : 'text-slate-500 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-700/50 hover:text-slate-900 dark:hover:text-white' }}">
                <i class="fa-solid fa-user-shield w-5"></i> 
                <span class="text-sm font-bold">Tim Redaksi</span>
            </a>
        </nav>

        <div class="p-4 border-t border-slate-100 dark:border-slate-700 space-y-2">
            <div class="flex items-center justify-between px-2 mb-4">
                <div class="w-10 h-10 rounded-full bg-slate-900 dark:bg-white text-white dark:text-slate-900 flex items-center justify-center font-black text-sm shadow-lg">N</div>
                
                <button id="darkModeToggle" class="w-10 h-10 flex items-center justify-center rounded-xl hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-500 dark:text-yellow-400 transition-all">
                    <i class="fa-solid fa-moon dark:hidden"></i>
                    <i class="fa-solid fa-sun hidden dark:block"></i>
                </button>
            </div>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-red-600 dark:hover:text-red-400 transition-all group">
                    <i class="fa-solid fa-power-off text-sm group-hover:rotate-90 transition-transform duration-300"></i>
                    <span class="text-xs font-extrabold uppercase tracking-widest">Sign Out</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="flex-1 flex flex-col min-w-0 overflow-hidden">
        
        <header class="h-16 flex items-center px-6 md:px-10 shrink-0 md:hidden">
            <button id="openSidebar" class="text-slate-600 dark:text-slate-300">
                <i class="fa-solid fa-bars-staggered text-xl"></i>
            </button>
        </header>

        <div class="flex-1 overflow-y-auto">
            <div class="p-6 md:p-10">
                @yield('content')
            </div>
        </div>
    </main>

    <script>
        const sidebar = document.getElementById("sidebar");
        const overlay = document.getElementById("overlay");
        const openBtn = document.getElementById("openSidebar");
        const closeBtn = document.getElementById("closeSidebar");
        const darkModeToggle = document.getElementById("darkModeToggle");

        // Theme logic
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }

        darkModeToggle.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
        });

        // Sidebar logic
        const toggleSidebar = () => {
            sidebar.classList.toggle("-translate-x-full");
            overlay.classList.toggle("hidden");
        };

        if(openBtn) openBtn.addEventListener("click", toggleSidebar);
        closeBtn.addEventListener("click", toggleSidebar);
        overlay.addEventListener("click", toggleSidebar);
    </script>
</body>
</html>