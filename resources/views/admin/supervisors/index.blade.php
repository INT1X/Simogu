<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Data Pengawas - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="bg-slate-100 min-h-screen">


    {{-- ========================================================= --}}
    {{-- SIDEBAR ADMIN --}}
    {{-- ========================================================= --}}

    @include('components.admin-sidebar')


    {{-- ========================================================= --}}
    {{-- MAIN CONTENT --}}
    {{-- ========================================================= --}}

    <main class="lg:ml-64 min-h-screen w-auto">


        {{-- ===================================================== --}}
        {{-- HEADER --}}
        {{-- ===================================================== --}}

        <header class="bg-white border-b border-slate-200 shadow-sm">

            <div class="w-full px-4 sm:px-6 lg:px-8 py-5">

                <div
                    class="flex flex-col
                           sm:flex-row
                           sm:items-center
                           sm:justify-between
                           gap-4"
                >


                    {{-- ================================================= --}}
                    {{-- TITLE --}}
                    {{-- ================================================= --}}

                    <div class="flex items-start gap-3 min-w-0">


                        {{-- Ruang untuk tombol hamburger sidebar mobile --}}

                        <div class="w-10 shrink-0 lg:hidden"></div>


                        <div class="min-w-0">

                            <div class="flex items-center gap-3">

                                <div
                                    class="w-2 h-8
                                           bg-purple-600
                                           rounded-full
                                           shrink-0"
                                ></div>


                                <div class="min-w-0">

                                    <h1
                                        class="text-2xl
                                               sm:text-3xl
                                               font-bold
                                               text-slate-800"
                                    >

                                        Data Pengawas

                                    </h1>


                                    <p
                                        class="text-sm
                                               sm:text-base
                                               text-slate-500
                                               mt-1"
                                    >

                                        Kelola data pengawas sekolah pada sistem SIMOGU.

                                    </p>

                                </div>

                            </div>

                        </div>

                    </div>


                    {{-- ================================================= --}}
                    {{-- USER --}}
                    {{-- ================================================= --}}

                    <div
                        class="text-left
                               sm:text-right
                               ml-12
                               sm:ml-0
                               shrink-0"
                    >

                        <p
                            class="font-semibold
                                   text-slate-800
                                   truncate
                                   max-w-[220px]
                                   sm:max-w-none"
                        >

                            {{ auth()->user()->name }}

                        </p>


                        <div
                            class="inline-flex
                                   items-center
                                   gap-1
                                   mt-1"
                        >

                            <span
                                class="w-2 h-2
                                       rounded-full
                                       bg-emerald-500"
                            ></span>


                            <p
                                class="text-sm
                                       text-emerald-600"
                            >

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

        <section
            class="w-full
                   p-4
                   sm:p-6
                   lg:p-8"
        >


            {{-- ================================================= --}}
            {{-- SUCCESS MESSAGE --}}
            {{-- ================================================= --}}

            @if(session('success'))

                <div
                    class="mb-6
                           flex items-start gap-3
                           rounded-2xl
                           bg-emerald-50
                           border border-emerald-200
                           text-emerald-800
                           px-5 py-4
                           shadow-sm"
                >

                    <div
                        class="w-9 h-9
                               rounded-xl
                               bg-emerald-100
                               flex items-center
                               justify-center
                               shrink-0"
                    >

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


                    <div class="min-w-0">

                        <p class="font-semibold">

                            Berhasil

                        </p>


                        <p class="text-sm text-emerald-700 mt-1">

                            {{ session('success') }}

                        </p>

                    </div>

                </div>

            @endif


            {{-- ================================================= --}}
            {{-- PAGE HEADER --}}
            {{-- ================================================= --}}

            <div
                class="flex flex-col
                       lg:flex-row
                       lg:items-center
                       lg:justify-between
                       gap-5
                       mb-6"
            >


                {{-- ================================================= --}}
                {{-- TITLE --}}
                {{-- ================================================= --}}

                <div class="min-w-0">

                    <div class="flex items-center gap-3">

                        <div
                            class="w-11 h-11
                                   rounded-xl
                                   bg-purple-100
                                   flex items-center
                                   justify-center
                                   shrink-0"
                        >

                            <svg
                                class="w-6 h-6 text-purple-600"
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


                        <div class="min-w-0">

                            <h2
                                class="text-xl
                                       sm:text-2xl
                                       font-bold
                                       text-slate-800"
                            >

                                Daftar Pengawas

                            </h2>


                            <p
                                class="text-sm
                                       text-slate-500
                                       mt-1"
                            >

                                Kelola seluruh data pengawas yang terdaftar dalam sistem.

                            </p>

                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- BUTTON TAMBAH --}}
                {{-- ================================================= --}}

                <a
                    href="{{ route('admin.supervisors.create') }}"
                    class="w-full
                           lg:w-auto
                           inline-flex
                           items-center
                           justify-center
                           gap-2
                           px-5
                           py-3
                           rounded-xl
                           bg-purple-600
                           text-white
                           font-semibold
                           shadow-sm
                           hover:bg-purple-700
                           hover:shadow-md
                           hover:-translate-y-0.5
                           transition
                           duration-200"
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


                    Tambah Pengawas

                </a>

            </div>


            {{-- ================================================= --}}
            {{-- TABLE CARD --}}
            {{-- ================================================= --}}

            <div
                class="bg-white
                       rounded-2xl
                       border border-slate-200
                       shadow-sm
                       overflow-hidden"
            >


                {{-- ================================================= --}}
                {{-- TABLE HEADER --}}
                {{-- ================================================= --}}

                <div
                    class="px-5
                           sm:px-6
                           py-5
                           border-b
                           border-slate-200"
                >

                    <div
                        class="flex flex-col
                               sm:flex-row
                               sm:items-center
                               sm:justify-between
                               gap-3"
                    >


                        <div class="min-w-0">

                            <h3
                                class="font-bold
                                       text-slate-800"
                            >

                                Data Pengawas

                            </h3>


                            <p
                                class="text-xs
                                       sm:text-sm
                                       text-slate-500
                                       mt-1"
                            >

                                Informasi pengawas yang tersimpan dalam SIMOGU.

                            </p>

                        </div>


                        <div
                            class="inline-flex
                                   items-center
                                   gap-2
                                   text-sm
                                   text-slate-500
                                   shrink-0"
                        >

                            <span
                                class="w-2 h-2
                                       rounded-full
                                       bg-emerald-500"
                            ></span>

                            Data aktif

                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- TABLE --}}
                {{-- ================================================= --}}

                <div class="overflow-x-auto">

                    <table
                        class="w-full
                               min-w-[1050px]"
                    >


                        {{-- ================================================= --}}
                        {{-- THEAD --}}
                        {{-- ================================================= --}}

                        <thead
                            class="bg-slate-50
                                   border-b
                                   border-slate-200"
                        >

                            <tr>


                                {{-- PENGAWAS --}}

                                <th
                                    class="px-6
                                           py-4
                                           text-left
                                           text-xs
                                           font-bold
                                           uppercase
                                           tracking-wider
                                           text-slate-500"
                                >

                                    Pengawas

                                </th>


                                {{-- NIP --}}

                                <th
                                    class="px-6
                                           py-4
                                           text-left
                                           text-xs
                                           font-bold
                                           uppercase
                                           tracking-wider
                                           text-slate-500"
                                >

                                    NIP

                                </th>


                                {{-- SEKOLAH --}}

                                <th
                                    class="px-6
                                           py-4
                                           text-left
                                           text-xs
                                           font-bold
                                           uppercase
                                           tracking-wider
                                           text-slate-500"
                                >

                                    Sekolah

                                </th>


                                {{-- KONTAK --}}

                                <th
                                    class="px-6
                                           py-4
                                           text-left
                                           text-xs
                                           font-bold
                                           uppercase
                                           tracking-wider
                                           text-slate-500"
                                >

                                    Kontak

                                </th>


                                {{-- STATUS --}}

                                <th
                                    class="px-6
                                           py-4
                                           text-left
                                           text-xs
                                           font-bold
                                           uppercase
                                           tracking-wider
                                           text-slate-500"
                                >

                                    Status

                                </th>


                                {{-- AKSI --}}

                                <th
                                    class="px-6
                                           py-4
                                           text-right
                                           text-xs
                                           font-bold
                                           uppercase
                                           tracking-wider
                                           text-slate-500"
                                >

                                    Aksi

                                </th>

                            </tr>

                        </thead>


                        {{-- ================================================= --}}
                        {{-- TBODY --}}
                        {{-- ================================================= --}}

                        <tbody
                            class="divide-y
                                   divide-slate-100"
                        >


                            @forelse($supervisors as $supervisor)


                                <tr
                                    class="group
                                           hover:bg-purple-50/40
                                           transition
                                           duration-150"
                                >


                                    {{-- ================================================= --}}
                                    {{-- PENGAWAS --}}
                                    {{-- ================================================= --}}

                                    <td
                                        class="px-6
                                               py-4"
                                    >

                                        <div class="flex items-center gap-3">


                                            {{-- FOTO --}}

                                            @if($supervisor->photo)

                                                <img
                                                    src="{{ asset('storage/' . $supervisor->photo) }}"
                                                    alt="{{ $supervisor->name }}"
                                                    class="w-11 h-11
                                                           rounded-xl
                                                           object-cover
                                                           border
                                                           border-slate-200
                                                           shrink-0"
                                                >

                                            @else

                                                <div
                                                    class="w-11 h-11
                                                           rounded-xl
                                                           bg-purple-100
                                                           text-purple-600
                                                           flex items-center
                                                           justify-center
                                                           font-bold
                                                           shrink-0"
                                                >

                                                    {{ strtoupper(substr($supervisor->name, 0, 1)) }}

                                                </div>

                                            @endif


                                            <div class="min-w-0">

                                                <p
                                                    class="font-semibold
                                                           text-slate-800
                                                           truncate
                                                           max-w-[230px]"
                                                >

                                                    {{ $supervisor->name }}

                                                </p>


                                                <p
                                                    class="text-xs
                                                           text-slate-400
                                                           mt-0.5"
                                                >

                                                    Pengawas Sekolah

                                                </p>

                                            </div>

                                        </div>

                                    </td>


                                    {{-- ================================================= --}}
                                    {{-- NIP --}}
                                    {{-- ================================================= --}}

                                    <td
                                        class="px-6
                                               py-4
                                               text-sm
                                               font-medium
                                               text-slate-600"
                                    >

                                        {{ $supervisor->nip ?: '-' }}

                                    </td>


                                    {{-- ================================================= --}}
                                    {{-- SEKOLAH --}}
                                    {{-- ================================================= --}}

                                    <td
                                        class="px-6
                                               py-4
                                               text-sm
                                               text-slate-600"
                                    >

                                        <div class="flex items-center gap-2">

                                            <svg
                                                class="w-4 h-4 text-emerald-500 shrink-0"
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


                                            <span>

                                                {{ $supervisor->school?->name ?? '-' }}

                                            </span>

                                        </div>

                                    </td>


                                    {{-- ================================================= --}}
                                    {{-- KONTAK --}}
                                    {{-- ================================================= --}}

                                    <td
                                        class="px-6
                                               py-4"
                                    >

                                        <div class="space-y-1">

                                            <p
                                                class="text-sm
                                                       text-slate-700"
                                            >

                                                {{ $supervisor->phone ?: '-' }}

                                            </p>


                                            <p
                                                class="text-xs
                                                       text-slate-400
                                                       truncate
                                                       max-w-[220px]"
                                            >

                                                {{ $supervisor->email ?: '-' }}

                                            </p>

                                        </div>

                                    </td>


                                    {{-- ================================================= --}}
                                    {{-- STATUS --}}
                                    {{-- ================================================= --}}

                                    <td
                                        class="px-6
                                               py-4"
                                    >

                                        @if($supervisor->status === 'aktif')

                                            <span
                                                class="inline-flex
                                                       items-center
                                                       gap-1.5
                                                       px-3
                                                       py-1.5
                                                       rounded-full
                                                       text-xs
                                                       font-semibold
                                                       bg-emerald-100
                                                       text-emerald-700"
                                            >

                                                <span
                                                    class="w-1.5 h-1.5
                                                           rounded-full
                                                           bg-emerald-500"
                                                ></span>

                                                Aktif

                                            </span>

                                        @else

                                            <span
                                                class="inline-flex
                                                       items-center
                                                       gap-1.5
                                                       px-3
                                                       py-1.5
                                                       rounded-full
                                                       text-xs
                                                       font-semibold
                                                       bg-red-100
                                                       text-red-700"
                                            >

                                                <span
                                                    class="w-1.5 h-1.5
                                                           rounded-full
                                                           bg-red-500"
                                                ></span>

                                                Nonaktif

                                            </span>

                                        @endif

                                    </td>


                                    {{-- ================================================= --}}
                                    {{-- AKSI --}}
                                    {{-- ================================================= --}}

                                    <td
                                        class="px-6
                                               py-4"
                                    >

                                        <div
                                            class="flex
                                                   items-center
                                                   justify-end
                                                   gap-2"
                                        >


                                            {{-- LIHAT --}}

                                            <a
                                                href="{{ route('admin.supervisors.show', $supervisor) }}"
                                                title="Lihat data pengawas"
                                                class="w-9 h-9
                                                       rounded-lg
                                                       bg-slate-100
                                                       text-slate-600
                                                       flex
                                                       items-center
                                                       justify-center
                                                       hover:bg-slate-200
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
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                                    />

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                                    />

                                                </svg>

                                            </a>


                                            {{-- EDIT --}}

                                            <a
                                                href="{{ route('admin.supervisors.edit', $supervisor) }}"
                                                title="Edit data pengawas"
                                                class="w-9 h-9
                                                       rounded-lg
                                                       bg-blue-50
                                                       text-blue-600
                                                       flex
                                                       items-center
                                                       justify-center
                                                       hover:bg-blue-100
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
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"
                                                    />

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"
                                                    />

                                                </svg>

                                            </a>


                                            {{-- HAPUS --}}

                                            <form
                                                method="POST"
                                                action="{{ route('admin.supervisors.destroy', $supervisor) }}"
                                                onsubmit="return confirm('Yakin ingin menghapus data pengawas ini?')"
                                            >

                                                @csrf

                                                @method('DELETE')


                                                <button
                                                    type="submit"
                                                    title="Hapus data pengawas"
                                                    class="w-9 h-9
                                                           rounded-lg
                                                           bg-red-50
                                                           text-red-600
                                                           flex
                                                           items-center
                                                           justify-center
                                                           hover:bg-red-100
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
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                                                        />

                                                    </svg>

                                                </button>

                                            </form>

                                        </div>

                                    </td>

                                </tr>


                            @empty


                                {{-- ================================================= --}}
                                {{-- DATA KOSONG --}}
                                {{-- ================================================= --}}

                                <tr>

                                    <td
                                        colspan="6"
                                        class="px-6
                                               py-16
                                               text-center"
                                    >

                                        <div
                                            class="flex
                                                   flex-col
                                                   items-center
                                                   justify-center"
                                        >

                                            <div
                                                class="w-16 h-16
                                                       rounded-2xl
                                                       bg-slate-100
                                                       flex items-center
                                                       justify-center
                                                       mb-4"
                                            >

                                                <svg
                                                    class="w-8 h-8
                                                           text-slate-400"
                                                    fill="none"
                                                    stroke="currentColor"
                                                    viewBox="0 0 24 24"
                                                >

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="1.5"
                                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                                                    />

                                                </svg>

                                            </div>


                                            <h3
                                                class="font-semibold
                                                       text-slate-700"
                                            >

                                                Belum Ada Data Pengawas

                                            </h3>


                                            <p
                                                class="text-sm
                                                       text-slate-500
                                                       mt-1"
                                            >

                                                Silakan tambahkan data pengawas terlebih dahulu.

                                            </p>


                                            <a
                                                href="{{ route('admin.supervisors.create') }}"
                                                class="mt-4
                                                       inline-flex
                                                       items-center
                                                       gap-2
                                                       px-4
                                                       py-2.5
                                                       rounded-xl
                                                       bg-purple-600
                                                       text-white
                                                       text-sm
                                                       font-semibold
                                                       hover:bg-purple-700
                                                       transition"
                                            >

                                                <svg
                                                    class="w-4 h-4"
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

                                                Tambah Pengawas

                                            </a>

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

                @if($supervisors->hasPages())

                    <div
                        class="px-5
                               sm:px-6
                               py-5
                               border-t
                               border-slate-200
                               bg-slate-50"
                    >

                        <div
                            class="overflow-x-auto"
                        >

                            {{ $supervisors->links() }}

                        </div>

                    </div>

                @endif


            </div>


        </section>


    </main>


</body>

</html>