<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Support Portal') — Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100 font-sans">

<div class="flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    <aside class="w-64 bg-gray-900 text-white flex flex-col flex-shrink-0">
        <div class="px-6 py-5 border-b border-gray-700">
            <h1 class="text-xl font-bold text-white">Support Portal</h1>
            <p class="text-xs text-gray-400 mt-0.5">Admin Panel</p>
        </div>

        <nav class="flex-1 px-4 py-4 space-y-1 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                Dashboard
            </a>

            <a href="{{ route('admin.tickets.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.tickets.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                </svg>
                All Tickets
            </a>

            <a href="{{ route('admin.tickets.index', ['status' => 'open']) }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Open Tickets
            </a>

            <a href="{{ route('admin.tickets.index', ['status' => 'resolved']) }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Resolved
            </a>

            <a href="{{ route('admin.systems.index') }}"
               class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ request()->routeIs('admin.systems.*') ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                </svg>
                Systems
            </a>
        </nav>

        <div class="px-4 py-4 border-t border-gray-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center gap-3 w-full px-3 py-2 rounded-lg text-sm font-medium text-gray-300 hover:bg-gray-800 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Top Bar --}}
        <header class="bg-white border-b border-gray-200 px-6 py-4 flex items-center justify-between flex-shrink-0">
            <h2 class="text-xl font-semibold text-gray-800">@yield('page-title', 'Dashboard')</h2>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-600">{{ auth()->user()->name ?? 'Admin' }}</span>
            </div>
        </header>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div id="flash-success" class="mx-6 mt-4 px-4 py-3 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm flex items-center justify-between">
                <span>{{ session('success') }}</span>
                <button onclick="document.getElementById('flash-success').remove()" class="text-green-600 hover:text-green-800 ml-4">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div id="flash-error" class="mx-6 mt-4 px-4 py-3 bg-red-50 border border-red-200 text-red-800 rounded-lg text-sm flex items-center justify-between">
                <span>{{ session('error') }}</span>
                <button onclick="document.getElementById('flash-error').remove()" class="text-red-600 hover:text-red-800 ml-4">&times;</button>
            </div>
        @endif

        @if(session('api_key'))
            <div id="flash-apikey" class="mx-6 mt-4 px-4 py-3 bg-amber-50 border border-amber-300 text-amber-900 rounded-lg text-sm">
                <p class="font-semibold mb-1">⚠️ Save your API Key — it will not be shown again:</p>
                <div class="flex items-center gap-3 mt-2">
                    <code id="api-key-value" class="font-mono bg-amber-100 px-3 py-1.5 rounded text-sm flex-1 break-all">{{ session('api_key') }}</code>
                    <button onclick="navigator.clipboard.writeText(document.getElementById('api-key-value').textContent); this.textContent='Copied!';"
                            class="px-3 py-1.5 bg-amber-600 text-white rounded text-xs font-medium hover:bg-amber-700 whitespace-nowrap">
                        Copy
                    </button>
                </div>
            </div>
        @endif

        {{-- Page Content --}}
        <main class="flex-1 overflow-y-auto p-6">
            @yield('content')
        </main>
    </div>
</div>

<script>
    // Auto-dismiss flash messages after 3 seconds
    setTimeout(function () {
        ['flash-success', 'flash-error'].forEach(function (id) {
            var el = document.getElementById(id);
            if (el) el.remove();
        });
    }, 3000);
</script>

</body>
</html>
