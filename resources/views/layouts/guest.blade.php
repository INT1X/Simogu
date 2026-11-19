

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIMOGU') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-slate-100 font-sans antialiased">

    <main class="relative flex min-h-screen items-center justify-center overflow-hidden bg-gradient-to-br from-slate-950 via-blue-950 to-blue-800 px-5 py-10">

        {{-- Background Decoration --}}
        <div class="pointer-events-none absolute -left-32 -top-32 h-96 w-96 rounded-full bg-blue-400/20 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-40 -right-20 h-[500px] w-[500px] rounded-full bg-cyan-400/20 blur-3xl"></div>

        <div class="pointer-events-none absolute inset-0 opacity-[0.07]"
             style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 28px 28px;">
        </div>

        {{-- Main Container --}}
        <div class="relative z-10 w-full max-w-6xl overflow-hidden rounded-3xl border border-white/20 bg-white shadow-2xl lg:grid lg:grid-cols-2">

            {{-- Left Section --}}
            <section class="relative flex min-h-[300px] flex-col justify-between overflow-hidden bg-gradient-to-br from-blue-950 via-blue-900 to-blue-700 p-10 text-white sm:p-14 lg:min-h-[620px]">

                <div class="pointer-events-none absolute -right-24 -top-24 h-80 w-80 rounded-full border-[45px] border-white/5"></div>
                <div class="pointer-events-none absolute -bottom-32 -left-20 h-80 w-80 rounded-full border-[55px] border-cyan-300/10"></div>

                <div class="relative z-10">
                    <div class="mb-10 flex h-16 w-16 items-center justify-center rounded-2xl border border-white/20 bg-white/10 text-3xl font-extrabold shadow-xl backdrop-blur">
                        S
                    </div>

                    <p class="text-sm font-semibold uppercase tracking-[0.3em] text-cyan-300">
                        Sistem Informasi
                    </p>

                    <h1 class="mt-4 text-4xl font-extrabold tracking-tight sm:text-5xl">
                        SIMOGU
                    </h1>

                    <div class="mt-6 h-1.5 w-20 rounded-full bg-cyan-400"></div>

                    <p class="mt-7 max-w-md text-lg font-medium leading-relaxed text-blue-100">
                        Sistem Monitoring dan Evaluasi Guru
                    </p>

                    <p class="mt-4 max-w-md text-sm leading-7 text-blue-100/70">
                        Platform terintegrasi untuk mendukung pengelolaan,
                        pemantauan, dan evaluasi data pendidikan secara
                        efektif dan terstruktur.
                    </p>
                </div>

                <div class="relative z-10 mt-12 border-t border-white/15 pt-6">
                    <p class="text-xs text-blue-100/60">
                        &copy; {{ date('Y') }} SIMOGU. All rights reserved.
                    </p>
                </div>
            </section>

            {{-- Right Section --}}
            <section class="flex flex-col justify-center bg-white px-8 py-12 sm:px-14 lg:px-16">

                <div class="mb-9">
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-blue-600">
                        Authentication
                    </span>

                    <h2 class="mt-3 text-3xl font-extrabold tracking-tight text-slate-800">
                        Selamat Datang
                    </h2>

                    <p class="mt-3 text-sm leading-6 text-slate-500">
                        Silakan masuk menggunakan akun Anda untuk melanjutkan.
                    </p>
                </div>

                {{ $slot }}

            </section>
        </div>
    </main>

</body>
</html>

