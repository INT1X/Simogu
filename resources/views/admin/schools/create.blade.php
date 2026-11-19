<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Sekolah - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100">

    {{-- ============================================================= --}}
    {{-- SIDEBAR ADMIN --}}
    {{-- ============================================================= --}}

    @include('components.admin-sidebar')


    {{-- ============================================================= --}}
    {{-- MAIN CONTENT --}}
    {{-- ============================================================= --}}

    <main class="min-h-screen lg:ml-72">

        {{-- ========================================================= --}}
        {{-- HEADER --}}
        {{-- ========================================================= --}}

        <header class="bg-white border-b border-slate-200 shadow-sm">

            <div class="px-4 sm:px-6 lg:px-8 py-5 sm:py-6">

                {{-- 
                    pl-16 hanya untuk mobile.
                    Tujuannya memberikan ruang untuk tombol hamburger
                    yang berada di kiri atas dari sidebar.
                --}}
                <div class="pl-16 lg:pl-0">

                    <div class="flex flex-col sm:flex-row
                                sm:items-center
                                sm:justify-between
                                gap-4">

                        {{-- ================================================= --}}
                        {{-- JUDUL --}}
                        {{-- ================================================= --}}

                        <div class="min-w-0">

                            <div class="flex items-start gap-3">

                                <div class="w-1.5 h-10
                                            bg-emerald-500
                                            rounded-full
                                            shrink-0">
                                </div>

                                <div class="min-w-0">

                                    <h1 class="text-xl sm:text-2xl lg:text-3xl
                                               font-bold
                                               text-slate-800
                                               leading-tight">

                                        Tambah Sekolah

                                    </h1>

                                    <p class="text-sm text-slate-500 mt-1">

                                        Tambahkan data sekolah baru ke dalam
                                        sistem SIMOGU.

                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- ================================================= --}}
                        {{-- TOMBOL KEMBALI --}}
                        {{-- ================================================= --}}

                        <a
                            href="{{ route('admin.schools.index') }}"
                            class="inline-flex
                                   items-center
                                   justify-center
                                   gap-2
                                   px-5
                                   py-2.5
                                   rounded-xl
                                   bg-slate-100
                                   text-slate-700
                                   font-semibold
                                   hover:bg-slate-200
                                   transition
                                   shrink-0
                                   w-full sm:w-auto"
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

            </div>

        </header>


        {{-- ========================================================= --}}
        {{-- CONTENT --}}
        {{-- ========================================================= --}}

        <section class="p-4 sm:p-6 lg:p-8">

            <div class="max-w-5xl mx-auto">


                {{-- ================================================= --}}
                {{-- ERROR --}}
                {{-- ================================================= --}}

                @if ($errors->any())

                    <div class="mb-6
                                rounded-2xl
                                bg-red-50
                                border border-red-200
                                p-5">

                        <div class="flex items-start gap-3">

                            <div class="w-10 h-10
                                        shrink-0
                                        rounded-xl
                                        bg-red-100
                                        flex items-center justify-center">

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


                            <div class="min-w-0">

                                <p class="font-bold text-red-700">

                                    Terdapat kesalahan pada form

                                </p>

                                <ul class="list-disc
                                           list-inside
                                           text-sm
                                           text-red-600
                                           mt-2
                                           space-y-1">

                                    @foreach ($errors->all() as $error)

                                        <li>
                                            {{ $error }}
                                        </li>

                                    @endforeach

                                </ul>

                            </div>

                        </div>

                    </div>

                @endif


                {{-- ================================================= --}}
                {{-- FORM CARD --}}
                {{-- ================================================= --}}

                <div class="bg-white
                            rounded-3xl
                            border border-slate-200
                            shadow-sm
                            overflow-hidden">


                    {{-- ================================================= --}}
                    {{-- CARD HEADER --}}
                    {{-- ================================================= --}}

                    <div class="px-5 sm:px-6 lg:px-8
                                py-5 sm:py-6
                                border-b border-slate-200
                                bg-gradient-to-r
                                from-emerald-50
                                via-white
                                to-white">

                        <div class="flex items-center gap-4">

                            <div class="w-12 h-12
                                        rounded-2xl
                                        bg-emerald-100
                                        flex items-center justify-center
                                        shrink-0">

                                <svg
                                    class="w-6 h-6 text-emerald-600"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >

                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-8h6v8"
                                    />

                                </svg>

                            </div>


                            <div class="min-w-0">

                                <h2 class="text-lg font-bold text-slate-800">

                                    Informasi Sekolah

                                </h2>

                                <p class="text-sm text-slate-500 mt-0.5">

                                    Lengkapi informasi sekolah yang akan
                                    ditambahkan ke sistem.

                                </p>

                            </div>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- FORM --}}
                    {{-- ================================================= --}}

                    <form
                        action="{{ route('admin.schools.store') }}"
                        method="POST"
                        class="p-5 sm:p-6 lg:p-8"
                    >

                        @csrf


                        {{-- ================================================= --}}
                        {{-- DATA SEKOLAH --}}
                        {{-- ================================================= --}}

                        <div class="mb-8">

                            {{-- Section title --}}
                            <div class="flex items-center gap-2 mb-5">

                                <div class="w-1.5 h-6
                                            bg-emerald-500
                                            rounded-full">
                                </div>

                                <h3 class="font-bold text-slate-800">

                                    Data Sekolah

                                </h3>

                            </div>


                            {{-- ================================================= --}}
                            {{-- GRID --}}
                            {{-- ================================================= --}}

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">


                                {{-- ================================================= --}}
                                {{-- NAMA SEKOLAH --}}
                                {{-- ================================================= --}}

                                <div class="md:col-span-2">

                                    <label
                                        for="name"
                                        class="block text-sm
                                               font-semibold
                                               text-slate-700
                                               mb-2"
                                    >

                                        Nama Sekolah

                                        <span class="text-red-500">
                                            *
                                        </span>

                                    </label>


                                    <input
                                        type="text"
                                        id="name"
                                        name="name"
                                        value="{{ old('name') }}"
                                        required
                                        autocomplete="organization"
                                        placeholder="Contoh: SMP Negeri 1 Tondano"
                                        class="w-full
                                               rounded-xl
                                               border-slate-300
                                               bg-white
                                               px-4
                                               py-3
                                               text-slate-800
                                               placeholder-slate-400
                                               focus:border-blue-500
                                               focus:ring-blue-500"
                                    >

                                </div>


                                {{-- ================================================= --}}
                                {{-- NPSN --}}
                                {{-- ================================================= --}}

                                <div>

                                    <label
                                        for="npsn"
                                        class="block text-sm
                                               font-semibold
                                               text-slate-700
                                               mb-2"
                                    >

                                        NPSN

                                        <span class="text-red-500">
                                            *
                                        </span>

                                    </label>


                                    <input
                                        type="text"
                                        id="npsn"
                                        name="npsn"
                                        value="{{ old('npsn') }}"
                                        required
                                        inputmode="numeric"
                                        placeholder="Masukkan NPSN"
                                        class="w-full
                                               rounded-xl
                                               border-slate-300
                                               bg-white
                                               px-4
                                               py-3
                                               text-slate-800
                                               placeholder-slate-400
                                               focus:border-blue-500
                                               focus:ring-blue-500"
                                    >

                                </div>


                                {{-- ================================================= --}}
                                {{-- TELEPON --}}
                                {{-- ================================================= --}}

                                <div>

                                    <label
                                        for="phone"
                                        class="block text-sm
                                               font-semibold
                                               text-slate-700
                                               mb-2"
                                    >

                                        No. Telepon

                                    </label>


                                    <input
                                        type="text"
                                        id="phone"
                                        name="phone"
                                        value="{{ old('phone') }}"
                                        inputmode="tel"
                                        placeholder="Contoh: 0431-123456"
                                        class="w-full
                                               rounded-xl
                                               border-slate-300
                                               bg-white
                                               px-4
                                               py-3
                                               text-slate-800
                                               placeholder-slate-400
                                               focus:border-blue-500
                                               focus:ring-blue-500"
                                    >

                                </div>


                                {{-- ================================================= --}}
                                {{-- EMAIL --}}
                                {{-- ================================================= --}}

                                <div class="md:col-span-2">

                                    <label
                                        for="email"
                                        class="block text-sm
                                               font-semibold
                                               text-slate-700
                                               mb-2"
                                    >

                                        Email Sekolah

                                    </label>


                                    <input
                                        type="email"
                                        id="email"
                                        name="email"
                                        value="{{ old('email') }}"
                                        autocomplete="email"
                                        placeholder="Contoh: sekolah@example.com"
                                        class="w-full
                                               rounded-xl
                                               border-slate-300
                                               bg-white
                                               px-4
                                               py-3
                                               text-slate-800
                                               placeholder-slate-400
                                               focus:border-blue-500
                                               focus:ring-blue-500"
                                    >

                                </div>


                                {{-- ================================================= --}}
                                {{-- ALAMAT --}}
                                {{-- ================================================= --}}

                                <div class="md:col-span-2">

                                    <label
                                        for="address"
                                        class="block text-sm
                                               font-semibold
                                               text-slate-700
                                               mb-2"
                                    >

                                        Alamat Sekolah

                                    </label>


                                    <textarea
                                        id="address"
                                        name="address"
                                        rows="4"
                                        placeholder="Masukkan alamat lengkap sekolah"
                                        class="w-full
                                               rounded-xl
                                               border-slate-300
                                               bg-white
                                               px-4
                                               py-3
                                               text-slate-800
                                               placeholder-slate-400
                                               resize-y
                                               focus:border-blue-500
                                               focus:ring-blue-500"
                                    >{{ old('address') }}</textarea>

                                </div>

                            </div>

                        </div>


                        {{-- ================================================= --}}
                        {{-- ACTION BUTTON --}}
                        {{-- ================================================= --}}

                        <div class="flex flex-col-reverse
                                    sm:flex-row
                                    sm:justify-end
                                    gap-3
                                    pt-6
                                    border-t border-slate-200">


                            {{-- BATAL --}}
                            <a
                                href="{{ route('admin.schools.index') }}"
                                class="inline-flex
                                       items-center
                                       justify-center
                                       gap-2
                                       px-6
                                       py-3
                                       rounded-xl
                                       bg-slate-100
                                       text-slate-700
                                       font-semibold
                                       hover:bg-slate-200
                                       transition
                                       w-full sm:w-auto"
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
                                        d="M6 18L18 6M6 6l12 12"
                                    />

                                </svg>

                                Batal

                            </a>


                            {{-- SIMPAN --}}
                            <button
                                type="submit"
                                class="inline-flex
                                       items-center
                                       justify-center
                                       gap-2
                                       px-7
                                       py-3
                                       rounded-xl
                                       bg-emerald-600
                                       text-white
                                       font-semibold
                                       shadow-sm
                                       hover:bg-emerald-700
                                       hover:shadow-md
                                       active:scale-[0.98]
                                       transition
                                       w-full sm:w-auto"
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
                                        d="M5 13l4 4L19 7"
                                    />

                                </svg>

                                Simpan Sekolah

                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </section>

    </main>

</body>

</html>