<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Sekolah - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100">

    <div class="min-h-screen">

        {{-- ========================================================= --}}
        {{-- SIDEBAR ADMIN --}}
        {{-- ========================================================= --}}

        @include('components.admin-sidebar')


        {{-- ========================================================= --}}
        {{-- MAIN CONTENT --}}
        {{-- ========================================================= --}}

        <main class="lg:ml-64 min-h-screen">

            {{-- ===================================================== --}}
            {{-- HEADER --}}
            {{-- ===================================================== --}}

            <header class="bg-white border-b border-slate-200 shadow-sm">

                <div class="w-full px-4 sm:px-6 lg:px-8 xl:px-10 py-5">

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                        {{-- JUDUL --}}

                        <div>

                            <div class="flex items-center gap-3">

                                <div class="w-1.5 h-10 bg-blue-600 rounded-full shrink-0"></div>

                                <div>

                                    <h1 class="text-2xl font-bold text-slate-800">
                                        Data Sekolah
                                    </h1>

                                    <p class="text-sm text-slate-500 mt-1">
                                        Kelola data sekolah pada sistem SIMOGU.
                                    </p>

                                </div>

                            </div>

                        </div>


                        {{-- USER --}}

                        <div class="text-left sm:text-right">

                            <p class="font-semibold text-slate-800">
                                {{ auth()->user()->name }}
                            </p>

                            <div class="inline-flex items-center gap-1 mt-1">

                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>

                                <p class="text-sm text-emerald-600">
                                    Administrator
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

            </header>


            {{-- ===================================================== --}}
            {{-- CONTENT --}}
            {{-- ===================================================== --}}

            <section class="w-full px-4 sm:px-6 lg:px-8 xl:px-10 py-6">


                {{-- ================================================= --}}
                {{-- SUCCESS MESSAGE --}}
                {{-- ================================================= --}}

                @if(session('success'))

                    <div
                        class="mb-6 rounded-xl
                        bg-green-50
                        border border-green-200
                        text-green-700
                        px-4 py-3
                        shadow-sm"
                    >

                        <div class="flex items-center gap-3">

                            <svg
                                class="w-5 h-5 shrink-0"
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

                            <span>
                                {{ session('success') }}
                            </span>

                        </div>

                    </div>

                @endif


                {{-- ================================================= --}}
                {{-- HEADER CONTENT --}}
                {{-- ================================================= --}}

                <div
                    class="flex flex-col
                    sm:flex-row
                    sm:items-center
                    sm:justify-between
                    gap-4
                    mb-6"
                >

                    <div>

                        <h2 class="text-xl font-bold text-slate-800">
                            Daftar Sekolah
                        </h2>

                        <p class="text-sm text-slate-500 mt-1">
                            Daftar sekolah yang terdaftar dalam sistem.
                        </p>

                    </div>


                    {{-- TAMBAH SEKOLAH --}}

                    <a
                        href="{{ route('admin.schools.create') }}"
                        class="inline-flex
                        items-center
                        justify-center
                        gap-2
                        px-5 py-3
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
                                d="M12 4v16m8-8H4"
                            />

                        </svg>

                        Tambah Sekolah

                    </a>

                </div>


                {{-- ================================================= --}}
                {{-- TABLE CARD --}}
                {{-- ================================================= --}}

                <div
                    class="w-full
                    bg-white
                    rounded-2xl
                    border border-slate-200
                    shadow-sm
                    overflow-hidden"
                >


                    {{-- ================================================= --}}
                    {{-- TABLE --}}
                    {{-- ================================================= --}}

                    <div class="w-full overflow-x-auto">

                        <table class="w-full min-w-[900px]">

                            {{-- ================================================= --}}
                            {{-- HEADER TABLE --}}
                            {{-- ================================================= --}}

                            <thead class="bg-slate-50 border-b border-slate-200">

                                <tr>

                                    <th
                                        class="px-5 lg:px-6 py-4
                                        text-left
                                        text-sm
                                        font-semibold
                                        text-slate-600
                                        whitespace-nowrap"
                                    >
                                        No
                                    </th>


                                    <th
                                        class="px-5 lg:px-6 py-4
                                        text-left
                                        text-sm
                                        font-semibold
                                        text-slate-600
                                        whitespace-nowrap"
                                    >
                                        Nama Sekolah
                                    </th>


                                    <th
                                        class="px-5 lg:px-6 py-4
                                        text-left
                                        text-sm
                                        font-semibold
                                        text-slate-600
                                        whitespace-nowrap"
                                    >
                                        NPSN
                                    </th>


                                    <th
                                        class="px-5 lg:px-6 py-4
                                        text-left
                                        text-sm
                                        font-semibold
                                        text-slate-600
                                        whitespace-nowrap"
                                    >
                                        Alamat
                                    </th>


                                    <th
                                        class="px-5 lg:px-6 py-4
                                        text-left
                                        text-sm
                                        font-semibold
                                        text-slate-600
                                        whitespace-nowrap"
                                    >
                                        Aksi
                                    </th>

                                </tr>

                            </thead>


                            {{-- ================================================= --}}
                            {{-- BODY TABLE --}}
                            {{-- ================================================= --}}

                            <tbody class="divide-y divide-slate-100">

                                @forelse($schools as $school)

                                    <tr
                                        class="hover:bg-slate-50
                                        transition"
                                    >

                                        {{-- NO --}}

                                        <td
                                            class="px-5 lg:px-6 py-4
                                            text-sm
                                            text-slate-600
                                            whitespace-nowrap"
                                        >

                                            {{ $schools->firstItem() + $loop->index }}

                                        </td>


                                        {{-- NAMA SEKOLAH --}}

                                        <td
                                            class="px-5 lg:px-6 py-4
                                            font-semibold
                                            text-slate-800
                                            whitespace-nowrap"
                                        >

                                            {{ $school->name }}

                                        </td>


                                        {{-- NPSN --}}

                                        <td
                                            class="px-5 lg:px-6 py-4
                                            text-sm
                                            text-slate-600
                                            whitespace-nowrap"
                                        >

                                            {{ $school->npsn ?? '-' }}

                                        </td>


                                        {{-- ALAMAT --}}

                                        <td
                                            class="px-5 lg:px-6 py-4
                                            text-sm
                                            text-slate-600"
                                        >

                                            <div class="max-w-xl">

                                                {{ $school->address ?? '-' }}

                                            </div>

                                        </td>


                                        {{-- AKSI --}}

                                        <td class="px-5 lg:px-6 py-4">

                                            <div class="flex items-center gap-2">

                                                {{-- LIHAT --}}

                                                <a
                                                    href="{{ route('admin.schools.show', $school) }}"
                                                    class="inline-flex
                                                    items-center
                                                    justify-center
                                                    px-3 py-2
                                                    rounded-lg
                                                    bg-blue-100
                                                    text-blue-700
                                                    text-sm
                                                    font-semibold
                                                    hover:bg-blue-200
                                                    transition"
                                                >

                                                    Lihat

                                                </a>


                                                {{-- EDIT --}}

                                                <a
                                                    href="{{ route('admin.schools.edit', $school) }}"
                                                    class="inline-flex
                                                    items-center
                                                    justify-center
                                                    px-3 py-2
                                                    rounded-lg
                                                    bg-amber-100
                                                    text-amber-700
                                                    text-sm
                                                    font-semibold
                                                    hover:bg-amber-200
                                                    transition"
                                                >

                                                    Edit

                                                </a>


                                                {{-- HAPUS --}}

                                                <form
                                                    action="{{ route('admin.schools.destroy', $school) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus sekolah ini?')"
                                                >

                                                    @csrf

                                                    @method('DELETE')

                                                    <button
                                                        type="submit"
                                                        class="inline-flex
                                                        items-center
                                                        justify-center
                                                        px-3 py-2
                                                        rounded-lg
                                                        bg-red-100
                                                        text-red-700
                                                        text-sm
                                                        font-semibold
                                                        hover:bg-red-200
                                                        transition"
                                                    >

                                                        Hapus

                                                    </button>

                                                </form>

                                            </div>

                                        </td>

                                    </tr>


                                @empty

                                    <tr>

                                        <td
                                            colspan="5"
                                            class="px-6 py-12
                                            text-center
                                            text-slate-500"
                                        >

                                            <div class="flex flex-col items-center">

                                                <div
                                                    class="w-14 h-14
                                                    rounded-2xl
                                                    bg-slate-100
                                                    flex items-center
                                                    justify-center
                                                    mb-3"
                                                >

                                                    <svg
                                                        class="w-7 h-7 text-slate-400"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        viewBox="0 0 24 24"
                                                    >

                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            stroke-width="1.5"
                                                            d="M3 21h18M5 21V7l7-4 7 4v14M9 21v-8h6v8"
                                                        />

                                                    </svg>

                                                </div>

                                                <p class="font-semibold text-slate-600">
                                                    Belum ada data sekolah.
                                                </p>

                                                <p class="text-sm text-slate-400 mt-1">
                                                    Silakan tambahkan data sekolah terlebih dahulu.
                                                </p>

                                            </div>

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>


                    {{-- ================================================= --}}
                    {{-- PAGINATION --}}
                    {{-- ================================================= --}}

                    @if($schools->hasPages())

                        <div
                            class="px-5 py-4
                            border-t border-slate-200
                            bg-white"
                        >

                            {{ $schools->links() }}

                        </div>

                    @endif

                </div>

            </section>

        </main>

    </div>

</body>

</html>