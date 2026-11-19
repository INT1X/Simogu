@php
    use Illuminate\Support\Facades\Storage;
@endphp

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Detail Guru - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="bg-slate-100 text-slate-800">


<div class="min-h-screen">


    {{-- ========================================================= --}}
    {{-- SIDEBAR --}}
    {{-- ========================================================= --}}

    @include('components.admin-sidebar')



    {{-- ========================================================= --}}
    {{-- MAIN CONTENT --}}
    {{-- ========================================================= --}}

    <main class="lg:ml-64 min-h-screen transition-all duration-300">


        {{-- ===================================================== --}}
        {{-- HEADER --}}
        {{-- ===================================================== --}}

        <header class="sticky top-0 z-30 bg-white/95 backdrop-blur
                       border-b border-slate-200 shadow-sm">

            <div class="px-4 sm:px-6 lg:px-8 py-5">

                <div class="flex flex-col lg:flex-row
                            lg:items-center lg:justify-between
                            gap-5">


                    {{-- TITLE --}}

                    <div class="flex items-start gap-3">

                        <div class="w-1.5 h-12
                                    bg-blue-600
                                    rounded-full
                                    shrink-0">
                        </div>


                        <div>

                            <h1 class="text-2xl sm:text-3xl
                                       font-bold text-slate-800">

                                Detail Guru

                            </h1>


                            <p class="text-sm sm:text-base
                                      text-slate-500 mt-1">

                                Informasi lengkap data guru
                                dan akun login SIMOGU.

                            </p>

                        </div>

                    </div>



                    {{-- USER INFO --}}

                    <div class="flex items-center gap-3">


                        <div class="hidden sm:block text-right">

                            <p class="font-semibold text-slate-800">

                                {{ auth()->user()->name }}

                            </p>


                            <div class="flex items-center
                                        justify-end gap-1 mt-1">

                                <span
                                    class="w-2 h-2 rounded-full
                                           bg-emerald-500">
                                </span>

                                <span
                                    class="text-xs font-medium
                                           text-emerald-600">

                                    Administrator

                                </span>

                            </div>

                        </div>


                        <div class="w-11 h-11
                                    rounded-xl
                                    bg-blue-100
                                    text-blue-600
                                    flex items-center justify-center
                                    font-bold">

                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                        </div>

                    </div>

                </div>

            </div>

        </header>



        {{-- ===================================================== --}}
        {{-- CONTENT --}}
        {{-- ===================================================== --}}

        <section class="p-4 sm:p-6 lg:p-8">


            {{-- ================================================= --}}
            {{-- TOP ACTION --}}
            {{-- ================================================= --}}

            <div class="flex flex-col sm:flex-row
                        sm:items-center
                        sm:justify-between
                        gap-4 mb-6">


                <div>

                    <p class="text-sm text-slate-500">

                        Data Guru

                    </p>

                    <h2 class="text-xl font-bold text-slate-800 mt-1">

                        {{ $teacher->name }}

                    </h2>

                </div>



                <div class="flex flex-wrap gap-2">


                    {{-- EDIT --}}

                    <a
                        href="{{ route('admin.teachers.edit', $teacher) }}"
                        class="inline-flex items-center justify-center
                               gap-2
                               px-5 py-2.5
                               rounded-xl
                               bg-blue-600
                               text-white
                               font-semibold
                               shadow-sm
                               hover:bg-blue-700
                               hover:shadow-md
                               transition"
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
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"
                            />

                        </svg>

                        Edit

                    </a>



                    {{-- KEMBALI --}}

                    <a
                        href="{{ route('admin.teachers.index') }}"
                        class="inline-flex items-center justify-center
                               gap-2
                               px-5 py-2.5
                               rounded-xl
                               bg-white
                               border border-slate-200
                               text-slate-700
                               font-semibold
                               hover:bg-slate-50
                               transition"
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
                                d="M10 19l-7-7m0 0l7-7m-7 7h18"
                            />

                        </svg>

                        Kembali

                    </a>

                </div>

            </div>



            {{-- ================================================= --}}
            {{-- PROFILE CARD --}}
            {{-- ================================================= --}}

            <div class="bg-white
                        rounded-3xl
                        border border-slate-200
                        shadow-sm
                        overflow-hidden
                        mb-6">


                {{-- PROFILE HEADER --}}

                <div class="relative
                            bg-gradient-to-r
                            from-blue-600
                            via-blue-500
                            to-indigo-600
                            px-6 sm:px-8
                            py-8 sm:py-10">


                    {{-- Decorative --}}

                    <div class="absolute
                                -right-16
                                -top-16
                                w-48 h-48
                                rounded-full
                                bg-white/10">
                    </div>


                    <div class="absolute
                                right-20
                                -bottom-20
                                w-40 h-40
                                rounded-full
                                bg-white/5">
                    </div>



                    <div class="relative
                                flex flex-col
                                sm:flex-row
                                sm:items-center
                                gap-6">


                        {{-- FOTO --}}

                        <div class="shrink-0">


                            @if($teacher->photo)

                                <img
                                    src="{{ asset('storage/' . $teacher->photo) }}"
                                    alt="{{ $teacher->name }}"
                                    class="w-32 h-32
                                           sm:w-36 sm:h-36
                                           rounded-3xl
                                           object-cover
                                           border-4
                                           border-white
                                           shadow-xl"
                                >

                            @else

                                <div
                                    class="w-32 h-32
                                           sm:w-36 sm:h-36
                                           rounded-3xl
                                           bg-white/20
                                           backdrop-blur
                                           border-4
                                           border-white/40
                                           flex items-center
                                           justify-center
                                           shadow-xl"
                                >

                                    <svg
                                        class="w-16 h-16 text-white/80"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="1.5"
                                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 20.25a8.25 8.25 0 0115 0"
                                        />

                                    </svg>

                                </div>

                            @endif

                        </div>



                        {{-- PROFILE INFO --}}

                        <div class="text-white">


                            <div class="flex flex-wrap
                                        items-center gap-2 mb-2">

                                <h2 class="text-2xl sm:text-3xl
                                           font-bold">

                                    {{ $teacher->name }}

                                </h2>


                                @if($teacher->status === 'aktif')

                                    <span
                                        class="inline-flex
                                               items-center gap-1
                                               px-3 py-1
                                               rounded-full
                                               bg-emerald-400/20
                                               border border-emerald-200/30
                                               text-emerald-50
                                               text-xs
                                               font-semibold"
                                    >

                                        <span
                                            class="w-2 h-2
                                                   rounded-full
                                                   bg-emerald-300">
                                        </span>

                                        Aktif

                                    </span>

                                @endif

                            </div>



                            <p class="text-blue-100 text-base">

                                {{ $teacher->subject ?: 'Mata pelajaran belum diisi' }}

                            </p>



                            <div class="flex flex-wrap
                                        gap-2 mt-4">


                                @if($teacher->employment_status)

                                    <span
                                        class="px-3 py-1.5
                                               rounded-lg
                                               bg-white/15
                                               border border-white/20
                                               text-sm"
                                    >

                                        {{ $teacher->employment_status }}

                                    </span>

                                @endif


                                @if($teacher->nip)

                                    <span
                                        class="px-3 py-1.5
                                               rounded-lg
                                               bg-white/15
                                               border border-white/20
                                               text-sm"
                                    >

                                        NIP: {{ $teacher->nip }}

                                    </span>

                                @endif

                            </div>

                        </div>

                    </div>

                </div>



                {{-- QUICK INFO --}}

                <div class="grid grid-cols-1
                            sm:grid-cols-2
                            lg:grid-cols-4
                            divide-y
                            sm:divide-y-0
                            sm:divide-x
                            divide-slate-200">


                    {{-- SEKOLAH --}}

                    <div class="p-5">

                        <p class="text-xs
                                  font-semibold
                                  uppercase
                                  tracking-wider
                                  text-slate-400">

                            Sekolah

                        </p>

                        <p class="mt-2
                                  font-semibold
                                  text-slate-800
                                  truncate">

                            {{ $teacher->school?->name ?: '-' }}

                        </p>

                    </div>



                    {{-- NIP --}}

                    <div class="p-5">

                        <p class="text-xs
                                  font-semibold
                                  uppercase
                                  tracking-wider
                                  text-slate-400">

                            NIP

                        </p>

                        <p class="mt-2
                                  font-semibold
                                  text-slate-800">

                            {{ $teacher->nip ?: '-' }}

                        </p>

                    </div>



                    {{-- TELEPON --}}

                    <div class="p-5">

                        <p class="text-xs
                                  font-semibold
                                  uppercase
                                  tracking-wider
                                  text-slate-400">

                            No. Telepon

                        </p>

                        <p class="mt-2
                                  font-semibold
                                  text-slate-800">

                            {{ $teacher->phone ?: '-' }}

                        </p>

                    </div>



                    {{-- EMAIL --}}

                    <div class="p-5">

                        <p class="text-xs
                                  font-semibold
                                  uppercase
                                  tracking-wider
                                  text-slate-400">

                            Email

                        </p>

                        <p class="mt-2
                                  font-semibold
                                  text-slate-800
                                  truncate">

                            {{ $teacher->email ?: '-' }}

                        </p>

                    </div>

                </div>

            </div>



            {{-- ================================================= --}}
            {{-- INFORMASI DETAIL --}}
            {{-- ================================================= --}}

            <div class="grid grid-cols-1
                        lg:grid-cols-3
                        gap-6">


                {{-- ================================================= --}}
                {{-- DATA PRIBADI --}}
                {{-- ================================================= --}}

                <div class="lg:col-span-2
                            bg-white
                            rounded-3xl
                            border border-slate-200
                            shadow-sm
                            overflow-hidden">


                    <div class="px-6 py-5
                                border-b border-slate-200">

                        <div class="flex items-center gap-3">

                            <div class="w-11 h-11
                                        rounded-xl
                                        bg-blue-50
                                        text-blue-600
                                        flex items-center
                                        justify-center">

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
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                    />

                                </svg>

                            </div>


                            <div>

                                <h3 class="font-bold
                                           text-slate-800">

                                    Informasi Guru

                                </h3>

                                <p class="text-sm
                                          text-slate-500">

                                    Data pribadi dan informasi pekerjaan.

                                </p>

                            </div>

                        </div>

                    </div>



                    <div class="p-6">

                        <div class="grid grid-cols-1
                                    md:grid-cols-2
                                    xl:grid-cols-3
                                    gap-5">


                            {{-- NAMA --}}

                            <div class="rounded-2xl
                                        bg-slate-50
                                        border border-slate-100
                                        p-4">

                                <p class="text-xs
                                          text-slate-400
                                          font-semibold
                                          uppercase">

                                    Nama Lengkap

                                </p>

                                <p class="font-semibold
                                          text-slate-800
                                          mt-2">

                                    {{ $teacher->name }}

                                </p>

                            </div>



                            {{-- NIP --}}

                            <div class="rounded-2xl
                                        bg-slate-50
                                        border border-slate-100
                                        p-4">

                                <p class="text-xs
                                          text-slate-400
                                          font-semibold
                                          uppercase">

                                    NIP

                                </p>

                                <p class="font-semibold
                                          text-slate-800
                                          mt-2">

                                    {{ $teacher->nip ?: '-' }}

                                </p>

                            </div>



                            {{-- NIK --}}

                            <div class="rounded-2xl
                                        bg-slate-50
                                        border border-slate-100
                                        p-4">

                                <p class="text-xs
                                          text-slate-400
                                          font-semibold
                                          uppercase">

                                    NIK

                                </p>

                                <p class="font-semibold
                                          text-slate-800
                                          mt-2">

                                    {{ $teacher->nik ?: '-' }}

                                </p>

                            </div>



                            {{-- SEKOLAH --}}

                            <div class="rounded-2xl
                                        bg-slate-50
                                        border border-slate-100
                                        p-4">

                                <p class="text-xs
                                          text-slate-400
                                          font-semibold
                                          uppercase">

                                    Sekolah

                                </p>

                                <p class="font-semibold
                                          text-slate-800
                                          mt-2">

                                    {{ $teacher->school?->name ?: '-' }}

                                </p>

                            </div>



                            {{-- GENDER --}}

                            <div class="rounded-2xl
                                        bg-slate-50
                                        border border-slate-100
                                        p-4">

                                <p class="text-xs
                                          text-slate-400
                                          font-semibold
                                          uppercase">

                                    Jenis Kelamin

                                </p>

                                <p class="font-semibold
                                          text-slate-800
                                          mt-2">

                                    {{ $teacher->gender ?: '-' }}

                                </p>

                            </div>



                            {{-- SUBJECT --}}

                            <div class="rounded-2xl
                                        bg-slate-50
                                        border border-slate-100
                                        p-4">

                                <p class="text-xs
                                          text-slate-400
                                          font-semibold
                                          uppercase">

                                    Mata Pelajaran

                                </p>

                                <p class="font-semibold
                                          text-slate-800
                                          mt-2">

                                    {{ $teacher->subject ?: '-' }}

                                </p>

                            </div>



                            {{-- STATUS --}}

                            <div class="rounded-2xl
                                        bg-slate-50
                                        border border-slate-100
                                        p-4">

                                <p class="text-xs
                                          text-slate-400
                                          font-semibold
                                          uppercase">

                                    Status Kepegawaian

                                </p>

                                <p class="font-semibold
                                          text-slate-800
                                          mt-2">

                                    {{ $teacher->employment_status ?: '-' }}

                                </p>

                            </div>



                            {{-- TELEPON --}}

                            <div class="rounded-2xl
                                        bg-slate-50
                                        border border-slate-100
                                        p-4">

                                <p class="text-xs
                                          text-slate-400
                                          font-semibold
                                          uppercase">

                                    Telepon

                                </p>

                                <p class="font-semibold
                                          text-slate-800
                                          mt-2">

                                    {{ $teacher->phone ?: '-' }}

                                </p>

                            </div>



                            {{-- EMAIL --}}

                            <div class="rounded-2xl
                                        bg-slate-50
                                        border border-slate-100
                                        p-4">

                                <p class="text-xs
                                          text-slate-400
                                          font-semibold
                                          uppercase">

                                    Email

                                </p>

                                <p class="font-semibold
                                          text-slate-800
                                          mt-2
                                          break-all">

                                    {{ $teacher->email ?: '-' }}

                                </p>

                            </div>

                        </div>

                    </div>

                </div>



                {{-- ================================================= --}}
                {{-- AKUN LOGIN --}}
                {{-- ================================================= --}}

                <div class="bg-white
                            rounded-3xl
                            border border-slate-200
                            shadow-sm
                            overflow-hidden
                            h-fit">


                    <div class="px-6 py-5
                                bg-gradient-to-r
                                from-emerald-50
                                to-white
                                border-b border-slate-200">

                        <div class="flex items-center gap-3">

                            <div class="w-11 h-11
                                        rounded-xl
                                        bg-emerald-100
                                        text-emerald-600
                                        flex items-center
                                        justify-center">

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
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"
                                    />

                                </svg>

                            </div>


                            <div>

                                <h3 class="font-bold
                                           text-slate-800">

                                    Akun Login

                                </h3>

                                <p class="text-sm
                                          text-slate-500">

                                    Informasi akun Guru.

                                </p>

                            </div>

                        </div>

                    </div>



                    <div class="p-6">


                        @if($teacher->user)


                            {{-- STATUS AKUN --}}

                            <div class="flex items-center
                                        gap-3
                                        p-4
                                        rounded-2xl
                                        bg-emerald-50
                                        border border-emerald-100
                                        mb-5">

                                <div class="w-10 h-10
                                            rounded-xl
                                            bg-emerald-100
                                            flex items-center
                                            justify-center">

                                    <svg
                                        class="w-5 h-5 text-emerald-600"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >

                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M5 13l4 4L19 7"
                                        />

                                    </svg>

                                </div>


                                <div>

                                    <p class="font-bold
                                              text-emerald-800">

                                        Akun Aktif

                                    </p>

                                    <p class="text-xs
                                              text-emerald-600">

                                        Guru dapat login ke sistem.

                                    </p>

                                </div>

                            </div>



                            {{-- EMAIL --}}

                            <div class="mb-5">

                                <p class="text-xs
                                          font-semibold
                                          uppercase
                                          tracking-wider
                                          text-slate-400">

                                    Email Login

                                </p>

                                <p class="font-semibold
                                          text-slate-800
                                          mt-2
                                          break-all">

                                    {{ $teacher->user->email }}

                                </p>

                            </div>



                            {{-- ROLE --}}

                            <div>

                                <p class="text-xs
                                          font-semibold
                                          uppercase
                                          tracking-wider
                                          text-slate-400">

                                    Role

                                </p>


                                <span
                                    class="inline-flex
                                           items-center
                                           mt-2
                                           px-3 py-1.5
                                           rounded-full
                                           bg-blue-50
                                           text-blue-700
                                           text-xs
                                           font-semibold"
                                >

                                    Guru

                                </span>

                            </div>


                        @else


                            {{-- NO ACCOUNT --}}

                            <div class="rounded-2xl
                                        bg-red-50
                                        border border-red-100
                                        p-5">

                                <div class="flex items-start gap-3">

                                    <div class="w-10 h-10
                                                rounded-xl
                                                bg-red-100
                                                flex items-center
                                                justify-center
                                                shrink-0">

                                        <svg
                                            class="w-5 h-5 text-red-600"
                                            fill="none"
                                            stroke="currentColor"
                                            viewBox="0 0 24 24"
                                        >

                                            <path
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M12 9v2m0 4h.01M12 3a9 9 0 100 18 9 9 0 000-18z"
                                            />

                                        </svg>

                                    </div>


                                    <div>

                                        <p class="font-bold
                                                  text-red-700">

                                            Belum Memiliki Akun

                                        </p>

                                        <p class="text-sm
                                                  text-red-600
                                                  mt-1">

                                            Guru ini belum memiliki
                                            akun login.

                                        </p>

                                    </div>

                                </div>

                            </div>

                        @endif

                    </div>

                </div>

            </div>



            {{-- ================================================= --}}
            {{-- FOOTER ACTION --}}
            {{-- ================================================= --}}

            <div class="mt-6
                        bg-white
                        rounded-2xl
                        border border-slate-200
                        p-5
                        flex flex-col
                        sm:flex-row
                        sm:items-center
                        sm:justify-between
                        gap-4">


                <div>

                    <p class="font-semibold text-slate-800">

                        Kelola Data Guru

                    </p>

                    <p class="text-sm text-slate-500 mt-1">

                        Pastikan informasi guru selalu diperbarui.

                    </p>

                </div>


                <div class="flex flex-wrap gap-2">


                    <a
                        href="{{ route('admin.teachers.edit', $teacher) }}"
                        class="inline-flex items-center
                               justify-center
                               gap-2
                               px-5 py-2.5
                               rounded-xl
                               bg-blue-600
                               text-white
                               font-semibold
                               hover:bg-blue-700
                               transition"
                    >

                        Edit Data Guru

                    </a>


                    <form
                        action="{{ route('admin.teachers.destroy', $teacher) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus data guru ini?')"
                    >

                        @csrf

                        @method('DELETE')


                        <button
                            type="submit"
                            class="inline-flex items-center
                                   justify-center
                                   gap-2
                                   px-5 py-2.5
                                   rounded-xl
                                   bg-red-50
                                   text-red-600
                                   border border-red-100
                                   font-semibold
                                   hover:bg-red-100
                                   transition"
                        >

                            Hapus Guru

                        </button>

                    </form>

                </div>

            </div>


        </section>

    </main>

</div>


</body>

</html>