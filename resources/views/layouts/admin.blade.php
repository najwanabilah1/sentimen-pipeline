<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RBTV Monitoring System</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <style>
        .sidebar {
            transition: transform 0.3s ease;
        }

        .sidebar-hidden {
            transform: translateX(-100%);
        }

        .overlay {
            background: rgba(0,0,0,0.4);
            backdrop-filter: blur(2px);
        }
    </style>
</head>

<body class="bg-gray-50 flex h-screen overflow-hidden">

    <!-- OVERLAY (mobile) -->
    <div id="overlay" class="fixed inset-0 overlay z-40 hidden md:hidden"></div>

    <!-- SIDEBAR -->
    <aside id="sidebar" class="sidebar fixed md:static z-50 w-64 bg-white border-r border-gray-200 flex flex-col h-full md:translate-x-0 sidebar-hidden md:sidebar-show">

        <div class="p-6 flex justify-between items-center">
            <img src="{{ asset('images/logo.png') }}" alt="RBTV">
            
            <!-- close btn mobile -->
            <button id="closeSidebar" class="md:hidden text-gray-500">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <nav class="flex-1 px-4 space-y-1">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->is('admin') ? 'text-red-600 bg-red-50 font-semibold' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg">
                <i class="fa-solid fa-chart-pie"></i> Dashboard
            </a>

            <a href="{{ route('admin.beritas.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->is('admin/beritas*') ? 'text-red-600 bg-red-50 font-semibold' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg">
                <i class="fa-solid fa-newspaper"></i> Berita
            </a>

            <a href="{{ route('admin.sentiment.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->is('admin/sentiment*') ? 'text-red-600 bg-red-50 font-semibold' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg">
                <i class="fa-solid fa-clipboard-check"></i> Evaluasi Sentimen
            </a>

            <a href="{{ route('admin.tim.index') }}" class="flex items-center gap-3 px-4 py-3 {{ request()->is('admin/tim*') ? 'text-red-600 bg-red-50 font-semibold' : 'text-gray-700 hover:bg-gray-50' }} rounded-lg">
                <i class="fa-solid fa-users"></i> Tim Redaksi
            </a>
        </nav>

        <!-- LOGOUT -->
        <div class="p-4 border-t">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full flex items-center gap-3 px-4 py-3 text-gray-600 hover:bg-red-50 hover:text-red-600 rounded-lg transition">
                    <i class="fa-solid fa-right-from-bracket"></i> Logout
                </button>
            </form>
        </div>

    </aside>

    <!-- MAIN -->
    <main class="flex-1 flex flex-col overflow-hidden">

        <!-- HEADER -->
        <header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 md:px-8">

            <!-- LEFT -->
            <div class="flex items-center gap-3">

                <!-- HAMBURGER -->
                <button id="openSidebar" class="md:hidden text-gray-700 text-xl">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <!-- SEARCH -->
                <div class="relative w-48 md:w-96">
                    <i class="fa-solid fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                    <input type="text" placeholder="Cari..." class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-red-500">
                </div>
            </div>

            <!-- RIGHT -->
            <div class="flex items-center gap-4">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-bold text-gray-900">Najwa Nabilah</p>
                    <p class="text-xs text-gray-500">Informatics Student</p>
                </div>

                <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-red-600 to-red-400 flex items-center justify-center text-white font-bold">
                    N
                </div>
            </div>

        </header>

        <!-- CONTENT -->
        <div class="flex-1 overflow-y-auto p-4 md:p-8">
            @yield('content')
        </div>

    </main>

    <!-- SCRIPT -->
    <script>
        const sidebar = document.getElementById("sidebar");
        const overlay = document.getElementById("overlay");
        const openBtn = document.getElementById("openSidebar");
        const closeBtn = document.getElementById("closeSidebar");

        openBtn.addEventListener("click", () => {
            sidebar.classList.remove("sidebar-hidden");
            overlay.classList.remove("hidden");
        });

        closeBtn.addEventListener("click", () => {
            sidebar.classList.add("sidebar-hidden");
            overlay.classList.add("hidden");
        });

        overlay.addEventListener("click", () => {
            sidebar.classList.add("sidebar-hidden");
            overlay.classList.add("hidden");
        });
    </script>

</body>
</html>