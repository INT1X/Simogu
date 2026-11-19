<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Bobot Penilaian - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100">

    @include('components.admin-sidebar')

    <main class="lg:ml-64 min-h-screen">

        {{-- HEADER --}}
        <header class="bg-white border-b border-slate-200 shadow-sm">

            <div class="px-4 sm:px-6 lg:px-8 py-5">

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                    <div class="flex items-center gap-3">

                        <div class="w-2 h-8 bg-purple-600 rounded-full"></div>

                        <div>

                            <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">
                                Bobot Penilaian
                            </h1>

                            <p class="text-sm text-slate-500 mt-1">
                                Kelola bobot penilaian kinerja guru.
                            </p>

                        </div>

                    </div>

                    <div class="text-left sm:text-right">

                        <p class="font-semibold text-slate-800">
                            {{ auth()->user()->name }}
                        </p>

                        <p class="text-sm text-emerald-600 mt-1">
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

                <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 px-5 py-4 text-emerald-700">

                    {{ session('success') }}

                </div>

            @endif


            {{-- ERROR --}}
            @if ($errors->any())

                <div class="mb-6 rounded-xl bg-red-50 border border-red-200 px-5 py-4 text-red-700">

                    <p class="font-semibold mb-2">
                        Terdapat kesalahan:
                    </p>

                    <ul class="list-disc list-inside text-sm">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

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

                            <h2 class="text-lg font-bold text-slate-800">
                                Daftar Bobot
                            </h2>

                            <p class="text-sm text-slate-500 mt-1">
                                Atur bobot berdasarkan kompetensi penilaian.
                            </p>

                        </div>


                        <a
                            href="{{ route('admin.assessment-weights.create') }}"
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

                            Tambah Bobot

                        </a>

                    </div>

                </div>


                {{-- TABLE --}}
                <div class="overflow-x-auto">

                    <table class="w-full">

                        <thead class="bg-slate-50 border-b border-slate-200">

                            <tr>

                                <th class="px-5 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                    No
                                </th>

                                <th class="px-5 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                    Kompetensi
                                </th>

                                <th class="px-5 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                    Bobot
                                </th>

                                <th class="px-5 py-4 text-left text-xs font-bold uppercase text-slate-500">
                                    Status
                                </th>

                                <th class="px-5 py-4 text-right text-xs font-bold uppercase text-slate-500">
                                    Aksi
                                </th>

                            </tr>

                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            @forelse ($weights as $weight)

                                <tr class="hover:bg-slate-50">

                                    <td class="px-5 py-4 text-sm text-slate-600">
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="px-5 py-4">

                                        <p class="font-semibold text-slate-800">
                                            {{ $weight->competency }}
                                        </p>

                                    </td>

                                    <td class="px-5 py-4">

                                        <span class="font-bold text-purple-600">
                                            {{ number_format((float) $weight->weight, 2, ',', '.') }}%
                                        </span>

                                    </td>

                                    <td class="px-5 py-4">

                                        @if ($weight->is_active)

                                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                                Aktif
                                            </span>

                                        @else

                                            <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                                                Nonaktif
                                            </span>

                                        @endif

                                    </td>

                                    <td class="px-5 py-4">

                                        <div class="flex justify-end items-center gap-2">

                                            <a
                                                href="{{ route('admin.assessment-weights.show', $weight) }}"
                                                class="px-3 py-2 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 text-sm font-semibold"
                                            >
                                                Lihat
                                            </a>

                                            <a
                                                href="{{ route('admin.assessment-weights.edit', $weight) }}"
                                                class="px-3 py-2 rounded-lg bg-blue-100 hover:bg-blue-200 text-blue-700 text-sm font-semibold"
                                            >
                                                Edit
                                            </a>

                                            <form
                                                method="POST"
                                                action="{{ route('admin.assessment-weights.destroy', $weight) }}"
                                                onsubmit="return confirm('Yakin ingin menghapus bobot ini?')"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="px-3 py-2 rounded-lg bg-red-100 hover:bg-red-200 text-red-700 text-sm font-semibold"
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
                                        class="px-5 py-12 text-center"
                                    >

                                        <p class="font-semibold text-slate-600">
                                            Belum ada data bobot penilaian.
                                        </p>

                                        <p class="text-sm text-slate-400 mt-1">
                                            Silakan tambahkan bobot penilaian.
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