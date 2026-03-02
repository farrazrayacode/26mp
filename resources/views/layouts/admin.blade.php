<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', '26 Motor Premium')</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50">

    {{-- TOP NAVBAR --}}
    <header class="fixed top-0 left-0 right-0 h-14 bg-white border-b border-gray-200 flex items-center justify-between px-6 z-30">
        {{-- Logo --}}
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <span class="font-bold text-gray-900 text-sm">26 Motor Premium</span>
        </div>

        {{-- User Info --}}
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
            </svg>
        </div>
    </header>

    {{-- SIDEBAR --}}
    <aside class="fixed top-14 left-0 h-[calc(100vh-3.5rem)] w-56 bg-white border-r border-gray-200 flex flex-col z-20">

        {{-- Menu Navigasi --}}
        <nav class="flex-1 px-3 py-4">

            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-2">Navigation</p>

            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium mb-0.5 transition
                {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('admin.gate-in.index') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium mb-0.5 transition
                {{ request()->routeIs('admin.gate-in.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                Gate In
            </a>

            <a href="{{ route('admin.work-order.index') }}"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium mb-0.5 transition
                {{ request()->routeIs('admin.work-order.*') ? 'bg-blue-50 text-blue-600' : 'text-gray-600 hover:bg-gray-50' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Work Order
            </a>

            <a href="#"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium mb-0.5 transition text-gray-600 hover:bg-gray-50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                Estimasi
            </a>

            <a href="#"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium mb-0.5 transition text-gray-600 hover:bg-gray-50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                Invoice
            </a>

            <a href="#"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium mb-0.5 transition text-gray-600 hover:bg-gray-50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
                Gate Out
            </a>

            <div class="border-t border-gray-100 my-3"></div>

            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-3 mb-2">Management</p>

            <a href="#"
                class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium mb-0.5 transition text-gray-600 hover:bg-gray-50">
</nav>

        {{-- Need Help Card --}}
        <div class="px-3 py-4">
            <div class="bg-blue-600 rounded-xl p-4 text-white relative overflow-hidden">
                <p class="text-sm font-semibold">Need Help?</p>
                <p class="text-xs text-blue-200 mt-0.5">Check our docs</p>
                <div class="absolute -bottom-2 -right-2 opacity-20">
                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
            </div>
        </div>

    </aside>

    {{-- MAIN CONTENT --}}
    <main class="ml-56 pt-14 min-h-screen bg-gray-50">
        <div class="p-8">
            @yield('content')
        </div>
    </main>

</body>
</html>