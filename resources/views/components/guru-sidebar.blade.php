<aside id="guru-sidebar" class="fixed inset-y-0 left-0 z-50 w-72 bg-slate-900 text-white
           transform -translate-x-full md:translate-x-0
           transition-transform duration-300 ease-in-out
           flex flex-col shadow-xl">

    {{-- Logo --}}
    <div class="h-20 px-6 flex items-center border-b border-slate-800">

        <div class="w-11 h-11 rounded-xl bg-blue-600
                    flex items-center justify-center mr-3">

            <i class="fa-solid fa-school text-xl"></i>

        </div>

        <div>
            <h1 class="text-xl font-bold">
                SIMOGU
            </h1>

            <p class="text-xs text-slate-400">
                Sistem Informasi Guru
            </p>
        </div>

    </div>


    {{-- Profile --}}
    <div class="px-5 py-5 border-b border-slate-800">

        <div class="flex items-center">

            <div class="w-11 h-11 rounded-full overflow-hidden
                        bg-slate-700 flex items-center justify-center">

                @if(auth()->user()->teacher?->photo)

                    <img src="{{ asset('storage/' . auth()->user()->teacher->photo) }}" class="w-full h-full object-cover"
                        alt="Foto Profil">

                @else

                    <i class="fa-solid fa-user text-slate-300"></i>

                @endif

            </div>

            <div class="ml-3 min-w-0">

                <p class="font-semibold truncate">
                    {{ auth()->user()->name }}
                </p>

                <p class="text-xs text-slate-400">
                    Guru
                </p>

            </div>

        </div>

    </div>


    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto px-4 py-5 space-y-2">

        {{-- Dashboard --}}
        <a href="{{ route('guru.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl
            {{ request()->routeIs('guru.dashboard')
    ? 'bg-blue-600 text-white'
    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">

            <i class="fa-solid fa-gauge w-5"></i>

            <span>
                Dashboard
            </span>

        </a>


        {{-- Dokumen --}}
        <a href="{{ route('guru.documents.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl
            {{ request()->routeIs('guru.documents.*')
    ? 'bg-blue-600 text-white'
    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">

            <i class="fa-solid fa-folder-open w-5"></i>

            <span>
                Dokumen Saya
            </span>

        </a>


        {{-- Profil --}}
        <a href="{{ route('guru.profile') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl
          {{ request()->routeIs('guru.profile')
    ? 'bg-blue-600 text-white'
    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <i class="fa-solid fa-user w-5"></i>
            <span>
                Profil Saya
            </span>
        </a>


        {{-- Kinerja --}}
        {{-- Kinerja --}}
        <a href="{{ route('guru.performance') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl
          {{ request()->routeIs('guru.performance')
    ? 'bg-blue-600 text-white'
    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <i class="fa-solid fa-chart-line w-5"></i>
            <span>
                Kinerja Saya
            </span>
        </a>


        {{-- Penilaian --}}
        {{-- Penilaian --}}
        <a href="{{ route('guru.assessment') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl
          {{ request()->routeIs('guru.assessment')
    ? 'bg-blue-600 text-white'
    : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}">
            <i class="fa-solid fa-clipboard-check w-5"></i>
            <span>
                Hasil Penilaian
            </span>
        </a>

    </nav>


    {{-- Logout --}}
    <div class="p-4 border-t border-slate-800">

        <form method="POST" action="{{ route('logout') }}">

            @csrf

            <button type="submit" class="w-full flex items-center justify-center gap-2
                       px-4 py-3 rounded-xl
                       bg-red-600 hover:bg-red-700
                       transition">

                <i class="fa-solid fa-right-from-bracket"></i>

                <span>
                    Logout
                </span>

            </button>

        </form>

    </div>

</aside>


{{-- Overlay Mobile --}}
<div id="guru-sidebar-overlay" class="fixed inset-0 z-40 bg-black/50 hidden md:hidden"></div>