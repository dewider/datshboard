<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Добавление виджета') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form
                        class="p-6 text-gray-900"
                        action="{{ route('adminSaveWidget') }}"
                        method="post">
                        @csrf

                        <div>
                            <input
                                type="text"
                                value=""
                                style="width: 100%; display: block; margin-top: 10px;"
                                name="title"
                            />
                        </div>
                        <div>
                            <select
                                style="width: 100%; display: block; margin-top: 10px;"
                                name="type"
                            >
                            @foreach ($widgetTypeList as $widgetType)
                                <option value="{{ $widgetType }}">{{ $widgetType }}</option>
                            @endforeach
                            </select>
                        </div>
                        <br>
                        <x-primary-button>{{ __('Save') }}</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>