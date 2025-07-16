{{-- resources/views/layouts/guest.blade.php (versi baru modern + dark/light) --}}
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'SuryaPOS' }}</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = { darkMode: 'class' }
    </script>

    <!-- Font -->
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
            background: none;
            border: none;
            font-size: 1.25rem;
            cursor: pointer;
        }
    </style>
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-900 text-gray-800 dark:text-gray-100 flex items-center justify-center">
    <!-- Toggle Theme Button -->
    <button id="toggleTheme" class="toggle-btn">🌙</button>

    <div class="w-full max-w-md p-6">
        {{ $slot }}
    </div>

    <script>
        const toggleBtn = document.getElementById('toggleTheme');
        const html = document.documentElement;
        const savedTheme = localStorage.getItem('theme');

        if (savedTheme) {
            html.setAttribute('data-theme', savedTheme);
            html.classList.add(savedTheme);
            toggleBtn.textContent = savedTheme === 'dark' ? '🌞' : '🌙';
        }

        toggleBtn.addEventListener('click', () => {
            const current = html.getAttribute('data-theme');
            const next = current === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', next);
            html.classList.remove(current);
            html.classList.add(next);
            toggleBtn.textContent = next === 'dark' ? '🌞' : '🌙';
            localStorage.setItem('theme', next);
        });
    </script>
</body>
</html>
