<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $widget->getTitle() }} : {{ __('настройки') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <form
                    class="p-6 text-gray-900"
                    action="{{ route('adminWidgetUpdateConfig', ['widgetModel' => $widget->getId()]) }}"
                    method="post"
                >
                    @csrf
                    @method('patch')
                    <h3 class="text-lg font-medium text-gray-900">
                        {{ __('URL модуля счетчика') }}
                    </h3>
                    <input
                        type="text"
                        value="{{ $config['url'] }}"
                        style="width: 100%; display: block; margin-top: 10px;"
                        name="url"
                    />
                    <br>
                    <x-primary-button>{{ __('Save') }}</x-primary-button>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>
