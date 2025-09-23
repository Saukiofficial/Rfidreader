<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Panel - Absensi Sekolah</title>

    <!-- Menggunakan Tailwind Play CDN untuk mendukung kelas dinamis -->
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>

    <!-- AlpineJS for interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        [x-cloak] { display: none !important; }

        /* Custom gradient background */
        .sidebar-gradient {
            background: linear-gradient(135deg, #1e293b 0%, #334155 50%, #475569 100%);
            box-shadow:
                0 25px 50px -12px rgba(0, 0, 0, 0.25),
                0 0 0 1px rgba(255, 255, 255, 0.05);
        }

        /* Glassmorphism effect for menu items */
        .glass-menu-item {
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .glass-menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            transform: translateX(4px);
            box-shadow: 0 8px 25px -8px rgba(0, 0, 0, 0.3);
        }

        .glass-menu-item.active {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.3), rgba(147, 51, 234, 0.3));
            border: 1px solid rgba(59, 130, 246, 0.5);
            box-shadow:
                0 8px 25px -8px rgba(59, 130, 246, 0.4),
                inset 0 1px 0 rgba(255, 255, 255, 0.2);
        }

        /* Animated logo */
        .logo-animation {
            animation: logoGlow 3s ease-in-out infinite alternate;
        }

        @keyframes logoGlow {
            from {
                text-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
            }
            to {
                text-shadow: 0 0 30px rgba(147, 51, 234, 0.8), 0 0 40px rgba(59, 130, 246, 0.3);
            }
        }

        /* Menu icon hover effect */
        .menu-icon {
            transition: all 0.3s ease;
        }

        .glass-menu-item:hover .menu-icon {
            transform: scale(1.1);
            filter: drop-shadow(0 0 8px rgba(255, 255, 255, 0.3));
        }

        /* Scrollbar styling */
        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 2px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 2px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }

        /* Sidebar divider */
        .sidebar-divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            margin: 1rem 0;
        }

        /* Header user dropdown */
        .user-dropdown {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 0, 0, 0.1);
            box-shadow:
                0 20px 25px -5px rgba(0, 0, 0, 0.1),
                0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Mobile hamburger animation */
        .hamburger-line {
            transition: all 0.3s ease;
        }

        /* Mobile overlay */
        .mobile-overlay {
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        /* Responsive adjustments */
        @media (max-width: 1023px) {
            .sidebar-mobile {
                transform: translateX(-100%);
            }

            .sidebar-mobile.open {
                transform: translateX(0);
            }
        }

        @media (min-width: 1024px) {
            .sidebar-desktop {
                width: 256px;
                position: relative;
                transform: translateX(0) !important;
            }

            .sidebar-desktop.collapsed {
                width: 80px;
            }

            .sidebar-desktop.collapsed .menu-text {
                opacity: 0;
                transform: translateX(-10px);
            }

            .sidebar-desktop.collapsed .logo-text {
                opacity: 0;
                transform: scale(0.8);
            }
        }

        /* Smooth transitions */
        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .menu-text {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }

        .logo-text {
            transition: opacity 0.3s ease, transform 0.3s ease;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="flex h-screen bg-gray-200"
         x-data="{
             sidebarOpen: window.innerWidth >= 1024,
             sidebarCollapsed: false,
             isMobile: window.innerWidth < 1024
         }"
         x-init="
             $watch('sidebarOpen', value => {
                 if (!isMobile && !value) {
                     sidebarCollapsed = true;
                 } else if (!isMobile && value) {
                     sidebarCollapsed = false;
                 }
             });

             window.addEventListener('resize', () => {
                 isMobile = window.innerWidth < 1024;
                 if (!isMobile) {
                     sidebarOpen = true;
                 }
             });
         ">

        <!-- Mobile Overlay -->
        <div x-show="sidebarOpen && isMobile"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="sidebarOpen = false"
             class="fixed inset-0 z-20 mobile-overlay lg:hidden"
             x-cloak></div>

        <!-- Sidebar -->
        <aside
            class="sidebar-gradient text-white flex-shrink-0 flex flex-col sidebar-transition z-30"
            :class="{
                // Mobile classes
                'fixed inset-y-0 left-0 w-64 sidebar-mobile': isMobile,
                'sidebar-mobile open': isMobile && sidebarOpen,

                // Desktop classes
                'sidebar-desktop': !isMobile,
                'collapsed': !isMobile && sidebarCollapsed,
            }"
        >
            <!-- Logo Section -->
            <div class="h-24 flex items-center justify-center border-b border-white/10 px-4">
                <div class="transition-all duration-300 flex flex-col items-center logo-text"
                     :class="{'opacity-100': !sidebarCollapsed || isMobile, 'opacity-0 scale-75': sidebarCollapsed && !isMobile}">
                    <!-- School Logo -->
                    <div class="w-12 h-12 mb-2 rounded-full bg-white/10 p-2 backdrop-blur-sm border border-white/20 flex-shrink-0">
                        <img src="{{ asset('images/logo-smk-mahardhika.png') }}"
                             alt="Logo SMK Mahardhika"
                             class="w-full h-full object-contain rounded-full"
                             onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <!-- Fallback icon jika logo tidak ditemukan -->
                        <div class="w-full h-full bg-gradient-to-r from-blue-400 to-purple-400 rounded-full flex items-center justify-center text-white font-bold text-lg hidden">
                            M
                        </div>
                    </div>

                    <h1 class="text-lg font-bold logo-animation bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent text-center"
                        x-show="!sidebarCollapsed || isMobile">
                        AbsenSI
                    </h1>
                    <p class="text-xs text-blue-200 text-center font-medium"
                       x-show="!sidebarCollapsed || isMobile">SMK Mahardhika</p>
                </div>
            </div>

            <!-- Toggle Button for Desktop -->
            <div class="hidden lg:flex justify-end px-2 py-2 border-b border-white/10">
                <button @click="sidebarCollapsed = !sidebarCollapsed"
                        class="p-2 rounded-lg hover:bg-white/10 transition-colors duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200"
                         :class="{'rotate-180': sidebarCollapsed}"
                         fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
                    </svg>
                </button>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 px-4 py-6 space-y-3 overflow-y-auto custom-scrollbar">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}" class="glass-menu-item flex items-center px-4 py-3 rounded-xl group {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}"
                   :class="{'justify-center': sidebarCollapsed && !isMobile}">
                    <div class="menu-icon flex items-center justify-center w-8 h-8 flex-shrink-0"
                         :class="{'mr-3': !sidebarCollapsed || isMobile}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" />
                        </svg>
                    </div>
                    <div class="menu-text transition-all duration-300"
                         :class="{'opacity-100': !sidebarCollapsed || isMobile, 'opacity-0': sidebarCollapsed && !isMobile}"
                         x-show="!sidebarCollapsed || isMobile">
                        <span class="font-medium">Dashboard</span>
                        <p class="text-xs text-blue-200 mt-0.5">Ringkasan data</p>
                    </div>
                </a>

                <div class="sidebar-divider" x-show="!sidebarCollapsed || isMobile"></div>

                <!-- Data Siswa -->
                <a href="{{ route('admin.students.index') }}" class="glass-menu-item flex items-center px-4 py-3 rounded-xl group {{ request()->routeIs('admin.students.*') ? 'active' : '' }}"
                   :class="{'justify-center': sidebarCollapsed && !isMobile}">
                    <div class="menu-icon flex items-center justify-center w-8 h-8 flex-shrink-0"
                         :class="{'mr-3': !sidebarCollapsed || isMobile}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="menu-text transition-all duration-300"
                         :class="{'opacity-100': !sidebarCollapsed || isMobile, 'opacity-0': sidebarCollapsed && !isMobile}"
                         x-show="!sidebarCollapsed || isMobile">
                        <span class="font-medium">Data Siswa</span>
                        <p class="text-xs text-blue-200 mt-0.5">Kelola siswa</p>
                    </div>
                </a>

                <!-- Data Wali Murid -->
                <a href="{{ route('admin.guardians.index') }}" class="glass-menu-item flex items-center px-4 py-3 rounded-xl group {{ request()->routeIs('admin.guardians.*') ? 'active' : '' }}"
                   :class="{'justify-center': sidebarCollapsed && !isMobile}">
                    <div class="menu-icon flex items-center justify-center w-8 h-8 flex-shrink-0"
                         :class="{'mr-3': !sidebarCollapsed || isMobile}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zm-2 5a5 5 0 00-4.545 2.918A9.953 9.953 0 006 17a9.953 9.953 0 004.545-2.082A5 5 0 007 11zm11-3a3 3 0 11-6 0 3 3 0 016 0zm-2 5a5 5 0 00-4.545 2.918A9.953 9.953 0 0014 17a9.953 9.953 0 004.545-2.082A5 5 0 0016 11z" />
                        </svg>
                    </div>
                    <div class="menu-text transition-all duration-300"
                         :class="{'opacity-100': !sidebarCollapsed || isMobile, 'opacity-0': sidebarCollapsed && !isMobile}"
                         x-show="!sidebarCollapsed || isMobile">
                        <span class="font-medium">Wali Murid</span>
                        <p class="text-xs text-blue-200 mt-0.5">Data orang tua</p>
                    </div>
                </a>

                <div class="sidebar-divider" x-show="!sidebarCollapsed || isMobile"></div>

                <!-- Rekap Absensi -->
                <a href="{{ route('admin.attendances.index') }}" class="glass-menu-item flex items-center px-4 py-3 rounded-xl group {{ request()->routeIs('admin.attendances.*') ? 'active' : '' }}"
                   :class="{'justify-center': sidebarCollapsed && !isMobile}">
                    <div class="menu-icon flex items-center justify-center w-8 h-8 flex-shrink-0"
                         :class="{'mr-3': !sidebarCollapsed || isMobile}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="menu-text transition-all duration-300"
                         :class="{'opacity-100': !sidebarCollapsed || isMobile, 'opacity-0': sidebarCollapsed && !isMobile}"
                         x-show="!sidebarCollapsed || isMobile">
                        <span class="font-medium">Rekap Absensi</span>
                        <p class="text-xs text-blue-200 mt-0.5">Laporan kehadiran</p>
                    </div>
                </a>

                <!-- Simulasi Absensi -->
                <a href="{{ route('admin.simulation.index') }}" class="glass-menu-item flex items-center px-4 py-3 rounded-xl group {{ request()->routeIs('admin.simulation.*') ? 'active' : '' }}"
                   :class="{'justify-center': sidebarCollapsed && !isMobile}">
                    <div class="menu-icon flex items-center justify-center w-8 h-8 flex-shrink-0"
                         :class="{'mr-3': !sidebarCollapsed || isMobile}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="menu-text transition-all duration-300"
                         :class="{'opacity-100': !sidebarCollapsed || isMobile, 'opacity-0': sidebarCollapsed && !isMobile}"
                         x-show="!sidebarCollapsed || isMobile">
                        <span class="font-medium">Simulasi</span>
                        <p class="text-xs text-blue-200 mt-0.5">Test absensi</p>
                    </div>
                </a>
            </nav>

            <!-- Footer -->
            <div class="px-4 py-4 border-t border-white/10">
                <div class="transition-all duration-300"
                     :class="{'opacity-100': !sidebarCollapsed || isMobile, 'opacity-0': sidebarCollapsed && !isMobile}"
                     x-show="!sidebarCollapsed || isMobile">
                    <p class="text-xs text-blue-200 text-center">
                        © 2025 Sistem Absensi SMK Mahardhika
                    </p>
                    <div class="flex justify-center space-x-2 mt-2">
                        <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                        <span class="text-xs text-green-300">Online</span>
                    </div>
                </div>
                <!-- Collapsed footer icon -->
                <div class="flex justify-center"
                     x-show="sidebarCollapsed && !isMobile">
                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="flex justify-between items-center p-6 bg-white/80 backdrop-filter backdrop-blur-lg border-b border-gray-200/50 shadow-sm">
                <div class="flex items-center space-x-4">
                    <button @click="sidebarOpen = !sidebarOpen"
                            class="text-gray-600 hover:text-gray-900 focus:outline-none lg:hidden transition-colors duration-200">
                        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path class="hamburger-line" d="M4 6H20M4 12H20M4 18H11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-700 to-gray-900 bg-clip-text text-transparent hidden lg:block">@yield('header', 'Dashboard')</h1>
                </div>

                <div x-data="{ dropdownOpen: false }" class="relative">
                    <button @click="dropdownOpen = !dropdownOpen" class="flex items-center space-x-3 p-2 rounded-xl hover:bg-gray-100 transition-colors duration-200 group">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-500 to-purple-600 flex items-center justify-center text-white font-semibold shadow-lg group-hover:shadow-xl transition-shadow duration-200">
                            {{ substr(Auth::user()->name ?? 'Admin', 0, 1) }}
                        </div>
                        <div class="hidden md:block text-left">
                            <p class="text-sm font-semibold text-gray-700">{{ Auth::user()->name ?? 'Administrator' }}</p>
                            <p class="text-xs text-gray-500">Administrator</p>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400 group-hover:text-gray-600 transition-colors duration-200" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div x-show="dropdownOpen"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95"
                         @click.away="dropdownOpen = false"
                         class="absolute right-0 mt-2 w-56 user-dropdown rounded-xl shadow-2xl z-20 overflow-hidden"
                         x-cloak>

                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->name ?? 'Administrator' }}</p>
                            <p class="text-xs text-gray-500">{{ Auth::user()->email ?? 'admin@school.com' }}</p>
                        </div>

                        <div class="py-2">
                            <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                </svg>
                                Profil Saya
                            </a>
                            <a href="#" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd" />
                                </svg>
                                Pengaturan
                            </a>
                            <div class="border-t border-gray-100 my-1"></div>
                            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="flex items-center px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-3" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z" clip-rule="evenodd" />
                                </svg>
                                Logout
                            </a>
                        </div>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </div>
                </div>
            </header>

            <!-- Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gradient-to-br from-gray-50 to-gray-100">
                <div class="container mx-auto px-6 py-8">
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-gray-700 to-gray-900 bg-clip-text text-transparent block lg:hidden mb-6">@yield('header', 'Dashboard')</h1>
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>
