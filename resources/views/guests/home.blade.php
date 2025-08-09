<x-guest-layout>
    <!-- HERO SECTION -->
    <header class="relative mb-16 text-center">
        <!-- SVG 3D Object -->
        <div
            class="relative w-40 h-40 mx-auto mb-6 transition duration-300 transform hover:-rotate-10 hover:-translate-y-2">
            <svg viewBox="0 0 300 300" xmlns="http://www.w3.org/2000/svg" class="drop-shadow-xl">
                <!-- Shadow Layer -->
                <ellipse cx="150" cy="250" rx="80" ry="20" fill="rgba(0,0,0,0.1)" />
                <!-- Body -->
                <circle cx="150" cy="140" r="80" fill="white" stroke="#E5E7EB" stroke-width="4" />
                <!-- Eyes -->
                <circle cx="125" cy="130" r="10" fill="#4F46E5" />
                <circle cx="175" cy="130" r="10" fill="#4F46E5" />
                <!-- Smile -->
                <path d="M120 160 Q150 190 180 160" stroke="#4F46E5" stroke-width="5" fill="none"
                    stroke-linecap="round" />
                <!-- 3D Ticket (on top) -->
                <rect x="130" y="70" width="40" height="25" rx="4" fill="#4F46E5" stroke="white"
                    stroke-width="3" transform="rotate(-10 150 82)" />
            </svg>
        </div>
        <h1
            class="mb-2 text-4xl font-extrabold transition transform duration-400 text-base-800 md:text-5xl hover:rotate-10 hover:-translate-y-2">
            {{ __('Open Support Ticket Service') }}
        </h1>
        <p class="max-w-xl mx-auto text-lg text-base-500 ">
            {{ __('Official support service of Universitas Subang for students, lecturers, and staff.') }}
        </p>
    </header>

    <!-- MENU CARDS -->
    <main class="grid w-full max-w-5xl grid-cols-1 gap-8 md:grid-cols-2">
        <!-- Buat Tiket -->
        <div
            class="relative p-6 transition duration-300 transform border shadow-md bg-base border-base-200 rounded-2xl hover:rotate-1 hover:-translate-y-2">
            <div
                class="absolute flex items-center justify-center w-16 h-16 text-3xl -translate-x-1/2 bg-yellow-400 rounded-full shadow-md -top-8 left-1/2">
                🐣
            </div>
            <h2 class="mt-8 mb-3 text-xl font-bold text-base-800">{{ __('Open Ticket') }}</h2>
            <p class="mb-4 text-sm text-base-500">
                {{ __('Report your issue quickly and easily.') }}
            </p>
            <a href="{{ route('ticket.create') }}"
                class="px-4 py-2 text-base font-semibold transition bg-indigo-500 shadow-md rounded-xl hover:bg-indigo-600">
                + {{ __('Create Ticket') }}
            </a>
        </div>

        <!-- Lacak Tiket -->
        <div
            class="relative p-6 transition duration-300 transform border shadow-md bg-base border-base-200 rounded-2xl hover:-rotate-1 hover:-translate-y-2">
            <div
                class="absolute flex items-center justify-center w-16 h-16 text-3xl -translate-x-1/2 bg-green-400 rounded-full shadow-md -top-8 left-1/2">
                🐢
            </div>
            <h2 class="mt-8 mb-3 text-xl font-bold text-base-800">{{ __('Track Ticket') }}</h2>
            <p class="mb-4 text-sm text-base-500">
                {{ __('Track your ticket status anytime, anywhere.') }}
            </p>
            <a href="{{ route('ticket.status.form') }}"
                class="px-4 py-2 text-base font-semibold transition bg-green-500 shadow-md rounded-xl hover:bg-green-600">
                {{ __('Track Ticket') }}
            </a>
        </div>

        <!-- Riwayat Tiket -->
        {{-- <div
            class="relative p-6 transition duration-300 transform border shadow-md bg-base border-base-200 rounded-2xl hover:rotate-1 hover:-translate-y-2">
            <div
                class="absolute flex items-center justify-center w-16 h-16 text-3xl -translate-x-1/2 bg-pink-400 rounded-full shadow-md -top-8 left-1/2">
                🐼
            </div>
            <h2 class="mt-8 mb-3 text-xl font-bold text-base-800">Riwayat Tiket</h2>
            <p class="mb-4 text-sm text-base-500">
                Lihat daftar semua tiket yang pernah Anda buat.
            </p>
            <button
                class="px-4 py-2 text-base font-semibold transition bg-pink-500 shadow-md rounded-xl hover:bg-pink-600">
                Lihat Riwayat
            </button>
        </div> --}}
    </main>

</x-guest-layout>
