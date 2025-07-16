<x-guest-layout>
    <x-slot name="title">Register</x-slot>

    <h2 class="text-2xl font-semibold text-center mb-6">Daftar Akun SuryaPOS</h2>

    <x-alert-error />

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <x-input type="text" name="name" text="Nama" />
        <x-input type="text" name="email" text="Email" />
        <x-input type="password" name="password" text="Password" />
        <x-input type="password" name="password_confirmation" text="Konfirmasi Password" />
        <!-- Nama Warung -->
        <x-input type="text" text="Nama Warung" name="nama_warung" />


        <x-button type="primary btn-block" text="Register" for="submit" />
    </form>

    <div class="text-sm mt-4 text-center">
        Sudah punya akun? <a href="{{ route('login') }}" class="text-yellow-500 hover:underline">Login</a>
    </div>
</x-guest-layout>
