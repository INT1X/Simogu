<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Guru - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100">

    {{-- SIDEBAR --}}
    @include('components.pengawas-sidebar')


    <main class="lg:ml-64 min-h-screen">

        {{-- HEADER --}}
        <header class="bg-white border-b border-slate-200 shadow-sm">

            <div class="px-4 sm:px-6 lg:px-8 py-5">

                <div class="flex flex-col sm:flex-row
                            sm:items-center
                            sm:justify-between
                            gap-4">

                    <div>

                        <a
                            href="{{ route('pengawas.teachers.index') }}"
                            class="inline-flex items-center
                                   text-sm font-semibold
                                   text-blue-600
                                   hover:text-blue-800
                                   mb-2"
                        >
                            ← Kembali ke Guru Binaan
                        </a>

                        <h1 class="text-2xl font-bold text-slate-800">
                            Detail Guru
                        </h1>

                        <p class="text-sm text-slate-500 mt-1">
                            Informasi lengkap guru binaan.
                        </p>

                    </div>


                    <div class="text-left sm:text-right">

                        <p class="font-semibold text-slate-800">
                            {{ auth()->user()->name }}
                        </p>

                        <p class="text-sm text-blue-600">
                            Pengawas
                        </p>

                    </div>

                </div>

            </div>

        </header>


        {{-- CONTENT --}}
        <section class="p-4 sm:p-6 lg:p-8">

            {{-- INFORMASI GURU --}}
            <div class="bg-white
                        rounded-2xl
                        border border-slate-200
                        shadow-sm
                        overflow-hidden
                        mb-6">

                {{-- HEADER GURU --}}
                <div class="bg-gradient-to-r
                            from-blue-600
                            to-indigo-600
                            px-6 py-6
                            text-white">

                    <div class="flex flex-col sm:flex-row
                                sm:items-center
                                gap-5">

                        {{-- FOTO / INISIAL --}}
                        <div class="w-20 h-20
                                    rounded-2xl
                                    bg-white/10
                                    border border-white/20
                                    flex items-center
                                    justify-center
                                    overflow-hidden
                                    flex-shrink-0">

                            @if($teacher->photo)

                                <img
                                    src="{{ asset('storage/' . $teacher->photo) }}"
                                    alt="{{ $teacher->name }}"
                                    class="w-full h-full object-cover"
                                >

                            @else

                                <span class="text-3xl font-bold">
                                    {{ strtoupper(substr($teacher->name, 0, 1)) }}
                                </span>

                            @endif

                        </div>


                        {{-- NAMA --}}
                        <div>

                            <p class="text-sm text-blue-100">
                                Guru Binaan
                            </p>

                            <h2 class="text-2xl font-bold">
                                {{ $teacher->name }}
                            </h2>

                            @if($teacher->nip)

                                <p class="text-sm text-blue-100 mt-1">
                                    NIP: {{ $teacher->nip }}
                                </p>

                            @endif

                        </div>

                    </div>

                </div>


                {{-- DATA GURU --}}
                <div class="p-6">

                    <div class="grid grid-cols-1
                                md:grid-cols-2
                                lg:grid-cols-3
                                gap-5">


                        {{-- SEKOLAH --}}
                        <div class="rounded-xl
                                    bg-slate-50
                                    border border-slate-200
                                    p-4">

                            <p class="text-xs
                                      uppercase
                                      tracking-wider
                                      font-bold
                                      text-slate-400">

                                Sekolah

                            </p>

                            <p class="mt-1
                                      font-semibold
                                      text-slate-800">

                                {{ $teacher->school->name ?? '-' }}

                            </p>

                        </div>


                        {{-- NIP --}}
                        <div class="rounded-xl
                                    bg-slate-50
                                    border border-slate-200
                                    p-4">

                            <p class="text-xs
                                      uppercase
                                      tracking-wider
                                      font-bold
                                      text-slate-400">

                                NIP

                            </p>

                            <p class="mt-1
                                      font-semibold
                                      text-slate-800">

                                {{ $teacher->nip ?: '-' }}

                            </p>

                        </div>


                        {{-- NIK --}}
                        <div class="rounded-xl
                                    bg-slate-50
                                    border border-slate-200
                                    p-4">

                            <p class="text-xs
                                      uppercase
                                      tracking-wider
                                      font-bold
                                      text-slate-400">

                                NIK

                            </p>

                            <p class="mt-1
                                      font-semibold
                                      text-slate-800">

                                {{ $teacher->nik ?: '-' }}

                            </p>

                        </div>


                        {{-- MATA PELAJARAN --}}
                        <div class="rounded-xl
                                    bg-slate-50
                                    border border-slate-200
                                    p-4">

                            <p class="text-xs
                                      uppercase
                                      tracking-wider
                                      font-bold
                                      text-slate-400">

                                Mata Pelajaran

                            </p>

                            <p class="mt-1
                                      font-semibold
                                      text-slate-800">

                                {{ $teacher->subject ?: '-' }}

                            </p>

                        </div>


                        {{-- JENIS KELAMIN --}}
                        <div class="rounded-xl
                                    bg-slate-50
                                    border border-slate-200
                                    p-4">

                            <p class="text-xs
                                      uppercase
                                      tracking-wider
                                      font-bold
                                      text-slate-400">

                                Jenis Kelamin

                            </p>

                            <p class="mt-1
                                      font-semibold
                                      text-slate-800">

                                {{ $teacher->gender ?: '-' }}

                            </p>

                        </div>


                        {{-- STATUS KEPEGAWAIAN --}}
                        <div class="rounded-xl
                                    bg-slate-50
                                    border border-slate-200
                                    p-4">

                            <p class="text-xs
                                      uppercase
                                      tracking-wider
                                      font-bold
                                      text-slate-400">

                                Status Kepegawaian

                            </p>

                            <p class="mt-1
                                      font-semibold
                                      text-slate-800">

                                {{ $teacher->employment_status ?: '-' }}

                            </p>

                        </div>


                        {{-- TELEPON --}}
                        <div class="rounded-xl
                                    bg-slate-50
                                    border border-slate-200
                                    p-4">

                            <p class="text-xs
                                      uppercase
                                      tracking-wider
                                      font-bold
                                      text-slate-400">

                                No. Telepon

                            </p>

                            <p class="mt-1
                                      font-semibold
                                      text-slate-800">

                                {{ $teacher->phone ?: '-' }}

                            </p>

                        </div>


                        {{-- EMAIL --}}
                        <div class="rounded-xl
                                    bg-slate-50
                                    border border-slate-200
                                    p-4">

                            <p class="text-xs
                                      uppercase
                                      tracking-wider
                                      font-bold
                                      text-slate-400">

                                Email

                            </p>

                            <p class="mt-1
                                      font-semibold
                                      text-slate-800
                                      break-all">

                                {{ $teacher->email ?: '-' }}

                            </p>

                        </div>


                        {{-- STATUS --}}
                        <div class="rounded-xl
                                    bg-slate-50
                                    border border-slate-200
                                    p-4">

                            <p class="text-xs
                                      uppercase
                                      tracking-wider
                                      font-bold
                                      text-slate-400">

                                Status

                            </p>

                            <div class="mt-2">

                                @if($teacher->status === 'aktif')

                                    <span class="inline-flex
                                                 px-3 py-1
                                                 rounded-full
                                                 bg-green-100
                                                 text-green-700
                                                 text-xs
                                                 font-bold">

                                        Aktif

                                    </span>

                                @else

                                    <span class="inline-flex
                                                 px-3 py-1
                                                 rounded-full
                                                 bg-red-100
                                                 text-red-700
                                                 text-xs
                                                 font-bold">

                                        {{ ucfirst($teacher->status ?? 'Tidak diketahui') }}

                                    </span>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- AKSI --}}
            <div class="bg-white
                        rounded-2xl
                        border border-slate-200
                        shadow-sm
                        p-5">

                <div class="flex flex-col
                            sm:flex-row
                            sm:items-center
                            sm:justify-between
                            gap-4">

                    <div>

                        <h2 class="font-bold text-slate-800">
                            Penilaian Guru
                        </h2>

                        <p class="text-sm text-slate-500 mt-1">
                            Lakukan penilaian kinerja untuk guru ini.
                        </p>

                    </div>


                    <a
                        href="{{ route('pengawas.assessments.create', ['teacher_id' => $teacher->id]) }}"
                        class="inline-flex
                               items-center
                               justify-center
                               px-5 py-3
                               rounded-xl
                               bg-blue-600
                               hover:bg-blue-700
                               text-white
                               font-bold
                               text-sm
                               transition"
                    >

                        <svg
                            class="w-5 h-5 mr-2"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >

                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M12 4v16m8-8H4"
                            />

                        </svg>

                        Nilai Guru

                    </a>

                </div>

            </div>

        </section>

    </main>

</body>

</html>