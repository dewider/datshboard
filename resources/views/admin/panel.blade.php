<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        {{ __('Виджеты') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @foreach ($widgets as $widget)
                    <div class="p-6 text-gray-900">
                        <a href="{{ route('adminWidgetDetail', ['widgetModel' => $widget->id]) }}">{{ $widget->title }}</a>
                        <a href="{{ route('adminDeleteWidget', ['widget' => $widget->id]) }}">{{ __('Удалить') }}</a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-admin-layout>
