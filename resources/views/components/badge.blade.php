@props(['textColor', 'bgColor'])

@php
    $textColor = match ($textColor) {
        'white' => 'text-white',
        'gray' => 'text-gray-800',
        'blue' => 'text-blue-800',
        'red' => 'text-red-800',
        'yellow' => 'text-yellow-800',
        default => 'text-gray-800',
    };

    $bgColor = match ($bgColor) {
        'gray' => 'bg-gray-800',
        'blue' => 'bg-blue-800',
        'darkblue' => 'bg-blue-950',
        'red' => 'bg-red-800',
        'yellow' => 'bg-yellow-800',
        'gold' => 'bg-yellow-600',
        'green' => 'bg-green-700',
        default => 'bg-gray-100',
    };
@endphp

<button {{ $attributes }} class="{{ $textColor }} {{ $bgColor }} rounded-xl px-3 py-1 text-base">
    {{ $slot }} </button>
