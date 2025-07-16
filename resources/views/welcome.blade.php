<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SuryaPOS | Aplikasi Kasir Warung</title>

    <!-- Tailwind CDN + darkMode: 'class' -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
        }
    </script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        html, body {
            font-family: 'Inter', sans-serif;
            transition: background 0.3s, color 0.3s;
        }
        .toggle-btn {
            position: absolute;
            top: 1rem;
            right: 1rem;
            font-size: 1.5rem;
            cursor: pointer;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col items-center justify-center px-6 bg-slate-100 text-slate-900 dark:bg-slate-900 dark:text-slate-100">

    <!-- 🌗 Tombol Toggle -->
    <button id="toggleTheme" class="toggle-btn" title="Ganti Tema 🌙/🌞">🌙</button>

    <!-- 🔆 Logo -->
    <header class="absolute top-4 left-6 text-lg font-bold flex items-center gap-2">
        <div class="w-5 h-5 bg-yellow-400 rounded-full"></div>
        <span>Surya<span class="text-yellow-400">POS</span></span>
    </header>

    <!-- ✨ Konten Utama -->
    <main class="text-center max-w-xl">
        <h1 class="text-4xl font-bold mb-4">Selamat Datang di <span class="text-yellow-400">SuryaPOS</span></h1>
        <p class="mb-6 text-lg">Aplikasi kasir modern untuk warung Anda. Cepat, ringan, dan mudah digunakan.</p>

        <div class="space-x-4">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/admin/dashboard') }}" class="bg-yellow-400 text-black px-4 py-2 rounded hover:bg-yellow-500">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="bg-yellow-400 text-black px-4 py-2 rounded hover:bg-yellow-500">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="border border-yellow-400 text-yellow-400 px-4 py-2 rounded hover:bg-yellow-500 hover:text-black">Register</a>
                    @endif
                @endauth
            @endif
        </div>
    </main>

    <!-- ⚙️ Script Toggle -->
    <script>
        const toggleBtn = document.getElementById('toggleTheme');
        const html = document.documentElement;

        const savedTheme = localStorage.getItem('theme');
        if (savedTheme === 'dark') {
            html.classList.add('dark');
            toggleBtn.textContent = '🌞';
        }

        toggleBtn.addEventListener('click', () => {
            html.classList.toggle('dark');
            const isDark = html.classList.contains('dark');
            toggleBtn.textContent = isDark ? '🌞' : '🌙';
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
        });
    </script>

</body>
</html>
