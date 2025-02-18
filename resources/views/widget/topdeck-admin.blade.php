<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3>{{ $widget->title }}</h3>
                    <br>
                    @foreach ($config['urlList'] as $url)
                    <div>
                        <input
                            type="text"
                            value="{{ $url }}"
                            style="width: 100%; display: block; margin-top: 10px;"
                        />
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
