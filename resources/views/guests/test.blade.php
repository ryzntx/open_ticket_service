<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sistem Tiket Pengaduan - Universitas Subang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="min-h-screen font-sans text-gray-800 bg-white">

    <!-- NAVBAR -->
    <nav class="fixed top-0 left-0 z-50 w-full bg-white border-b border-gray-200 shadow-sm">
        <div class="flex items-center justify-between max-w-6xl px-4 py-3 mx-auto">
            <!-- Logo & Title -->
            <div class="flex items-center gap-3">
                <svg viewBox="0 0 512 512" fill="#4F46E5" xmlns="http://www.w3.org/2000/svg" class="w-8 h-8">
                    <path
                        d="M256 0C114.624 0 0 114.624 0 256s114.624 256 256 256 256-114.624 256-256S397.376 0 256 0zm0 472c-119.296 0-216-96.704-216-216S136.704 40 256 40s216 96.704 216 216-96.704 216-216 216z" />
                    <path
                        d="M368 192h-64v-64c0-17.664-14.336-32-32-32s-32 14.336-32 32v64h-64c-17.664 0-32 14.336-32 32s14.336 32 32 32h64v64c0 17.664 14.336 32 32 32s32-14.336 32-32v-64h64c17.664 0 32-14.336 32-32s-14.336-32-32-32z" />
                </svg>
                <span class="text-lg font-bold text-gray-700">Tiket Pengaduan</span>
            </div>

            <!-- Menu -->
            <div class="flex gap-6 text-sm">
                <a href="#" class="transition hover:text-indigo-600">Beranda</a>
                <a href="#" class="transition hover:text-indigo-600">Buat Tiket</a>
                <a href="#" class="transition hover:text-indigo-600">Lacak</a>
                <a href="#" class="transition hover:text-indigo-600">Riwayat</a>
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <div class="flex flex-col items-center px-4 pt-24">

        <!-- HERO SECTION -->
        <header class="mb-16 text-center">
            <!-- SVG 3D White (Ikon Lingkaran Plus) -->
            <div class="mx-auto mb-6 w-28 h-28">
                <svg viewBox="0 0 512 512" fill="white" xmlns="http://www.w3.org/2000/svg" class="drop-shadow-lg">
                    <circle cx="256" cy="256" r="256" fill="#4F46E5" />
                    <path
                        d="M368 192h-64v-64c0-17.664-14.336-32-32-32s-32 14.336-32 32v64h-64c-17.664 0-32 14.336-32 32s14.336 32 32 32h64v64c0 17.664 14.336 32 32 32s32-14.336 32-32v-64h64c17.664 0 32-14.336 32-32s-14.336-32-32-32z"
                        fill="white" />
                </svg>
            </div>
            <h1 class="mb-2 text-4xl font-extrabold text-gray-800 md:text-5xl">
                Sistem Tiket Pengaduan
            </h1>
            <p class="max-w-xl mx-auto text-lg text-gray-500">
                Layanan pengaduan resmi Universitas Subang untuk mahasiswa, dosen, dan staf.
            </p>
        </header>

        <!-- MENU CARDS -->
        <main class="grid w-full max-w-5xl grid-cols-1 gap-8 md:grid-cols-3">
            <!-- Buat Tiket -->
            <div
                class="relative p-6 transition duration-300 transform bg-white border border-gray-200 shadow-md rounded-2xl hover:rotate-1 hover:-translate-y-2">
                <div
                    class="absolute flex items-center justify-center w-16 h-16 text-3xl -translate-x-1/2 bg-yellow-400 rounded-full shadow-md -top-8 left-1/2">
                    🐣
                </div>
                <h2 class="mt-8 mb-3 text-xl font-bold text-gray-800">Buat Tiket</h2>
                <p class="mb-4 text-sm text-gray-500">
                    Laporkan masalah Anda dengan cepat dan mudah.
                </p>
                <button
                    class="px-4 py-2 font-semibold text-white transition bg-indigo-500 shadow-md rounded-xl hover:bg-indigo-600">
                    + Buat Tiket
                </button>
            </div>

            <!-- Lacak Tiket -->
            <div
                class="relative p-6 transition duration-300 transform bg-white border border-gray-200 shadow-md rounded-2xl hover:-rotate-1 hover:-translate-y-2">
                <div
                    class="absolute flex items-center justify-center w-16 h-16 text-3xl -translate-x-1/2 bg-green-400 rounded-full shadow-md -top-8 left-1/2">
                    🐢
                </div>
                <h2 class="mt-8 mb-3 text-xl font-bold text-gray-800">Lacak Tiket</h2>
                <p class="mb-4 text-sm text-gray-500">
                    Pantau status tiket Anda kapan pun, di mana pun.
                </p>
                <button
                    class="px-4 py-2 font-semibold text-white transition bg-green-500 shadow-md rounded-xl hover:bg-green-600">
                    Lacak Sekarang
                </button>
            </div>

            <!-- Riwayat Tiket -->
            <div
                class="relative p-6 transition duration-300 transform bg-white border border-gray-200 shadow-md rounded-2xl hover:rotate-1 hover:-translate-y-2">
                <div
                    class="absolute flex items-center justify-center w-16 h-16 text-3xl -translate-x-1/2 bg-pink-400 rounded-full shadow-md -top-8 left-1/2">
                    🐼
                </div>
                <h2 class="mt-8 mb-3 text-xl font-bold text-gray-800">Riwayat Tiket</h2>
                <p class="mb-4 text-sm text-gray-500">
                    Lihat daftar semua tiket yang pernah Anda buat.
                </p>
                <button
                    class="px-4 py-2 font-semibold text-white transition bg-pink-500 shadow-md rounded-xl hover:bg-pink-600">
                    Lihat Riwayat
                </button>
            </div>
        </main>

        <!-- FOOTER -->
        <footer class="mt-16 text-xs text-gray-400">
            © 2025 Sistem Tiket Pengaduan - Universitas Subang
        </footer>
    </div>
</body>

</html>
