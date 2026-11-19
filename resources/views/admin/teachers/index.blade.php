<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Data Guru - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>


<body class="bg-slate-100">


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

                    <div class="flex items-start gap-3">


                        {{-- Ruang hamburger pada mobile --}}

                        <div class="w-10 shrink-0 lg:hidden"></div>


                        <div>

                            <div class="flex items-center gap-2">

                                <div
                                    class="w-2 h-8
                                           bg-blue-600
                                           rounded-full"
                                ></div>


                                <div>

                                    <h2
                                        class="text-2xl
                                               font-bold
                                               text-slate-800"
                                    >

                                        Data Guru

                                    </h2>


                                    <p
                                        class="text-slate-500
                                               mt-1"
                                    >

                                        Kelola data guru pada sistem SIMOGU.

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
                               sm:ml-0"
                    >

                        <p
                            class="font-semibold
                                   text-slate-800"
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


                    <div>

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


                {{-- TITLE --}}

                <div>

                    <div class="flex items-center gap-3">

                        <div
                            class="w-11 h-11
                                   rounded-xl
                                   bg-blue-100
                                   flex items-center
                                   justify-center"
                        >

                            <svg
                                class="w-6 h-6 text-blue-600"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >

                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-4a4 4 0 100-8 4 4 0 000 8zm6 0a3 3 0 100-6 3 3 0 000 6z"
                                />

                            </svg>

                        </div>


                        <div>

                            <h3
                                class="text-xl
                                       sm:text-2xl
                                       font-bold
                                       text-slate-800"
                            >

                                Daftar Guru

                            </h3>


                            <p
                                class="text-sm
                                       text-slate-500
                                       mt-1"
                            >

                                Kelola seluruh data guru yang terdaftar dalam sistem.

                            </p>

                        </div>

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- BUTTON TAMBAH --}}
                {{-- ================================================= --}}

                <a
                    href="{{ route('admin.teachers.create') }}"
                    class="inline-flex
                           items-center
                           justify-center
                           gap-2
                           px-5
                           py-3
                           rounded-xl
                           bg-blue-600
                           text-white
                           font-semibold
                           shadow-sm
                           hover:bg-blue-700
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


                    Tambah Guru

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
                           border-slate-200
                           bg-white"
                >

                    <div
                        class="flex flex-col
                               sm:flex-row
                               sm:items-center
                               sm:justify-between
                               gap-3"
                    >

                        <div>

                            <h4
                                class="font-bold
                                       text-slate-800"
                            >

                                Data Guru

                            </h4>


                            <p
                                class="text-xs
                                       text-slate-500
                                       mt-1"
                            >

                                Informasi guru yang tersimpan dalam SIMOGU.

                            </p>

                        </div>


                        <div
                            class="inline-flex
                                   items-center
                                   gap-2
                                   text-sm
                                   text-slate-500"
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
                               min-w-[1000px]"
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

                                    No

                                </th>


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

                                    Nama Guru

                                </th>


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

                                    Mata Pelajaran

                                </th>


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


                            @forelse($teachers as $teacher)


                                <tr
                                    class="group
                                           hover:bg-blue-50/40
                                           transition
                                           duration-150"
                                >


                                    {{-- NO --}}

                                    <td
                                        class="px-6
                                               py-4
                                               text-sm
                                               text-slate-500"
                                    >

                                        {{ $teachers->firstItem() + $loop->index }}

                                    </td>


                                    {{-- NIP --}}

                                    <td
                                        class="px-6
                                               py-4
                                               text-sm
                                               font-medium
                                               text-slate-600"
                                    >

                                        {{ $teacher->nip ?: '-' }}

                                    </td>


                                    {{-- NAMA --}}

                                    <td
                                        class="px-6
                                               py-4"
                                    >

                                        <div class="flex items-center gap-3">


                                            {{-- Avatar --}}

                                            @if($teacher->photo)

                                                <img
                                                    src="{{ asset('storage/' . $teacher->photo) }}"
                                                    alt="{{ $teacher->name }}"
                                                    class="w-10 h-10
                                                           rounded-xl
                                                           object-cover
                                                           border
                                                           border-slate-200"
                                                >

                                            @else

                                                <div
                                                    class="w-10 h-10
                                                           rounded-xl
                                                           bg-blue-100
                                                           text-blue-600
                                                           flex items-center
                                                           justify-center
                                                           font-bold"
                                                >

                                                    {{ strtoupper(substr($teacher->name, 0, 1)) }}

                                                </div>

                                            @endif


                                            <div>

                                                <p
                                                    class="font-semibold
                                                           text-slate-800"
                                                >

                                                    {{ $teacher->name }}

                                                </p>


                                                @if($teacher->email)

                                                    <p
                                                        class="text-xs
                                                               text-slate-400
                                                               mt-0.5"
                                                    >

                                                        {{ $teacher->email }}

                                                    </p>

                                                @endif

                                            </div>

                                        </div>

                                    </td>


                                    {{-- SEKOLAH --}}

                                    <td
                                        class="px-6
                                               py-4
                                               text-sm
                                               text-slate-600"
                                    >

                                        <div class="flex items-center gap-2">

                                            <svg
                                                class="w-4 h-4
                                                       text-emerald-500"
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


                                            {{ $teacher->school->name ?? '-' }}

                                        </div>

                                    </td>


                                    {{-- MATA PELAJARAN --}}

                                    <td
                                        class="px-6
                                               py-4
                                               text-sm
                                               text-slate-600"
                                    >

                                        {{ $teacher->subject ?: '-' }}

                                    </td>


                                    {{-- STATUS --}}

                                    <td
                                        class="px-6
                                               py-4"
                                    >

                                        @if($teacher->status === 'aktif')

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
                                                   gap-2"
                                        >


                                            {{-- LIHAT --}}

                                            <a
                                                href="{{ route('admin.teachers.show', $teacher) }}"
                                                title="Lihat data guru"
                                                class="w-9 h-9
                                                       rounded-lg
                                                       bg-blue-50
                                                       text-blue-600
                                                       flex items-center
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
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                                                    />

                                                    <path
                                                        stroke-linecap="round"
                                                        stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                                                    />

                                                </svg>

                                            </a>


                                            {{-- EDIT --}}

                                            <a
                                                href="{{ route('admin.teachers.edit', $teacher) }}"
                                                title="Edit data guru"
                                                class="w-9 h-9
                                                       rounded-lg
                                                       bg-amber-50
                                                       text-amber-600
                                                       flex items-center
                                                       justify-center
                                                       hover:bg-amber-100
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
                                                action="{{ route('admin.teachers.destroy', $teacher) }}"
                                                method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus guru {{ $teacher->name }}?')"
                                            >

                                                @csrf

                                                @method('DELETE')


                                                <button
                                                    type="submit"
                                                    title="Hapus data guru"
                                                    class="w-9 h-9
                                                           rounded-lg
                                                           bg-red-50
                                                           text-red-600
                                                           flex items-center
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


                                <tr>

                                    <td
                                        colspan="7"
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
                                                        stroke-width="2"
                                                        d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-4a4 4 0 100-8 4 4 0 000 8z"
                                                    />

                                                </svg>

                                            </div>


                                            <h3
                                                class="font-semibold
                                                       text-slate-700"
                                            >

                                                Belum Ada Data Guru

                                            </h3>


                                            <p
                                                class="text-sm
                                                       text-slate-500
                                                       mt-1"
                                            >

                                                Silakan tambahkan data guru terlebih dahulu.

                                            </p>


                                            <a
                                                href="{{ route('admin.teachers.create') }}"
                                                class="mt-4
                                                       inline-flex
                                                       items-center
                                                       gap-2
                                                       px-4
                                                       py-2
                                                       rounded-lg
                                                       bg-blue-600
                                                       text-white
                                                       text-sm
                                                       font-semibold
                                                       hover:bg-blue-700
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

                                                Tambah Guru

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

                @if($teachers->hasPages())

                    <div
                        class="px-5
                               sm:px-6
                               py-4
                               border-t
                               border-slate-200
                               bg-slate-50"
                    >

                        <div
                            class="flex
                                   flex-col
                                   sm:flex-row
                                   sm:items-center
                                   sm:justify-between
                                   gap-3"
                        >

                            <p
                                class="text-sm
                                       text-slate-500"
                            >

                                Menampilkan

                                <span class="font-semibold text-slate-700">
                                    {{ $teachers->firstItem() }}
                                </span>

                                sampai

                                <span class="font-semibold text-slate-700">
                                    {{ $teachers->lastItem() }}
                                </span>

                                dari

                                <span class="font-semibold text-slate-700">
                                    {{ $teachers->total() }}
                                </span>

                                data guru

                            </p>


                            <div>

                                {{ $teachers->links() }}

                            </div>

                        </div>

                    </div>

                @endif


            </div>


        </section>


    </main>


</body>

</html>