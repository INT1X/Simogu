<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Detail Indikator - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-slate-100">

@include('components.admin-sidebar')

<main class="lg:ml-64 min-h-screen">

    <header class="bg-white border-b border-slate-200">

        <div class="px-4 sm:px-6 lg:px-8 py-5">

            <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">
                Detail Indikator
            </h1>

            <p class="text-sm text-slate-500 mt-1">
                Informasi indikator penilaian kinerja guru.
            </p>

        </div>

    </header>


    <section class="p-4 sm:p-6 lg:p-8">

        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm">

            <div class="p-5 sm:p-6">

                <dl class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>

                        <dt class="text-sm text-slate-500">
                            Kode
                        </dt>

                        <dd class="mt-1 font-bold text-slate-800">
                            {{ $assessmentIndicator->code }}
                        </dd>

                    </div>


                    <div>

                        <dt class="text-sm text-slate-500">
                            Kompetensi
                        </dt>

                        <dd class="mt-1 font-bold text-slate-800">
                            {{ $assessmentIndicator->competency }}
                        </dd>

                    </div>


                    <div class="md:col-span-2">

                        <dt class="text-sm text-slate-500">
                            Nama Indikator
                        </dt>

                        <dd class="mt-1 font-bold text-slate-800">
                            {{ $assessmentIndicator->name }}
                        </dd>

                    </div>


                    <div class="md:col-span-2">

                        <dt class="text-sm text-slate-500">
                            Deskripsi
                        </dt>

                        <dd class="mt-1 text-slate-700">
                            {{ $assessmentIndicator->description ?: '-' }}
                        </dd>

                    </div>


                    <div>

                        <dt class="text-sm text-slate-500">
                            Bobot
                        </dt>

                        <dd class="mt-1 font-bold text-slate-800">
                            {{ number_format($assessmentIndicator->weight, 2) }}%
                        </dd>

                    </div>


                    <div>

                        <dt class="text-sm text-slate-500">
                            Status
                        </dt>

                        <dd class="mt-1">

                            @if($assessmentIndicator->is_active)

                                <span class="inline-flex px-3 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-semibold">
                                    Aktif
                                </span>

                            @else

                                <span class="inline-flex px-3 py-1 rounded-full bg-slate-100 text-slate-600 text-xs font-semibold">
                                    Nonaktif
                                </span>

                            @endif

                        </dd>

                    </div>

                </dl>

            </div>


            <div class="px-5 sm:px-6 py-5 bg-slate-50 border-t border-slate-200 flex justify-end gap-3">

                <a
                    href="{{ route('admin.assessment-indicators.index') }}"
                    class="px-5 py-2.5 rounded-xl bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold"
                >
                    Kembali
                </a>

                <a
                    href="{{ route('admin.assessment-indicators.edit', $assessmentIndicator) }}"
                    class="px-5 py-2.5 rounded-xl bg-purple-600 hover:bg-purple-700 text-white font-semibold"
                >
                    Edit
                </a>

            </div>

        </div>

    </section>

</main>

</body>

</html>