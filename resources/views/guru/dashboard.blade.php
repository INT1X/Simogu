
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Guru - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Font Awesome --}}
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
    >
</head>

<body class="bg-slate-100">
    <div class="min-h-screen">

        {{-- SIDEBAR --}}
        @include('components.guru-sidebar')

        {{-- CONTENT --}}
        <div class="lg:ml-72 min-h-screen">

            {{-- TOPBAR --}}
            <header class="sticky top-0 z-30 bg-white border-b border-slate-200 shadow-sm">
                <div class="h-20 px-4 sm:px-6 lg:px-8 flex items-center justify-between">

                    <div class="flex items-center gap-4">

                        {{-- HAMBURGER --}}
                        <button
                            id="guruSidebarToggle"
                            type="button"
                            aria-label="Buka menu navigasi"
                            aria-controls="guru-sidebar"
                            aria-expanded="false"
                            class="lg:hidden w-11 h-11 rounded-xl bg-slate-100 hover:bg-slate-200 flex items-center justify-center text-slate-700"
                        >
                            <i class="fa-solid fa-bars text-lg"></i>
                        </button>

                        <div>
                            <h2 class="text-xl sm:text-2xl font-bold text-slate-800">
                                Dashboard Guru
                            </h2>

                            <p class="text-sm text-slate-500 hidden sm:block">
                                Monitoring aktivitas dan kinerja Anda
                            </p>
                        </div>
                    </div>

                    {{-- PROFILE TOPBAR --}}
                    @php
                        $currentUser = auth()->user();
                        $teacherName = $teacher->name
                            ?? $currentUser?->name
                            ?? 'Guru';
                    @endphp

                    <div class="flex items-center gap-3">

                        @if(!empty($teacher?->photo))
                            <img
                                src="{{ asset('storage/' . $teacher->photo) }}"
                                class="w-10 h-10 rounded-full object-cover border-2 border-blue-500"
                                alt="Foto profil {{ $teacherName }}"
                            >
                        @else
                            <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold">
                                {{ strtoupper(substr($teacherName, 0, 1)) }}
                            </div>
                        @endif

                        <div class="hidden md:block">
                            <p class="text-sm font-semibold text-slate-800">
                                {{ $teacherName }}
                            </p>

                            <p class="text-xs text-slate-500">
                                Guru
                            </p>
                        </div>
                    </div>
                </div>
            </header>

            {{-- MAIN --}}
            <main class="p-4 sm:p-6 lg:p-8">

                {{-- FLASH MESSAGE --}}
                @if(session('success'))
                    <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                        <i class="fa-solid fa-circle-check mr-2"></i>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <i class="fa-solid fa-circle-exclamation mr-2"></i>
                        {{ session('error') }}
                    </div>
                @endif

                {{-- WELCOME --}}
                <section class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-lg p-6 sm:p-8 text-white mb-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                        <div>
                            <p class="text-blue-100 text-sm mb-1">
                                Selamat datang kembali,
                            </p>

                            <h1 class="text-2xl sm:text-3xl font-bold">
                                {{ $teacherName }}
                            </h1>

                            <p class="mt-3 text-blue-100 max-w-2xl">
                                Kelola dokumen, pantau kinerja, dan lihat
                                hasil penilaian Anda melalui dashboard SIMOGU.
                            </p>
                        </div>

                        <div class="hidden lg:flex w-24 h-24 rounded-2xl bg-white/10 items-center justify-center">
                            <i class="fa-solid fa-user-tie text-5xl"></i>
                        </div>
                    </div>
                </section>

                {{-- STATISTIK --}}
                <section class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5 mb-6">

                    {{-- DOKUMEN SAYA --}}
                    <a
                        href="{{ route('guru.documents.index') }}"
                        class="block bg-white rounded-2xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-500">
                                    Dokumen Saya
                                </p>

                                <h3 class="text-3xl font-bold text-slate-800 mt-2">
                                    {{ $documentCount ?? 0 }}
                                </h3>
                            </div>

                            <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-600 flex items-center justify-center">
                                <i class="fa-solid fa-folder-open text-xl"></i>
                            </div>
                        </div>
                    </a>

                    {{-- DOKUMEN TERVERIFIKASI --}}
                    <a
                        href="{{ route('guru.documents.index', ['status' => 'verified']) }}"
                        class="block bg-white rounded-2xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-500">
                                    Terverifikasi
                                </p>

                                <h3 class="text-3xl font-bold text-slate-800 mt-2">
                                    {{ $verifiedDocumentCount ?? 0 }}
                                </h3>
                            </div>

                            <div class="w-12 h-12 rounded-xl bg-green-100 text-green-600 flex items-center justify-center">
                                <i class="fa-solid fa-circle-check text-xl"></i>
                            </div>
                        </div>
                    </a>

                    {{-- PENILAIAN --}}
                    <a
                        href="{{ route('guru.assessment') }}"
                        class="block bg-white rounded-2xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-500">
                                    Penilaian
                                </p>

                                <h3 class="text-3xl font-bold text-slate-800 mt-2">
                                    -
                                </h3>

                                <p class="text-xs text-slate-400 mt-1">
                                    Lihat hasil penilaian
                                </p>
                            </div>

                            <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center">
                                <i class="fa-solid fa-chart-line text-xl"></i>
                            </div>
                        </div>
                    </a>

                    {{-- STATUS --}}
                    <a
                        href="{{ route('guru.profile') }}"
                        class="block bg-white rounded-2xl border border-slate-200 shadow-sm p-5 hover:shadow-md transition"
                    >
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-slate-500">
                                    Status
                                </p>

                                <h3 class="text-lg font-bold text-green-600 mt-2">
                                    Aktif
                                </h3>

                                <p class="text-xs text-slate-400 mt-1">
                                    Lihat profil guru
                                </p>
                            </div>

                            <div class="w-12 h-12 rounded-xl bg-green-100 text-green-600 flex items-center justify-center">
                                <i class="fa-solid fa-user-check text-xl"></i>
                            </div>
                        </div>
                    </a>

                </section>

                {{-- MENU CEPAT --}}
                <section>
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-xl font-bold text-slate-800">
                                Akses Cepat
                            </h2>

                            <p class="text-sm text-slate-500">
                                Akses fitur utama SIMOGU
                            </p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

                        {{-- DOKUMEN --}}
                        <a
                            href="{{ route('guru.documents.index') }}"
                            class="group bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md p-6 transition"
                        >
                            <div class="w-14 h-14 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center mb-5">
                                <i class="fa-solid fa-cloud-arrow-up text-2xl"></i>
                            </div>

                            <h3 class="text-lg font-bold text-slate-800 group-hover:text-blue-600">
                                Dokumen Saya
                            </h3>

                            <p class="text-sm text-slate-500 mt-2">
                                Upload dan kelola dokumen pendukung penilaian.
                            </p>
                        </a>

                        {{-- KINERJA --}}
                        <a
                            href="{{ route('guru.performance') }}"
                            class="group bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md p-6 transition"
                        >
                            <div class="w-14 h-14 rounded-2xl bg-purple-100 text-purple-600 flex items-center justify-center mb-5">
                                <i class="fa-solid fa-chart-column text-2xl"></i>
                            </div>

                            <h3 class="text-lg font-bold text-slate-800 group-hover:text-purple-600">
                                Kinerja Saya
                            </h3>

                            <p class="text-sm text-slate-500 mt-2">
                                Lihat informasi kinerja dan perkembangan Anda.
                            </p>
                        </a>

                        {{-- HASIL PENILAIAN --}}
                        <a
                            href="{{ route('guru.assessment') }}"
                            class="group bg-white rounded-2xl border border-slate-200 shadow-sm hover:shadow-md p-6 transition"
                        >
                            <div class="w-14 h-14 rounded-2xl bg-green-100 text-green-600 flex items-center justify-center mb-5">
                                <i class="fa-solid fa-square-poll-vertical text-2xl"></i>
                            </div>

                            <h3 class="text-lg font-bold text-slate-800 group-hover:text-green-600">
                                Hasil Penilaian
                            </h3>

                            <p class="text-sm text-slate-500 mt-2">
                                Lihat hasil penilaian yang telah dilakukan pengawas.
                            </p>
                        </a>

                    </div>
                </section>

            </main>
        </div>
    </div>

    {{-- SIDEBAR JAVASCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('guru-sidebar');
            const overlay = document.getElementById('guru-sidebar-overlay');
            const toggle = document.getElementById('guruSidebarToggle');

            function openSidebar() {
                if (!sidebar || !overlay) return;

                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');

                toggle?.setAttribute('aria-expanded', 'true');
            }

            function closeSidebar() {
                if (!sidebar || !overlay) return;

                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');

                toggle?.setAttribute('aria-expanded', 'false');
            }

            toggle?.addEventListener('click', function () {
                if (!sidebar) return;

                if (sidebar.classList.contains('-translate-x-full')) {
                    openSidebar();
                } else {
                    closeSidebar();
                }
            });

            overlay?.addEventListener('click', closeSidebar);

            document.addEventListener('keydown', function (event) {
                if (event.key === 'Escape') {
                    closeSidebar();
                }
            });
        });
    </script>
</body>
</html>
