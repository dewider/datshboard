<x-base-layout>
    <x-slot name="title">
        {{ __('Виджет') }}
    </x-slot>

    <pre>{{ print_r($data, true) }}</pre>
</x-base-layout>