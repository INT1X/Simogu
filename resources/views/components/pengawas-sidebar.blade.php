{{-- resources/views/components/pengawas-sidebar.blade.php --}}

@php
    use App\Models\TeacherDocument;

    $pendingDocumentsCount = 0;

    if (auth()->check()) {
        $supervisor = auth()->user()->supervisor;

        if ($supervisor) {
            $pendingDocumentsCount = TeacherDocument::where(
                'status',
                'pending'
            )
                ->whereHas('teacher', function ($query) use ($supervisor) {
                    $query->where(
                        'school_id',
                        $supervisor->school_id
                    );
                })
                ->count();
        }
    }
@endphp


<aside
    id="pengawas-sidebar"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-slate-200 shadow-sm
           transform -translate-x-full lg:translate-x-0
           transition-transform duration-300 ease-in-out"
>

    {{-- LOGO --}}
    <div class="h-20 flex items-center px-6 border-b border-slate-200">

        <a
            href="{{ route('pengawas.dashboard') }}"
            class="flex items-center gap-3"
        >

            <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-blue-500 to-indigo-600
                        flex items-center justify-center shadow-lg shadow-blue-500/20">

                <svg
                    class="w-6 h-6 text-white"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 14l9-5-9-5-9 5 9 5z"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 14l6.16-3.422A12.083 12.083 0 0118 16.5c0 1.657-2.686 3-6 3s-6-1.343-6-3c0-2.18.576-4.208 1.595-5.922L12 14z"
                    />
                </svg>

            </div>

            <div>
                <h1 class="text-lg font-bold text-slate-800">
                    SIMOGU
                </h1>

                <p class="text-xs text-slate-500">
                    Panel Pengawas
                </p>
            </div>

        </a>

    </div>


    {{-- USER --}}
    <div class="px-4 py-5 border-b border-slate-200">

        <div class="flex items-center gap-3 rounded-2xl bg-slate-50 px-3 py-3">

            <div class="w-10 h-10 rounded-xl bg-blue-100 flex items-center justify-center shrink-0">

                <span class="font-bold text-blue-700 text-sm">
                    {{ strtoupper(substr(auth()->user()->name ?? 'P', 0, 1)) }}
                </span>

            </div>

            <div class="min-w-0">

                <p class="font-semibold text-slate-800 text-sm truncate">
                    {{ auth()->user()->name ?? 'Pengawas' }}
                </p>

                <p class="text-xs text-blue-600">
                    Pengawas
                </p>

            </div>

        </div>

    </div>


    {{-- NAVIGATION --}}
    <nav class="px-4 py-5 space-y-1 overflow-y-auto h-[calc(100vh-165px)]">

        {{-- DASHBOARD --}}
        <a
            href="{{ route('pengawas.dashboard') }}"
            class="group flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-semibold transition
                {{ request()->routeIs('pengawas.dashboard')
                    ? 'bg-blue-50 text-blue-700'
                    : 'text-slate-600 hover:bg-slate-50 hover:text-slate-800' }}"
        >

            <svg
                class="w-5 h-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M3 12l9-9 9 9"
                />

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M5 10v10a1 1 0 001 1h4v-6h4v6h4a1 1 0 001-1V10"
                />
            </svg>

            Dashboard

        </a>


        {{-- PENILAIAN --}}
        <a
            href="{{ route('pengawas.assessments.index') }}"
            class="group flex items-center gap-3 px-4 py-3 rounded-xl
                   text-sm font-semibold transition
                {{ request()->routeIs('pengawas.assessments.*')
                    ? 'bg-blue-50 text-blue-700'
                    : 'text-slate-600 hover:bg-slate-50 hover:text-slate-800' }}"
        >

            <svg
                class="w-5 h-5"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2"
                />

                <rect
                    x="9"
                    y="3"
                    width="6"
                    height="4"
                    rx="1"
                    stroke-width="2"
                />

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 13h6M9 17h4"
                />

            </svg>

            Penilaian Guru

        </a>


        {{-- DOKUMEN --}}
        <a
            href="{{ route('pengawas.documents.index') }}"
            class="group flex items-center justify-between px-4 py-3 rounded-xl
                   text-sm font-semibold transition
                {{ request()->routeIs('pengawas.documents.*')
                    ? 'bg-blue-50 text-blue-700'
                    : 'text-slate-600 hover:bg-slate-50 hover:text-slate-800' }}"
        >

            <span class="flex items-center gap-3">

                <svg
                    class="w-5 h-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M7 3h8l4 4v14H7a2 2 0 01-2-2V5a2 2 0 012-2z"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 3v5h5"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M9 13h6M9 17h4"
                    />

                </svg>

                Dokumen Guru

            </span>

            @if ($pendingDocumentsCount > 0)

                <span
                    class="min-w-[22px] h-[22px] px-1.5
                           rounded-full bg-red-500 text-white
                           text-[11px] font-bold
                           flex items-center justify-center"
                >
                    {{ $pendingDocumentsCount > 99 ? '99+' : $pendingDocumentsCount }}
                </span>

            @endif

        </a>


        {{-- LONCENG NOTIFIKASI --}}
        <div class="flex items-center justify-between px-4 py-3">

            <span class="text-sm font-semibold text-slate-500">
                Notifikasi
            </span>

            <a
                href="{{ route('pengawas.documents.index') }}"
                class="relative w-10 h-10 rounded-xl
                       flex items-center justify-center
                       text-slate-500
                       hover:bg-blue-50
                       hover:text-blue-600
                       transition"
                title="Dokumen menunggu verifikasi"
                aria-label="Dokumen menunggu verifikasi"
            >

                {{-- ICON LONCENG --}}
                <svg
                    class="w-6 h-6"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M15 17h5l-1.5-2.5V10a6.5 6.5 0 00-13 0v4.5L4 17h5"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M10 21h4"
                    />

                </svg>


                {{-- BADGE --}}
                @if ($pendingDocumentsCount > 0)

                    <span
                        class="absolute -top-1 -right-1
                               min-w-[20px] h-[20px] px-1
                               rounded-full bg-red-500 text-white
                               text-[10px] font-bold
                               flex items-center justify-center
                               border-2 border-white"
                    >
                        {{ $pendingDocumentsCount > 99 ? '99+' : $pendingDocumentsCount }}
                    </span>

                @endif

            </a>

        </div>


        {{-- PEMBATAS --}}
        <div class="pt-5 pb-2 px-4">

            <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400">
                Akun
            </p>

        </div>


        {{-- PROFILE --}}
        <a
            href="{{ route('pengawas.profile') }}"
            class="group flex items-center gap-3 px-4 py-3 rounded-xl
                   text-sm font-semibold text-slate-600
                   hover:bg-slate-50 hover:text-slate-800 transition"
        >

            <svg
                class="w-5 h-5 text-slate-400"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0z"
                />

                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                />

            </svg>

            Profil

        </a>


        {{-- LOGOUT --}}
        <form
            method="POST"
            action="{{ route('logout') }}"
        >

            @csrf

            <button
                type="submit"
                class="w-full flex items-center gap-3 px-4 py-3 rounded-xl
                       text-sm font-semibold text-red-600
                       hover:bg-red-50 transition"
            >

                <svg
                    class="w-5 h-5 text-red-500"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7"
                    />

                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 4v16"
                    />

                </svg>

                Keluar

            </button>

        </form>

    </nav>

</aside>


{{-- MOBILE OVERLAY --}}
<div
    id="pengawas-sidebar-overlay"
    class="fixed inset-0 z-40 bg-slate-900/50 hidden lg:hidden"
></div>


{{-- MOBILE TOGGLE --}}
<button
    id="pengawas-sidebar-toggle"
    type="button"
    class="fixed top-4 left-4 z-30 lg:hidden
           w-11 h-11 rounded-xl bg-white
           border border-slate-200 shadow-sm
           flex items-center justify-center
           text-slate-600 hover:bg-slate-50 transition"
    aria-label="Buka menu"
>

    <svg
        class="w-6 h-6"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
    >

        <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M4 6h16M4 12h16M4 18h16"
        />

    </svg>

</button>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const sidebar = document.getElementById('pengawas-sidebar');
    const toggle = document.getElementById('pengawas-sidebar-toggle');
    const overlay = document.getElementById('pengawas-sidebar-overlay');

    if (!sidebar || !toggle || !overlay) {
        return;
    }

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('hidden');
    }

    toggle.addEventListener('click', function () {

        if (sidebar.classList.contains('-translate-x-full')) {
            openSidebar();
        } else {
            closeSidebar();
        }

    });

    overlay.addEventListener('click', closeSidebar);

    window.addEventListener('resize', function () {

        if (window.innerWidth >= 1024) {

            sidebar.classList.remove('-translate-x-full');
            overlay.classList.add('hidden');

        } else {

            sidebar.classList.add('-translate-x-full');

        }

    });

});

</script>