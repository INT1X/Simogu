<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Jenis Dokumen - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-slate-100">

    @include('components.admin-sidebar')


    <main class="lg:ml-64 min-h-screen">

        {{-- HEADER --}}
        <header class="bg-white border-b border-slate-200 shadow-sm">

            <div class="px-4 sm:px-6 lg:px-8 py-6">

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                    <div>

                        <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">
                            Jenis Dokumen
                        </h1>

                        <p class="text-sm text-slate-500 mt-1">
                            Kelola jenis dokumen yang dapat diunggah oleh guru.
                        </p>

                    </div>

                    <div class="text-left sm:text-right">

                        <p class="font-semibold text-slate-800">
                            {{ auth()->user()->name }}
                        </p>

                        <p class="text-sm text-emerald-600">
                            Administrator
                        </p>

                    </div>

                </div>

            </div>

        </header>


        {{-- CONTENT --}}
        <section class="p-4 sm:p-6 lg:p-8">


            {{-- SUCCESS --}}
            @if (session('success'))

                <div class="mb-6 rounded-2xl bg-emerald-50 border border-emerald-200 px-5 py-4">

                    <div class="flex items-center gap-3">

                        <div class="w-9 h-9 rounded-xl bg-emerald-100 flex items-center justify-center">

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

                        <p class="font-semibold text-emerald-700">
                            {{ session('success') }}
                        </p>

                    </div>

                </div>

            @endif


            {{-- ERROR --}}
            @if ($errors->any())

                <div class="mb-6 rounded-2xl bg-red-50 border border-red-200 px-5 py-4">

                    <p class="font-semibold text-red-700">
                        Terdapat kesalahan:
                    </p>

                    <ul class="mt-2 list-disc list-inside text-sm text-red-600">

                        @foreach ($errors->all() as $error)

                            <li>
                                {{ $error }}
                            </li>

                        @endforeach

                    </ul>

                </div>

            @endif


            {{-- CARD --}}
            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">


                {{-- CARD HEADER --}}
                <div class="px-5 sm:px-6 py-5 border-b border-slate-200">

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                        <div>

                            <h2 class="font-bold text-slate-800 text-lg">
                                Daftar Jenis Dokumen
                            </h2>

                            <p class="text-sm text-slate-500 mt-1">
                                Atur dokumen yang dapat menjadi bukti pendukung kinerja guru.
                            </p>

                        </div>


                        <a
                            href="{{ route('admin.document-types.create') }}"
                            class="inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-semibold transition"
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

                            Tambah Dokumen

                        </a>

                    </div>

                </div>


                {{-- TABLE --}}
                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead class="bg-slate-50">

                            <tr>

                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">
                                    No
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">
                                    Nama Dokumen
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-bold text-slate-500 uppercase">
                                    Deskripsi
                                </th>

                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase">
                                    Nilai Maksimal
                                </th>

                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase">
                                    Status
                                </th>

                                <th class="px-6 py-4 text-center text-xs font-bold text-slate-500 uppercase">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-slate-200">

                            @forelse ($documentTypes as $documentType)

                                <tr class="hover:bg-slate-50 transition">

                                    <td class="px-6 py-4 text-sm text-slate-600">
                                        {{ $loop->iteration }}
                                    </td>


                                    <td class="px-6 py-4">

                                        <p class="font-semibold text-slate-800">
                                            {{ $documentType->name }}
                                        </p>

                                    </td>


                                    <td class="px-6 py-4">

                                        <p class="text-sm text-slate-500 max-w-md">
                                            {{ $documentType->description ?: '-' }}
                                        </p>

                                    </td>


                                    <td class="px-6 py-4 text-center">

                                        <span class="font-bold text-slate-700">

                                            {{ number_format((float) $documentType->max_score, 2) }}

                                        </span>

                                    </td>


                                    <td class="px-6 py-4 text-center">

                                        @if ($documentType->is_active)

                                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">
                                                Aktif
                                            </span>

                                        @else

                                            <span class="inline-flex items-center px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-bold">
                                                Nonaktif
                                            </span>

                                        @endif

                                    </td>


                                    <td class="px-6 py-4">

                                        <div class="flex items-center justify-center gap-2">

                                            <a
                                                href="{{ route('admin.document-types.edit', $documentType) }}"
                                                class="inline-flex items-center px-3 py-2 rounded-lg bg-blue-100 hover:bg-blue-200 text-blue-700 text-sm font-semibold"
                                            >
                                                Edit
                                            </a>


                                            <form
                                                method="POST"
                                                action="{{ route('admin.document-types.destroy', $documentType) }}"
                                                onsubmit="return confirm('Yakin ingin menghapus jenis dokumen ini?')"
                                            >

                                                @csrf

                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="inline-flex items-center px-3 py-2 rounded-lg bg-red-100 hover:bg-red-200 text-red-700 text-sm font-semibold"
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
                                        colspan="6"
                                        class="px-6 py-12 text-center"
                                    >

                                        <p class="font-semibold text-slate-700">
                                            Belum ada jenis dokumen.
                                        </p>

                                        <p class="text-sm text-slate-500 mt-1">
                                            Silakan tambahkan jenis dokumen terlebih dahulu.
                                        </p>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </section>

    </main>

</body>

</html>