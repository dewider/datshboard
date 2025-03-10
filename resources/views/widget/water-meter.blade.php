<x-base-layout>
    <x-slot name="title">
        {{ $widget->getTitle() }}
    </x-slot>

    <div>
        ХВС: {{ $data['cold'] }}
    </div>
    <div>
        ГВС: {{ $data['hot'] }}
    </div>

</x-base-layout>