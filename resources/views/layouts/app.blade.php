<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'UPMD Inventory')</title>
    <link rel="icon" href="{{ asset('img/logo.png') }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 flex flex-col min-h-screen font-sans antialiased text-gray-800">

    <nav class="bg-gradient-to-r from-[#003d79] to-[#002855] text-white shadow-xl sticky top-0 z-50 backdrop-blur-md bg-opacity-95">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-20">
                
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo" class="h-12 w-auto object-contain transition-transform duration-300 group-hover:scale-110 drop-shadow-md">
                        <div class="flex flex-col">
                            <span class="font-bold text-xl leading-none tracking-wide text-white group-hover:text-[#f1c40f] transition-colors duration-300">
                                UPMD <span class="text-[#f1c40f] group-hover:text-white transition-colors duration-300">FILKOM</span>
                            </span>
                            <span class="text-[10px] text-gray-300 uppercase tracking-[0.2em] mt-1 font-medium hidden sm:block">Inventory System</span>
                        </div>
                    </a>
                </div>

                <div class="hidden md:flex items-center space-x-2 bg-white/10 p-1.5 rounded-full border border-white/10 backdrop-blur-sm">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-5 py-2 rounded-full text-sm font-bold transition-all duration-300 transform {{ request()->routeIs('dashboard') ? 'bg-white text-[#003d79] shadow-lg scale-105' : 'text-gray-200 hover:text-white hover:bg-white/10' }}">
                            Dashboard
                        </a>
                    @endauth
                    
                    <a href="{{ route('loans.catalog') }}" class="px-5 py-2 rounded-full text-sm font-bold transition-all duration-300 transform {{ request()->routeIs('loans.catalog') ? 'bg-white text-[#003d79] shadow-lg scale-105' : 'text-gray-200 hover:text-white hover:bg-white/10' }}">
                        Katalog
                    </a>
                    
                    @auth
                        @if(Auth::user()->role === 'admin' || Auth::user()->role === 'superadmin')
                            <a href="{{ route('items.index') }}" class="px-5 py-2 rounded-full text-sm font-bold transition-all duration-300 transform {{ request()->routeIs('items.*') ? 'bg-white text-[#003d79] shadow-lg scale-105' : 'text-gray-200 hover:text-white hover:bg-white/10' }}">
                                Kelola Alat
                            </a>

                            <a href="{{ route('users.index') }}" class="px-5 py-2 rounded-full text-sm font-bold transition-all duration-300 transform {{ request()->routeIs('users.*') ? 'bg-white text-[#003d79] shadow-lg scale-105' : 'text-gray-200 hover:text-white hover:bg-white/10' }}">
                                Kelola User
                            </a>
                        @endif
                    @endauth
                </div>

                <div class="hidden md:flex items-center gap-4">
                    @auth
                        <div class="flex flex-col text-right">
                            <span class="text-[10px] text-gray-300 uppercase tracking-wider">Login sebagai</span>
                            <span class="text-sm font-bold text-white leading-tight">{{ explode(' ', Auth::user()->name)[0] }}</span>
                        </div>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="group relative flex items-center justify-center w-10 h-10 bg-red-500/80 hover:bg-red-600 rounded-full transition-all duration-300 shadow-lg hover:shadow-red-500/50 overflow-hidden" title="Logout">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white transition-transform duration-300 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    @else
                        <a href="{{ route('login.google') }}" class="bg-white text-[#003d79] px-6 py-2.5 rounded-full text-sm font-bold shadow-lg hover:shadow-xl hover:bg-gray-100 hover:-translate-y-0.5 transition-all duration-300 flex items-center gap-2">
                            <svg class="w-4 h-4" viewBox="0 0 24 24"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/></svg>
                            Login SSO
                        </a>
                    @endauth
                </div>

                <div class="flex items-center md:hidden">
                    <button onclick="toggleMenu()" class="text-white hover:text-[#f1c40f] focus:outline-none p-2 transition-colors">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden bg-[#002855] border-t border-white/10 shadow-inner">
            <div class="px-4 pt-4 pb-6 space-y-3">
                @auth
                    <div class="flex items-center gap-3 pb-4 mb-4 border-b border-white/10">
                        <div class="w-10 h-10 bg-white/10 rounded-full flex items-center justify-center text-xl">👤</div>
                        <div>
                            <p class="font-bold text-white">{{ Auth::user()->name }}</p>
                            <p class="text-xs text-[#f1c40f] uppercase tracking-wide">{{ Auth::user()->role }}</p>
                        </div>
                    </div>
                    
                    <a href="{{ route('dashboard') }}" class="block px-4 py-3 rounded-xl font-medium transition-all {{ request()->routeIs('dashboard') ? 'bg-white text-[#003d79] shadow-lg' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                        Dashboard
                    </a>
                @endauth

                <a href="{{ route('loans.catalog') }}" class="block px-4 py-3 rounded-xl font-medium transition-all {{ request()->routeIs('loans.catalog') ? 'bg-white text-[#003d79] shadow-lg' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                    Katalog Alat
                </a>

                @auth
                    @if(Auth::user()->role === 'admin' || Auth::user()->role === 'superadmin')
                        <a href="{{ route('items.index') }}" class="block px-4 py-3 rounded-xl font-medium transition-all {{ request()->routeIs('items.*') ? 'bg-white text-[#003d79] shadow-lg' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                            Kelola Alat
                        </a>
                        
                        <a href="{{ route('users.index') }}" class="block px-4 py-3 rounded-xl font-medium transition-all {{ request()->routeIs('users.*') ? 'bg-white text-[#003d79] shadow-lg' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                            Kelola User
                        </a>
                    @endif

                    <form action="{{ route('logout') }}" method="POST" class="mt-6 pt-6 border-t border-white/10">
                        @csrf
                        <button type="submit" class="w-full text-center block px-4 py-3 rounded-xl font-bold bg-red-600 hover:bg-red-700 text-white shadow-lg transition-transform active:scale-95">
                            Logout Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login.google') }}" class="block w-full text-center px-4 py-3 mt-4 rounded-xl font-bold bg-white text-[#003d79] shadow-lg">
                        Login SSO UB
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="flex-grow p-4 md:p-8 animate-fade-in-up">
        @if(session('success'))
            <div class="max-w-7xl mx-auto mb-6 bg-green-50 border-l-4 border-green-500 text-green-800 p-4 shadow-sm rounded-r flex items-center gap-3">
                <span class="text-xl">✅</span>
                <div>
                    <p class="font-bold">Berhasil!</p>
                    <p class="text-sm">{{ session('success') }}</p>
                </div>
            </div>
        @endif
        
        @if(session('error'))
            <div class="max-w-7xl mx-auto mb-6 bg-red-50 border-l-4 border-red-500 text-red-800 p-4 shadow-sm rounded-r flex items-center gap-3">
                <span class="text-xl">⚠️</span>
                <div>
                    <p class="font-bold">Terjadi Kesalahan!</p>
                    <p class="text-sm">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="bg-white border-t mt-auto py-8">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <img src="{{ asset('img/logo.png') }}" alt="Logo Footer" class="h-8 w-auto mx-auto mb-3 opacity-50 grayscale hover:grayscale-0 transition-all duration-500">
            <p class="text-sm text-gray-500 font-medium">
                &copy; {{ date('Y') }} Unit Pengembangan Media Digital (UPMD)
            </p>
            <p class="text-xs text-gray-400 mt-1">
                Fakultas Ilmu Komputer - Universitas Brawijaya
            </p>
        </div>
    </footer>

    <script>
        function toggleMenu() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        }
    </script>
</body>
</html>