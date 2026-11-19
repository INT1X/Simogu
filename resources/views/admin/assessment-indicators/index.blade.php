<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Indikator Penilaian - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100">

    @include('components.admin-sidebar')

    <main class="lg:ml-64 min-h-screen">

        <header class="bg-white border-b border-slate-200 shadow-sm">
            <div class="px-4 sm:px-6 lg:px-8 py-5">

                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                    <div class="flex items-center gap-3">

                        <div class="w-2 h-8 bg-purple-600 rounded-full"></div>

                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">
                                Indikator Penilaian
                            </h1>

                            <p class="text-sm text-slate-500 mt-1">
                                Kelola indikator penilaian kinerja guru.
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


        <section class="p-4 sm:p-6 lg:p-8">

            {{-- SUCCESS --}}

            @if(session('success'))

                <div class="mb-6 rounded-xl bg-emerald-50 border border-emerald-200 px-5 py-4 text-emerald-700">
                    {{ session('success') }}
                </div>

            @endif


            {{-- HEADER --}}

            <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

                <div class="px-5 sm:px-6 py-5 border-b border-slate-200">

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">

                        <div>

                            <h2 class="text-lg font-bold text-slate-800">
                                Daftar Indikator
                            </h2>

                            <p class="text-sm text-slate-500 mt-1">
                                Total {{ $indicators->total() }} indikator penilaian.
                            </p>

                        </div>

                        <a
                            href="{{ route('admin.assessment-indicators.create') }}"
                            class="inline-flex items-center justify-center gap-2
                                   px-5 py-2.5 rounded-xl
                                   bg-purple-600 hover:bg-purple-700
                                   text-white font-semibold transition"
                        >

                            <span class="text-lg">+</span>

                            Tambah Indikator

                        </a>

                    </div>

                </div>


                {{-- TABLE --}}

                <div class="overflow-x-auto">

                    <table class="w-full text-sm">

                        <thead class="bg-slate-50 border-b border-slate-200">

                            <tr>

                                <th class="px-5 py-4 text-left font-semibold text-slate-600">
                                    No
                                </th>

                                <th class="px-5 py-4 text-left font-semibold text-slate-600">
                                    Kode
                                </th>

                                <th class="px-5 py-4 text-left font-semibold text-slate-600">
                                    Kompetensi
                                </th>

                                <th class="px-5 py-4 text-left font-semibold text-slate-600">
                                    Indikator
                                </th>

                                <th class="px-5 py-4 text-left font-semibold text-slate-600">
                                    Bobot
                                </th>

                                <th class="px-5 py-4 text-center font-semibold text-slate-600">
                                    Status
                                </th>

                                <th class="px-5 py-4 text-center font-semibold text-slate-600">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody class="divide-y divide-slate-100">

                            @forelse($indicators as $indicator)

                                <tr class="hover:bg-slate-50 transition">

                                    <td class="px-5 py-4 text-slate-600">
                                        {{ $indicators->firstItem() + $loop->index }}
                                    </td>

                                    <td class="px-5 py-4">

                                        <span class="font-semibold text-purple-600">
                                            {{ $indicator->code }}
                                        </span>

                                    </td>

                                    <td class="px-5 py-4 text-slate-700">
                                        {{ $indicator->competency }}
                                    </td>

                                    <td class="px-5 py-4">

                                        <p class="font-semibold text-slate-800">
                                            {{ $indicator->name }}
                                        </p>

                                        @if($indicator->description)

                                            <p class="text-xs text-slate-500 mt-1">
                                                {{ $indicator->description }}
                                            </p>

                                        @endif

                                    </td>

                                    <td class="px-5 py-4">

                                        <span class="font-semibold text-slate-700">
                                            {{ number_format((float) $indicator->weight, 2) }}%
                                        </span>

                                    </td>

                                    <td class="px-5 py-4 text-center">

                                        @if($indicator->is_active)

                                            <span class="inline-flex px-3 py-1 rounded-full
                                                         bg-emerald-100 text-emerald-700
                                                         text-xs font-semibold">
                                                Aktif
                                            </span>

                                        @else

                                            <span class="inline-flex px-3 py-1 rounded-full
                                                         bg-slate-100 text-slate-600
                                                         text-xs font-semibold">
                                                Nonaktif
                                            </span>

                                        @endif

                                    </td>

                                    <td class="px-5 py-4">

                                        <div class="flex items-center justify-center gap-2">

                                            <a
                                                href="{{ route('admin.assessment-indicators.edit', $indicator) }}"
                                                class="px-3 py-2 rounded-lg
                                                       bg-amber-100 text-amber-700
                                                       hover:bg-amber-200
                                                       text-xs font-semibold transition"
                                            >
                                                Edit
                                            </a>


                                            <form
                                                method="POST"
                                                action="{{ route('admin.assessment-indicators.destroy', $indicator) }}"
                                                onsubmit="return confirm('Yakin ingin menghapus indikator ini?')"
                                            >

                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    type="submit"
                                                    class="px-3 py-2 rounded-lg
                                                           bg-red-100 text-red-700
                                                           hover:bg-red-200
                                                           text-xs font-semibold transition"
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
                                        colspan="7"
                                        class="px-5 py-10 text-center text-slate-500"
                                    >
                                        Belum ada indikator penilaian.
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- PAGINATION --}}

                @if($indicators->hasPages())

                    <div class="px-5 sm:px-6 py-5 border-t border-slate-200">

                        {{ $indicators->links() }}

                    </div>

                @endif

            </div>

        </section>

    </main>

</body>

</html>