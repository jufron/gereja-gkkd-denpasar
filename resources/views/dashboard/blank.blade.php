<!DOCTYPE html>
<html lang="id" class="h-full bg-slate-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>GKKD Bali - Church Dashboard</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50: '#fbf3ff',
                            100: '#f6e5ff',
                            200: '#edd0ff',
                            500: '#b833ee',
                            600: '#8a00c2', // Primary Brand Purple (10% Accent)
                            700: '#7500a8',
                            800: '#61028a',
                            900: '#4e066e',
                        },
                        darkbase: '#121212' // 30% Structural Dark
                    }
                }
            }
        }
    </script>
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- Alpine.js CDN -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body {
            font-family: 'Inter', sans-serif;
            -webkit-tap-highlight-color: transparent;
        }
        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 5px;
            height: 5px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }
        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 9999px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>
<body class="m-0 p-0 w-full min-h-screen bg-slate-100 text-slate-800 antialiased overflow-x-hidden" x-data="{ sidebarOpen: false }">

    <!-- MOBILE SIDEBAR BACKDROP OVERLAY -->
    <div 
        x-show="sidebarOpen" 
        x-transition:enter="transition-opacity ease-linear duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="transition-opacity ease-linear duration-300"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        @click="sidebarOpen = false" 
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-40 lg:hidden"
        style="display: none;"
    ></div>

    <div class="min-h-screen flex w-full relative">

        <!-- ========================================== -->
        <!-- COMPONENT 1: SIDEBAR NAVIGATION            -->
        <!-- ========================================== -->
        <aside 
            class="fixed inset-y-0 left-0 z-50 w-64 bg-darkbase text-white flex flex-col justify-between shadow-2xl transition-transform duration-300 ease-in-out lg:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        >
            <!-- Logo & Church Header -->
            <div>
                <div class="h-20 px-6 flex items-center justify-between border-b border-slate-800/80">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-brand-700 to-brand-500 flex items-center justify-center text-white shadow-lg shadow-brand-600/30">
                            <i class="fa-solid fa-church text-lg"></i>
                        </div>
                        <div>
                            <h1 class="font-bold text-base tracking-wide text-white leading-tight">GKKD BALI</h1>
                            <span class="text-[10px] text-brand-200 font-semibold tracking-wider uppercase">Church Dashboard</span>
                        </div>
                    </div>
                    <button @click="sidebarOpen = false" class="lg:hidden text-slate-400 hover:text-white p-2 rounded-lg focus:outline-none">
                        <i class="fa-solid fa-xmark text-xl"></i>
                    </button>
                </div>

                <!-- Navigation Links -->
                <nav class="p-4 space-y-1.5 overflow-y-auto max-h-[calc(100vh-160px)]">
                    <div class="px-3 pt-2 pb-1 text-[11px] font-semibold tracking-wider text-slate-500 uppercase">Ringkasan</div>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl bg-brand-600 text-white font-medium shadow-md shadow-brand-600/20 transition-all">
                        <i class="fa-solid fa-chart-pie w-5 text-center"></i>
                        <span class="text-sm">Dashboard</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 font-medium transition-all">
                        <i class="fa-solid fa-users w-5 text-center"></i>
                        <span class="text-sm">Data Jemaat</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 font-medium transition-all">
                        <i class="fa-solid fa-hand-holding-heart w-5 text-center"></i>
                        <span class="text-sm">Pelayanan & Volunteer</span>
                    </a>

                    <div class="px-3 pt-4 pb-1 text-[11px] font-semibold tracking-wider text-slate-500 uppercase">Ibadah & Agenda</div>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 font-medium transition-all">
                        <i class="fa-solid fa-calendar-days w-5 text-center"></i>
                        <span class="text-sm">Jadwal Ibadah</span>
                    </a>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 font-medium transition-all">
                        <i class="fa-solid fa-coins w-5 text-center"></i>
                        <span class="text-sm">Keuangan & Persembahan</span>
                    </a>

                    <div class="px-3 pt-4 pb-1 text-[11px] font-semibold tracking-wider text-slate-500 uppercase">Sistem</div>
                    <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-slate-400 hover:bg-slate-800/60 hover:text-slate-200 font-medium transition-all">
                        <i class="fa-solid fa-sliders w-5 text-center"></i>
                        <span class="text-sm">Pengaturan</span>
                    </a>
                </nav>
            </div>

            <!-- Sidebar Footer User Card -->
            <div class="p-4 border-t border-slate-800/80 bg-slate-900/40">
                <div class="flex items-center gap-3">
                    <img class="w-9 h-9 rounded-full object-cover border border-brand-500/40" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=150" alt="Admin Avatar">
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-semibold text-slate-200 truncate">Pdt. Stephen</p>
                        <p class="text-[11px] text-slate-400 truncate">Gembala Sidang</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- ========================================== -->
        <!-- MAIN CONTENT AREA                          -->
        <!-- ========================================== -->
        <div class="flex-1 w-full min-w-0 min-h-screen lg:pl-64 flex flex-col overflow-x-hidden">

            <!-- ========================================== -->
            <!-- COMPONENT 2: TOP HEADER NAVBAR             -->
            <!-- ========================================== -->
            <header class="sticky top-0 z-30 h-20 bg-white/90 backdrop-blur-md border-b border-slate-200/80 px-4 sm:px-6 lg:px-8 flex items-center justify-between gap-4">
                
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = true" class="lg:hidden p-2.5 text-slate-600 hover:text-slate-900 hover:bg-slate-100 rounded-xl focus:outline-none transition-colors">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <div>
                        <h2 class="text-xl font-bold text-slate-800 tracking-tight">Dashboard Overview</h2>
                        <p class="text-xs text-slate-500 hidden sm:block">Ringkasan aktivitas dan pelayanan GKKD Bali</p>
                    </div>
                </div>

                <div class="flex items-center gap-2 sm:gap-4">
                    
                    <!-- Search Bar -->
                    <div class="relative hidden md:block w-64">
                        <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                        <input type="text" placeholder="Cari jemaat, warta, kegiatan..." class="w-full pl-9 pr-4 py-2 bg-slate-100 border border-transparent rounded-xl text-xs text-slate-700 placeholder-slate-400 focus:outline-none focus:bg-white focus:border-brand-500 transition-all">
                    </div>

                    <!-- Notification Dropdown Window -->
                    <div class="relative" x-data="{ openNotif: false }">
                        <button @click="openNotif = !openNotif" @click.outside="openNotif = false" class="relative p-2.5 text-slate-600 hover:text-brand-600 hover:bg-brand-50 rounded-xl transition-all focus:outline-none">
                            <i class="fa-regular fa-bell text-lg"></i>
                            <span class="absolute top-2 right-2 w-2 h-2 rounded-full bg-brand-600 ring-2 ring-white"></span>
                        </button>

                        <div 
                            x-show="openNotif" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                            class="absolute right-0 mt-2 w-80 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50"
                            style="display: none;"
                        >
                            <div class="px-4 py-2 border-b border-slate-100 flex items-center justify-between">
                                <span class="text-xs font-bold text-slate-800">Notifikasi Pelayanan</span>
                                <span class="text-[10px] bg-brand-100 text-brand-700 font-semibold px-2 py-0.5 rounded-full">3 Baru</span>
                            </div>
                            <div class="divide-y divide-slate-50 max-h-64 overflow-y-auto">
                                <a href="#" class="px-4 py-3 hover:bg-slate-50 flex gap-3 transition-colors block">
                                    <div class="w-8 h-8 rounded-full bg-brand-100 text-brand-600 flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-user-plus text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-700 font-medium">Jemaat Baru Terdaftar</p>
                                        <p class="text-[11px] text-slate-400">Bpk. Kevin mendaftar melalui website.</p>
                                        <span class="text-[10px] text-slate-400 mt-1 block">10 menit yang lalu</span>
                                    </div>
                                </a>
                                <a href="#" class="px-4 py-3 hover:bg-slate-50 flex gap-3 transition-colors block">
                                    <div class="w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 flex items-center justify-center shrink-0">
                                        <i class="fa-solid fa-hand-holding-dollar text-xs"></i>
                                    </div>
                                    <div>
                                        <p class="text-xs text-slate-700 font-medium">Persembahan QRIS Masuk</p>
                                        <p class="text-[11px] text-slate-400">Konfirmasi persembahan Ibadah Raya 1.</p>
                                        <span class="text-[10px] text-slate-400 mt-1 block">1 jam yang lalu</span>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Profile Dropdown Window -->
                    <div class="relative" x-data="{ openProfile: false }">
                        <button @click="openProfile = !openProfile" @click.outside="openProfile = false" class="flex items-center gap-3 pl-2 pr-1 py-1 rounded-xl hover:bg-slate-100 transition-colors focus:outline-none">
                            <img class="w-9 h-9 rounded-full object-cover ring-2 ring-brand-600/20" src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&q=80&w=150" alt="User Profile">
                            <i class="fa-solid fa-chevron-down text-slate-400 text-xs hidden sm:block"></i>
                        </button>

                        <div 
                            x-show="openProfile" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95 -translate-y-2"
                            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                            x-transition:leave-end="opacity-0 scale-95 -translate-y-2"
                            class="absolute right-0 mt-2 w-56 bg-white rounded-2xl shadow-xl border border-slate-100 py-2 z-50"
                            style="display: none;"
                        >
                            <div class="px-4 py-2 border-b border-slate-100">
                                <p class="text-xs font-bold text-slate-800">Pdt. Stephen</p>
                                <p class="text-[11px] text-slate-400">stephen@gkkdbali.org</p>
                            </div>
                            <a href="#" class="px-4 py-2.5 text-xs text-slate-600 hover:bg-slate-50 hover:text-brand-600 flex items-center gap-2.5 transition-colors">
                                <i class="fa-solid fa-user-gear w-4 text-center"></i> Profil Saya
                            </a>
                            <a href="#" class="px-4 py-2.5 text-xs text-slate-600 hover:bg-slate-50 hover:text-brand-600 flex items-center gap-2.5 transition-colors">
                                <i class="fa-solid fa-shield-halved w-4 text-center"></i> Keamanan
                            </a>
                            <div class="border-t border-slate-100 my-1"></div>
                            <a href="#" class="px-4 py-2.5 text-xs text-rose-600 hover:bg-rose-50 flex items-center gap-2.5 transition-colors">
                                <i class="fa-solid fa-right-from-bracket w-4 text-center"></i> Keluar
                            </a>
                        </div>
                    </div>

                </div>
            </header>

            <!-- Dashboard Main Container -->
            <main class="flex-1 p-4 lg:p-8">
                
                <!-- ========================================== -->
                <!-- COMPONENT: BREADCRUMB & PAGE HEADER        -->
                <!-- ========================================== -->
                <div class="mb-6">
                    <nav class="flex text-xs text-gray-500 mb-2" aria-label="Breadcrumb">
                        <ol class="inline-flex items-center space-x-1 md:space-x-2">
                            <li class="inline-flex items-center">
                                <a href="#" class="hover:text-[#8A00C2] inline-flex items-center gap-1.5 transition-colors">
                                    <i data-feather="home" class="w-3.5 h-3.5"></i>
                                    Dashboard
                                </a>
                            </li>
                            <li>
                                <div class="flex items-center">
                                    <i data-feather="chevron-right" class="w-3.5 h-3.5 text-gray-400"></i>
                                    <span class="ml-1 md:ml-2 text-gray-800 font-medium">Halaman Baru</span>
                                </div>
                            </li>
                        </ol>
                    </nav>

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h1 class="text-xl lg:text-2xl font-bold text-gray-900 tracking-tight">Judul Halaman Baru</h1>
                            <p class="text-xs lg:text-sm text-gray-500 mt-1">Tambahkan deskripsi singkat atau petunjuk penggunaan halaman di sini.</p>
                        </div>
                        
                        <!-- Action Buttons Placeholder (Optional) -->
                        <div class="flex items-center gap-2.5">
                            <button class="inline-flex items-center gap-2 px-3.5 py-2 bg-white border border-gray-200 text-gray-700 text-xs font-semibold rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-colors shadow-sm">
                                <i data-feather="download" class="w-3.5 h-3.5"></i>
                                Export Data
                            </button>
                            <button class="inline-flex items-center gap-2 px-3.5 py-2 bg-[#8A00C2] text-white text-xs font-semibold rounded-lg hover:bg-[#6A0096] focus:outline-none focus:ring-2 focus:ring-[#8A00C2]/50 transition-colors shadow-sm shadow-[#8A00C2]/20">
                                <i data-feather="plus" class="w-3.5 h-3.5"></i>
                                Tambah Data
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ========================================== -->
                <!-- COMPONENT: BLANK CONTENT CONTAINER         -->
                <!-- ========================================== -->
                <div class="w-full bg-white rounded-2xl border border-gray-200 p-6 lg:p-12 shadow-sm min-h-[420px] flex flex-col items-center justify-center text-center">
                    
                    <!-- Dashed Placeholder Area -->
                    <div class="w-full h-full border-2 border-dashed border-gray-200 rounded-xl p-8 lg:p-12 flex flex-col items-center justify-center bg-gray-50/50">
                        <div class="w-16 h-16 rounded-2xl bg-purple-50 text-[#8A00C2] flex items-center justify-center mb-4 ring-8 ring-purple-50/50">
                            <i data-feather="layout" class="w-8 h-8"></i>
                        </div>
                        <h3 class="text-base font-semibold text-gray-800">Konten Kosong / Area Kerja</h3>
                        <p class="text-xs text-gray-500 max-w-md mt-1 mb-6">
                            Gunakan kontainer ini untuk meletakkan komponen UI baru seperti Tabel Data, Form Input, Statistik, atau Detail Laporan GKKD Bali.
                        </p>
                        <div class="flex items-center gap-3">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[11px] font-mono font-medium bg-gray-100 text-gray-600 border border-gray-200">
                                &lt;div class="content"&gt;...&lt;/div&gt;
                            </span>
                        </div>
                    </div>

                </div>

            </main>

            <!-- ========================================== -->
            <!-- COMPONENT 8: FOOTER                        -->
            <!-- ========================================== -->
            <footer class="mt-auto py-4 px-6 bg-white border-t border-slate-200/80 text-center text-xs text-slate-500">
                <p>&copy; 2026 Gereja Kerapatan Injil Kerajaan Allah (GKKD) Bali. All rights reserved.</p>
            </footer>

        </div>
    </div>

    <!-- Script Chart.js Initialization -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('attendanceChart').getContext('2d');
            
            // Brand Purple Linear Gradient Fill
            const gradient = ctx.createLinearGradient(0, 0, 0, 300);
            gradient.addColorStop(0, 'rgba(138, 0, 194, 0.35)');
            gradient.addColorStop(1, 'rgba(138, 0, 194, 0.0)');

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4 (Terakhir)'],
                    datasets: [{
                        label: 'Kehadiran Ibadah Raya',
                        data: [740, 810, 790, 892],
                        borderColor: '#8A00C2',
                        borderWidth: 3,
                        backgroundColor: gradient,
                        fill: true,
                        tension: 0.4,
                        pointBackgroundColor: '#8A00C2',
                        pointBorderColor: '#FFFFFF',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#121212',
                            titleFont: { family: 'Inter', size: 12, weight: 'bold' },
                            bodyFont: { family: 'Inter', size: 12 },
                            padding: 10,
                            cornerRadius: 8,
                            displayColors: false
                        }
                    },
                    scales: {
                        x: {
                            grid: { display: false },
                            ticks: { font: { family: 'Inter', size: 11 }, color: '#64748b' }
                        },
                        y: {
                            grid: { color: '#f1f5f9' },
                            ticks: { font: { family: 'Inter', size: 11 }, color: '#64748b' },
                            min: 500
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>