<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Luxury Resort Admin</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:ital,wght@0,400..700;1,400..700&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap" rel="stylesheet">
    
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <!-- Tailwind CSS (compiled via Vite) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Instrument Sans', sans-serif;
            background-color: #f8fafc; /* light blue gray */
        }
        .font-playfair {
            font-family: 'Playfair Display', serif;
        }
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
    @yield('styles')
</head>
<body class="min-h-screen flex">

    <!-- Mobile Hamburger Menu Button -->
    <div class="fixed top-4 left-4 z-50 lg:hidden">
        <button id="mobileMenuBtn" class="p-2.5 bg-slate-900 text-white rounded-xl shadow-lg border border-slate-800 focus:outline-none cursor-pointer">
            <i data-lucide="menu" class="w-6 h-6" id="menuIcon"></i>
        </button>
    </div>

    <!-- Sidebar Layout -->
    <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 w-72 bg-slate-950 border-r border-slate-900 p-6 flex flex-col justify-between transition-transform duration-300 -translate-x-full lg:translate-x-0 lg:static lg:h-screen lg:shrink-0 text-slate-300">
        <div class="space-y-8">
            <!-- Brand -->
            <div class="flex items-center gap-3 border-b border-slate-900 pb-6">
                <div class="flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-tr from-amber-500 to-amber-300 text-slate-950 font-bold shadow-md shadow-amber-500/5 shrink-0">
                    <i data-lucide="hotel" class="w-5.5 h-5.5"></i>
                </div>
                <div>
                    <h2 class="font-playfair text-lg font-bold text-white tracking-wider leading-none">LUXURY</h2>
                    <span class="text-[10px] text-amber-500 font-semibold tracking-widest uppercase">Admin Panel</span>
                </div>
            </div>

            <!-- Menus -->
            <nav class="space-y-1.5">
                <span class="block text-[10px] font-bold text-slate-600 uppercase tracking-widest px-3 mb-2">Resort Operations</span>
                
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all font-medium text-sm group {{ request()->routeIs('admin.dashboard') ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100 border border-transparent' }}">
                    <i data-lucide="layout-dashboard" class="w-5 h-5 transition-transform group-hover:scale-105"></i>
                    <span>Dashboard</span>
                </a>
                
                <a href="{{ route('admin.rooms.index') }}" 
                   class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all font-medium text-sm group {{ request()->routeIs('admin.rooms.*') ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100 border border-transparent' }}">
                    <i data-lucide="bed-double" class="w-5 h-5 transition-transform group-hover:scale-105"></i>
                    <span>Manage Rooms</span>
                </a>
                
                <a href="{{ route('admin.bookings.index') }}" 
                   class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all font-medium text-sm group {{ request()->routeIs('admin.bookings.*') ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100 border border-transparent' }}">
                    <i data-lucide="calendar-check" class="w-5 h-5 transition-transform group-hover:scale-105"></i>
                    <span>Room Bookings</span>
                </a>

                <div class="h-px bg-slate-900/60 my-6"></div>
                <span class="block text-[10px] font-bold text-slate-600 uppercase tracking-widest px-3 mb-2">F&B Services</span>

                <a href="{{ route('admin.foods.index') }}" 
                   class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all font-medium text-sm group {{ request()->routeIs('admin.foods.*') ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100 border border-transparent' }}">
                    <i data-lucide="utensils-crosskey" class="w-5 h-5 transition-transform group-hover:scale-105"></i>
                    <span>Restaurant Menu</span>
                </a>

                <a href="{{ route('admin.orders.index') }}" 
                   class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all font-medium text-sm group {{ request()->routeIs('admin.orders.*') ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100 border border-transparent' }}">
                    <i data-lucide="shopping-bag" class="w-5 h-5 transition-transform group-hover:scale-105"></i>
                    <span>Food Orders</span>
                </a>

                <div class="h-px bg-slate-900/60 my-6"></div>
                <span class="block text-[10px] font-bold text-slate-600 uppercase tracking-widest px-3 mb-2">Intelligence</span>

                <a href="{{ route('admin.reports.index') }}" 
                   class="flex items-center gap-3.5 px-4 py-3 rounded-xl transition-all font-medium text-sm group {{ request()->routeIs('admin.reports.*') ? 'bg-amber-500/10 text-amber-400 border border-amber-500/20' : 'text-slate-400 hover:bg-slate-900 hover:text-slate-100 border border-transparent' }}">
                    <i data-lucide="file-bar-chart" class="w-5 h-5 transition-transform group-hover:scale-105"></i>
                    <span>Reports & Export</span>
                </a>
            </nav>
        </div>

        <!-- Sidebar Footer / Logout -->
        <div class="pt-6 border-t border-slate-900 flex flex-col gap-4">
            <div class="flex items-center gap-3 px-3">
                <div class="w-10 h-10 rounded-full bg-slate-800 text-white flex items-center justify-center font-bold text-sm shrink-0 border border-slate-700">
                    {{ strtoupper(substr(session('admin_name', 'A'), 0, 2)) }}
                </div>
                <div class="overflow-hidden">
                    <span class="block font-semibold text-white text-sm truncate">{{ session('admin_name', 'Admin User') }}</span>
                    <span class="block text-xs text-slate-500 truncate">{{ session('admin_email', 'admin@luxury.com') }}</span>
                </div>
            </div>
            
            <a href="{{ route('admin.logout') }}" 
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-xl border border-slate-800 hover:bg-rose-500/10 hover:text-rose-400 hover:border-rose-500/25 transition-all text-xs font-semibold">
                <i data-lucide="log-out" class="w-4 h-4"></i>
                <span>Logout Session</span>
            </a>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" class="hidden">
                @csrf
            </form>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col min-w-0 max-h-screen overflow-y-auto relative">
        
        <!-- Header -->
        <header class="h-20 bg-white border-b border-slate-200/80 px-6 lg:px-8 flex items-center justify-between shrink-0 sticky top-0 z-30">
            <!-- Breadcrumbs -->
            <div class="flex items-center gap-2 pl-12 lg:pl-0">
                <span class="text-sm font-semibold text-slate-800 capitalize">@yield('page_title', 'Overview')</span>
            </div>

            <!-- Date / Controls -->
            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-2 bg-slate-50 border border-slate-100 rounded-xl px-3 py-1.5 text-xs text-slate-500 font-medium">
                    <i data-lucide="calendar" class="w-4 h-4 text-slate-400"></i>
                    <span>{{ now()->format('l, M d, Y') }}</span>
                </div>
                
                <a href="{{ route('admin.dashboard') }}" class="p-2.5 hover:bg-slate-100 rounded-xl text-slate-600 transition-colors hidden sm:block" title="Refresh Dashboard">
                    <i data-lucide="refresh-cw" class="w-5 h-5"></i>
                </a>
            </div>
        </header>

        <!-- Dynamic Content Body -->
        <main class="flex-grow p-6 lg:p-8 space-y-6 max-w-7xl w-full mx-auto">
            
            <!-- Success/Error Banner -->
            @if(session('success'))
                <div id="alert-success" class="flex items-center justify-between bg-emerald-50 border border-emerald-200/80 text-emerald-800 rounded-2xl p-4 text-sm shadow-sm relative overflow-hidden transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-emerald-500 text-white flex items-center justify-center shrink-0 shadow-sm">
                            <i data-lucide="check" class="w-4 h-4"></i>
                        </div>
                        <span class="font-medium">{{ session('success') }}</span>
                    </div>
                    <button onclick="document.getElementById('alert-success').remove()" class="text-emerald-500 hover:text-emerald-800 transition-colors p-1.5 rounded-lg cursor-pointer">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div id="alert-error" class="flex items-center justify-between bg-rose-50 border border-rose-200/80 text-rose-800 rounded-2xl p-4 text-sm shadow-sm relative overflow-hidden transition-all duration-300">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-rose-500 text-white flex items-center justify-center shrink-0 shadow-sm">
                            <i data-lucide="alert-triangle" class="w-4 h-4"></i>
                        </div>
                        <span class="font-medium">{{ session('error') }}</span>
                    </div>
                    <button onclick="document.getElementById('alert-error').remove()" class="text-rose-500 hover:text-rose-800 transition-colors p-1.5 rounded-lg cursor-pointer">
                        <i data-lucide="x" class="w-4 h-4"></i>
                    </button>
                </div>
            @endif

            @yield('content')
            
        </main>
    </div>

    <!-- Backdrop for mobile menu -->
    <div id="backdrop" class="fixed inset-0 bg-slate-900/40 backdrop-blur-xs z-30 hidden transition-opacity duration-300"></div>

    <script>
        // Init Lucide
        lucide.createIcons();

        // Responsive Sidebar Drawer
        const sidebar = document.getElementById('sidebar');
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const backdrop = document.getElementById('backdrop');
        const menuIcon = document.getElementById('menuIcon');

        let isSidebarOpen = false;

        function toggleSidebar() {
            isSidebarOpen = !isSidebarOpen;
            if (isSidebarOpen) {
                sidebar.classList.remove('-translate-x-full');
                backdrop.classList.remove('hidden');
                menuIcon.setAttribute('data-lucide', 'x');
            } else {
                sidebar.classList.add('-translate-x-full');
                backdrop.classList.add('hidden');
                menuIcon.setAttribute('data-lucide', 'menu');
            }
            lucide.createIcons();
        }

        mobileMenuBtn.addEventListener('click', toggleSidebar);
        backdrop.addEventListener('click', toggleSidebar);
    </script>
    @yield('scripts')
</body>
</html>
