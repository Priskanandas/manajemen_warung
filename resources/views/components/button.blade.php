@props(['type' => 'primary', 'for' => 'submit', 'text'])

@php
$classes = match ($type) {
    'primary' => 'bg-yellow-500 hover:bg-yellow-600 text-white',
    'secondary' => 'bg-gray-300 hover:bg-gray-400 text-gray-900',
    'danger' => 'bg-red-500 hover:bg-red-600 text-white',
    default => 'bg-gray-600 text-white'
};
@endphp

<button 
    type="{{ $for }}" 
    class="w-full py-2 px-4 mt-4 rounded {{ $classes }} font-semibold focus:outline-none focus:ring-2 focus:ring-yellow-400 transition"
>
    {{ $text }}
</button>
