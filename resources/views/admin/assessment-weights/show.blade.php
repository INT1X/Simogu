<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Detail Bobot Penilaian - SIMOGU</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>

<body class="bg-slate-100">

    @include('components.admin-sidebar')

    <main class="lg:ml-64 min-h-screen">

        <header class="bg-white border-b border-slate-200 shadow-sm">

            <div class="px-4 sm:px-6 lg:px-8 py-5">

                <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">
                    Detail Bobot Penilaian
                </h1>

                <p class="text-sm text-slate-500 mt-1">
                    Informasi bobot kompetensi penilaian.
                </p>

            </div>

        </header>


        <section class="p-4 sm:p-6 lg:p-8">

            <div class="max-w-3xl">

                <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">

                    <div class="p-6">

                        <div class="mb-6">

                            <p class="text-sm text-slate-500">
                                Kompetensi
                            </p>

                            <p class="text-xl font-bold text-slate-800 mt-1">
                                {{ $assessmentWeight->competency }}
                            </p>

                        </div>


                        <div class="mb-6">

                            <p class="text-sm text-slate-500">
                                Bobot
                            </p>

                            <p class="text-2xl font-bold text-purple-600 mt-1">
                                {{ number_format((float) $assessmentWeight->weight, 2, ',', '.') }}%
                            </p>

                        </div>


                        <div class="mb-6">

                            <p class="text-sm text-slate-500 mb-2">
                                Status
                            </p>

                            @if ($assessmentWeight->is_active)

                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-700">
                                    Aktif
                                </span>

                            @else

                                <span class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-600">
                                    Nonaktif
                                </span>

                            @endif

                        </div>


                        <div class="flex flex-col sm:flex-row gap-3">

                            <a
                                href="{{ route('admin.assessment-weights.index') }}"
                                class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold"
                            >
                                Kembali
                            </a>

                            <a
                                href="{{ route('admin.assessment-weights.edit', $assessmentWeight) }}"
                                class="inline-flex items-center justify-center px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold"
                            >
                                Edit Bobot
                            </a>

                        </div>

                    </div>

                </div>

            </div>

        </section>

    </main>

</body>

</html>