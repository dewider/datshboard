<x-base-layout>
    <x-slot name="title">
        {{ __('Виджеты') }}
    </x-slot>

    @if (!empty($widgets))
        <div class="container">
            <div class="row g-3">
                @foreach ($widgets as $widget)
                    <div class="col">
                        @include($widget->getPreViewName(), ['widget' => $widget])
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</x-base-layout>