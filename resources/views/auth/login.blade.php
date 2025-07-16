<x-guest-layout>
    <x-slot name="title">Login</x-slot>

    <h2 class="text-2xl font-semibold text-center mb-6">Masuk ke SuryaPOS</h2>

    <x-alert-error />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <x-input type="text" name="email" text="Email" />
        <x-input type="password" name="password" text="Password" />

        <x-button type="primary btn-block" text="Login" for="submit" />
    </form>

    <div class="text-sm mt-4 text-center">
        Belum punya akun? <a href="{{ route('register') }}" class="text-yellow-500 hover:underline">Daftar</a>
    </div>
</x-guest-layout>
