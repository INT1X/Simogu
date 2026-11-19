{{-- ============================================================= --}}
{{-- SIDEBAR ADMIN SIMOGU --}}
{{-- ============================================================= --}}

{{-- ============================================================= --}}
{{-- MOBILE OVERLAY --}}
{{-- ============================================================= --}}

<div id="sidebarOverlay" class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm z-40 hidden lg:hidden"
    onclick="closeSidebar()">
</div>


{{-- ============================================================= --}}
{{-- SIDEBAR --}}
{{-- ============================================================= --}}

<aside id="adminSidebar" class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-950 text-white
           transform -translate-x-full lg:translate-x-0
           transition-transform duration-300 ease-in-out
           flex flex-col shadow-2xl">


    {{-- ========================================================= --}}
    {{-- LOGO / HEADER SIDEBAR --}}
    {{-- ========================================================= --}}

    <div class="flex-shrink-0 p-5 border-b border-slate-800">

        <div class="flex items-center justify-between">

            <div class="flex items-center gap-3">

                {{-- Logo --}}
                <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600
                           flex items-center justify-center shadow-lg shadow-blue-500/20">

                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l9-5-9-5-9 5 9 5z" />

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l6.16-3.42A12.08 12.08 0 0118 16.5c-1.67 1.1-3.7 1.75-6 1.75s-4.33-.65-6-1.75c-.08-2.2.5-4.32 1.84-5.92L12 14z" />

                    </svg>

                </div>


                {{-- Nama --}}
                <div class="min-w-0">

                    <h1 class="text-xl font-bold tracking-wide">
                        SIMOGU
                    </h1>

                    <p class="text-xs text-slate-400 truncate">
                        Monitoring Kinerja Guru
                    </p>

                </div>

            </div>


            {{-- Close Mobile --}}
            <button type="button" onclick="closeSidebar()" class="lg:hidden w-9 h-9 rounded-xl text-slate-400
                       hover:bg-slate-800 hover:text-white transition
                       flex items-center justify-center">

                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />

                </svg>

            </button>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- MENU --}}
    {{-- ========================================================= --}}

    <nav class="flex-1 overflow-y-auto p-4 space-y-2 sidebar-scroll">


        {{-- ===================================================== --}}
        {{-- SECTION UTAMA --}}
        {{-- ===================================================== --}}

        <div class="px-3 pt-1 pb-2">

            <p class="text-[10px] font-bold uppercase tracking-[0.15em] text-slate-500">
                Menu Utama
            </p>

        </div>


        {{-- ===================================================== --}}
        {{-- DASHBOARD --}}
        {{-- ===================================================== --}}

        <a href="{{ route('admin.dashboard') }}" class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
            {{ request()->routeIs('admin.dashboard')
    ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20'
    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">

            <div class="w-9 h-9 rounded-lg flex items-center justify-center
                {{ request()->routeIs('admin.dashboard')
    ? 'bg-white/15'
    : 'bg-slate-800 group-hover:bg-slate-700' }}">

                <svg class="w-5 h-5 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-blue-400' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-4 0h4" />

                </svg>

            </div>

            <span class="font-medium">
                Dashboard
            </span>

        </a>


        {{-- ===================================================== --}}
        {{-- DATA GURU --}}
        {{-- ===================================================== --}}

        <a href="{{ route('admin.teachers.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
            {{ request()->routeIs('admin.teachers.*')
    ? 'bg-blue-600 text-white shadow-lg shadow-blue-600/20'
    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">

            <div class="w-9 h-9 rounded-lg flex items-center justify-center
                {{ request()->routeIs('admin.teachers.*')
    ? 'bg-white/15'
    : 'bg-slate-800 group-hover:bg-slate-700' }}">

                <svg class="w-5 h-5 {{ request()->routeIs('admin.teachers.*') ? 'text-white' : 'text-blue-400' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-4a4 4 0 100-8 4 4 0 000 8zm6 0a3 3 0 100-6 3 3 0 000 6z" />

                </svg>

            </div>

            <span class="font-medium">
                Data Guru
            </span>

        </a>


        {{-- ===================================================== --}}
        {{-- DATA SEKOLAH --}}
        {{-- ===================================================== --}}

        <a href="{{ route('admin.schools.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
            {{ request()->routeIs('admin.schools.*')
    ? 'bg-emerald-600 text-white shadow-lg shadow-emerald-600/20'
    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">

            <div class="w-9 h-9 rounded-lg flex items-center justify-center
                {{ request()->routeIs('admin.schools.*')
    ? 'bg-white/15'
    : 'bg-slate-800 group-hover:bg-slate-700' }}">

                <svg class="w-5 h-5 {{ request()->routeIs('admin.schools.*') ? 'text-white' : 'text-emerald-400' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-8h6v8" />

                </svg>

            </div>

            <span class="font-medium">
                Data Sekolah
            </span>

        </a>


        {{-- ===================================================== --}}
        {{-- DATA PENGAWAS --}}
        {{-- ===================================================== --}}

        <a href="{{ route('admin.supervisors.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
            {{ request()->routeIs('admin.supervisors.*')
    ? 'bg-purple-600 text-white shadow-lg shadow-purple-600/20'
    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">

            <div class="w-9 h-9 rounded-lg flex items-center justify-center
                        {{ request()->routeIs('admin.supervisors.*')
    ? 'bg-white/15'
    : 'bg-slate-800 group-hover:bg-slate-700' }}">

                <svg class="w-5 h-5 {{ request()->routeIs('admin.supervisors.*') ? 'text-white' : 'text-purple-400' }}"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />

                </svg>

            </div>

            <span class="font-medium">
                Data Pengawas
            </span>

        </a>

        {{-- ===================================================== --}}
        {{-- PELATIHAN MODEL ID3 --}}
        {{-- ===================================================== --}}

        <a href="{{ route('admin.id3.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
    {{ request()->routeIs('admin.id3.*')
    ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20'
    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">

            <div class="w-9 h-9 rounded-lg flex items-center justify-center
        {{ request()->routeIs('admin.id3.*')
    ? 'bg-white/15'
    : 'bg-slate-800 group-hover:bg-slate-700' }}">

                <svg class="w-5 h-5
            {{ request()->routeIs('admin.id3.*')
    ? 'text-white'
    : 'text-indigo-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 3v18m0-18l-7 4v8l7 4m0-16l7 4v8l-7 4M5 7l7 4 7-4M5 15l7-4 7 4" />

                </svg>

            </div>

            <span class="font-medium">
                Pelatihan Model ID3
            </span>

        </a>



        {{-- ===================================================== --}}
        {{-- PENILAIAN KINERJA --}}
        {{-- ===================================================== --}}
        {{--
        Menu lama performance-assessments dihapus dari sidebar.
        Sekarang Penilaian Kinerja menjadi parent menu.
        --}}

        @php
            $assessmentMenuActive =
                request()->routeIs('admin.assessments.*') ||
                request()->routeIs('admin.assessment-periods.*') ||
                request()->routeIs('admin.assessment-indicators.*') ||
                request()->routeIs('admin.assessment-weights.*') ||
                request()->routeIs('admin.document-types.*');
        @endphp


        {{-- ===================================================== --}}
        {{-- BUTTON PENILAIAN KINERJA --}}
        {{-- ===================================================== --}}

        <button type="button" onclick="toggleAssessmentMenu()" class="w-full group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
            {{ $assessmentMenuActive
    ? 'bg-orange-600 text-white shadow-lg shadow-orange-600/20'
    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">

            <div class="w-9 h-9 rounded-lg flex items-center justify-center
                {{ $assessmentMenuActive
    ? 'bg-white/15'
    : 'bg-slate-800 group-hover:bg-slate-700' }}">

                <svg class="w-5 h-5 {{ $assessmentMenuActive ? 'text-white' : 'text-orange-400' }}" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a3 3 0 006 0M9 5h6M9 13h6M9 17h4" />

                </svg>

            </div>

            <span class="font-medium">
                Penilaian Kinerja
            </span>

            {{-- Arrow --}}
            <svg id="assessmentMenuArrow" class="w-4 h-4 ml-auto transition-transform duration-200
                {{ $assessmentMenuActive ? 'rotate-180' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />

            </svg>

        </button>




        {{-- ===================================================== --}}
        {{-- SUBMENU PENILAIAN --}}
        {{-- ===================================================== --}}

        <div id="assessmentSubmenu" class="ml-4 pl-4 border-l border-slate-800 space-y-1
            {{ $assessmentMenuActive ? '' : 'hidden' }}">


            {{-- ================================================= --}}
            {{-- DATA PENILAIAN --}}
            {{-- ================================================= --}}
            {{--
            <a href="{{ route('admin.assessments.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200
                {{ request()->routeIs('admin.assessments.*')
            ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/20'
            : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">

                <div class="w-8 h-8 rounded-lg flex items-center justify-center
                            {{ request()->routeIs('admin.assessments.*')
            ? 'bg-white/15'
            : 'bg-slate-800 group-hover:bg-slate-700' }}">

                    <svg class="w-4 h-4 {{ request()->routeIs('admin.assessments.*') ? 'text-white' : 'text-indigo-400' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5h6m-7 4h8m-8 4h5m-7 8h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" />

                    </svg>

                </div>

                <span class="text-sm font-medium">
                    Data Penilaian
                </span>

            </a> --}}


            {{-- ================================================= --}}
            {{-- INDIKATOR PENILAIAN --}}
            {{-- ================================================= --}}

            <a href="{{ route('admin.assessment-indicators.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200
                {{ request()->routeIs('admin.assessment-indicators.*')
    ? 'bg-cyan-600 text-white shadow-lg shadow-cyan-600/20'
    : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">

                <div class="w-8 h-8 rounded-lg flex items-center justify-center
                            {{ request()->routeIs('admin.assessment-indicators.*')
    ? 'bg-white/15'
    : 'bg-slate-800 group-hover:bg-slate-700' }}">

                    <svg class="w-4 h-4 {{ request()->routeIs('admin.assessment-indicators.*') ? 'text-white' : 'text-cyan-400' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 6h11M9 12h11M9 18h11M5 6h.01M5 12h.01M5 18h.01" />

                    </svg>

                </div>

                <span class="text-sm font-medium">
                    Indikator Penilaian
                </span>

            </a>


            {{-- ================================================= --}}
            {{-- BOBOT PENILAIAN --}}
            {{-- ================================================= --}}

            <a href="{{ route('admin.assessment-weights.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200
                {{ request()->routeIs('admin.assessment-weights.*')
    ? 'bg-violet-600 text-white shadow-lg shadow-violet-600/20'
    : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">

                <div class="w-8 h-8 rounded-lg flex items-center justify-center
                            {{ request()->routeIs('admin.assessment-weights.*')
    ? 'bg-white/15'
    : 'bg-slate-800 group-hover:bg-slate-700' }}">

                    <svg class="w-4 h-4 {{ request()->routeIs('admin.assessment-weights.*') ? 'text-white' : 'text-violet-400' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v18m9-9H3" />

                    </svg>

                </div>

                <span class="text-sm font-medium">
                    Bobot Penilaian
                </span>

            </a>


            {{-- ================================================= --}}
            {{-- JENIS DOKUMEN --}}
            {{-- ================================================= --}}

            <a href="{{ route('admin.document-types.index') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200
                {{ request()->routeIs('admin.document-types.*')
    ? 'bg-teal-600 text-white shadow-lg shadow-teal-600/20'
    : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">

                <div class="w-8 h-8 rounded-lg flex items-center justify-center
                            {{ request()->routeIs('admin.document-types.*')
    ? 'bg-white/15'
    : 'bg-slate-800 group-hover:bg-slate-700' }}">

                    <svg class="w-4 h-4 {{ request()->routeIs('admin.document-types.*') ? 'text-white' : 'text-teal-400' }}"
                        fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 3h8l4 4v14H7a2 2 0 01-2-2V5a2 2 0 012-2z" />

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 3v5h5M9 13h6M9 17h6" />

                    </svg>

                </div>

                <span class="text-sm font-medium">
                    Jenis Dokumen
                </span>

            </a>


            {{-- ================================================= --}}
            {{-- PERIODE PENILAIAN SEMESTER --}}
            {{-- ================================================= --}}

            <a href="{{ url('/admin/assessment-periods') }}" class="group flex items-center gap-3 px-3 py-2.5 rounded-lg transition-all duration-200
    {{ request()->routeIs('admin.assessment-periods.*')
    ? 'bg-amber-600 text-white shadow-lg shadow-amber-600/20'
    : 'text-slate-400 hover:bg-slate-800 hover:text-white' }}">

                <div class="w-8 h-8 rounded-lg flex items-center justify-center
        {{ request()->routeIs('admin.assessment-periods.*')
    ? 'bg-white/15'
    : 'bg-slate-800 group-hover:bg-slate-700' }}">

                    <svg class="w-4 h-4
            {{ request()->routeIs('admin.assessment-periods.*')
    ? 'text-white'
    : 'text-amber-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 2v4m8-4v4M3 10h18M5 4h14a2 2 0 012 2v13a2 2 0 01-2 2H5a2 2 0 01-2-2V6a2 2 0 012-2z" />

                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 14h3m-3 4h3m4-4h1m-1 4h1" />

                    </svg>

                </div>

                <span class="text-sm font-medium">
                    Periode Penilaian Semester
                </span>

            </a>


        </div>


        {{-- ===================================================== --}}
        {{-- LAPORAN --}}
        {{-- ===================================================== --}}

        <div class="px-3 pt-5 pb-2">

            <p class="text-[10px] font-bold uppercase tracking-[0.15em] text-slate-500">
                Lainnya
            </p>

        </div>


        <a href="{{ route('admin.reports.index') }}" class="group flex items-center gap-3 px-4 py-3 rounded-xl
                                        transition-all duration-200
                                        {{ request()->routeIs('admin.reports.*')
    ? 'bg-yellow-600 text-white shadow-lg shadow-yellow-600/20'
    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">

            <div class="w-9 h-9 rounded-lg
                {{ request()->routeIs('admin.reports.*')
    ? 'bg-white/15'
    : 'bg-slate-800 group-hover:bg-slate-700' }}
                                    flex items-center justify-center">

                <svg class="w-5 h-5
                                        {{ request()->routeIs('admin.reports.*')
    ? 'text-white'
    : 'text-yellow-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-2m3 2v-4m3 4v-6M5 21h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v14a2 2 0 002 2z" />

                </svg>

            </div>

            <span class="font-medium">
                Laporan
            </span>

        </a>


    </nav>


    {{-- ========================================================= --}}
    {{-- USER AREA --}}
    {{-- ========================================================= --}}

    <div class="flex-shrink-0 p-4 border-t border-slate-800 bg-slate-950">


        {{-- User --}}
        <div class="flex items-center gap-3 mb-4">

            {{-- Avatar --}}
            <div class="w-11 h-11 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600
                       flex items-center justify-center shadow-lg shadow-blue-500/10">

                <span class="text-white font-bold text-lg">

                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                </span>

            </div>


            {{-- User Info --}}
            <div class="min-w-0 flex-1">

                <p class="text-xs text-slate-500">
                    Login sebagai
                </p>

                <p class="font-semibold text-white truncate">

                    {{ auth()->user()->name }}

                </p>

                <div class="flex items-center gap-1 mt-0.5">

                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>

                    <span class="text-[11px] text-emerald-400">
                        Administrator
                    </span>

                </div>

            </div>

        </div>


        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">

            @csrf

            <button type="submit" class="w-full flex items-center justify-center gap-2
                       bg-red-600/10 border border-red-500/20
                       text-red-400 hover:bg-red-600 hover:text-white
                       px-4 py-3 rounded-xl transition-all duration-200">

                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2h5a2 2 0 012 2v1" />

                </svg>

                <span class="font-semibold">
                    Logout
                </span>

            </button>

        </form>

    </div>

</aside>


{{-- ============================================================= --}}
{{-- MOBILE HAMBURGER --}}
{{-- ============================================================= --}}

<button id="sidebarToggle" type="button" onclick="openSidebar()" class="fixed top-4 left-4 z-30 lg:hidden
           w-11 h-11 rounded-xl
           bg-slate-900 text-white
           shadow-xl shadow-slate-900/20
           flex items-center justify-center
           hover:bg-slate-800 transition" aria-label="Buka menu">

    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">

        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />

    </svg>

</button>


{{-- ============================================================= --}}
{{-- SIDEBAR STYLE --}}
{{-- ============================================================= --}}

<style>
    .sidebar-scroll::-webkit-scrollbar {
        width: 5px;
    }

    .sidebar-scroll::-webkit-scrollbar-track {
        background: transparent;
    }

    .sidebar-scroll::-webkit-scrollbar-thumb {
        background: #334155;
        border-radius: 999px;
    }

    .sidebar-scroll::-webkit-scrollbar-thumb:hover {
        background: #475569;
    }

    .sidebar-scroll {
        scrollbar-width: thin;
        scrollbar-color: #334155 transparent;
    }
</style>


{{-- ============================================================= --}}
{{-- SIDEBAR JAVASCRIPT --}}
{{-- ============================================================= --}}

<script>

    /*
    |--------------------------------------------------------------------------
    | Toggle Menu Penilaian Kinerja
    |--------------------------------------------------------------------------
    */

    function toggleAssessmentMenu() {

        const submenu =
            document.getElementById('assessmentSubmenu');

        const arrow =
            document.getElementById('assessmentMenuArrow');

        submenu.classList.toggle('hidden');

        arrow.classList.toggle('rotate-180');

    }


    /*
    |--------------------------------------------------------------------------
    | Buka Sidebar Mobile
    |--------------------------------------------------------------------------
    */

    function openSidebar() {

        const sidebar =
            document.getElementById('adminSidebar');

        const overlay =
            document.getElementById('sidebarOverlay');

        const toggle =
            document.getElementById('sidebarToggle');

        sidebar.classList.remove('-translate-x-full');

        overlay.classList.remove('hidden');

        toggle.classList.add('hidden');

        document.body.classList.add('overflow-hidden');

    }


    /*
    |--------------------------------------------------------------------------
    | Tutup Sidebar Mobile
    |--------------------------------------------------------------------------
    */

    function closeSidebar() {

        const sidebar =
            document.getElementById('adminSidebar');

        const overlay =
            document.getElementById('sidebarOverlay');

        const toggle =
            document.getElementById('sidebarToggle');

        sidebar.classList.add('-translate-x-full');

        overlay.classList.add('hidden');

        toggle.classList.remove('hidden');

        document.body.classList.remove('overflow-hidden');

    }


    /*
    |--------------------------------------------------------------------------
    | Tutup sidebar ketika link diklik di mobile
    |--------------------------------------------------------------------------
    */

    document.addEventListener('DOMContentLoaded', function () {

        const sidebarLinks =
            document.querySelectorAll('#adminSidebar a');

        sidebarLinks.forEach(function (link) {

            link.addEventListener('click', function () {

                if (window.innerWidth < 1024) {

                    closeSidebar();

                }

            });

        });

    });


    /*
    |--------------------------------------------------------------------------
    | Jika layar berubah menjadi desktop
    |--------------------------------------------------------------------------
    */

    window.addEventListener('resize', function () {

        if (window.innerWidth >= 1024) {

            const sidebar =
                document.getElementById('adminSidebar');

            const overlay =
                document.getElementById('sidebarOverlay');

            const toggle =
                document.getElementById('sidebarToggle');

            sidebar.classList.remove('-translate-x-full');

            overlay.classList.add('hidden');

            toggle.classList.add('hidden');

            document.body.classList.remove('overflow-hidden');

        } else {

            const sidebar =
                document.getElementById('adminSidebar');

            const toggle =
                document.getElementById('sidebarToggle');

            if (
                sidebar.classList.contains('-translate-x-full')
            ) {

                toggle.classList.remove('hidden');

            }

        }

    });

</script>