@props(['year'])
<x-badge wire:navigate href="{{ route('posts.index', ['year' => $year]) }}" :textColor="'white'"
         :bgColor="'darkblue'">
    {{ $year }}
</x-badge>
