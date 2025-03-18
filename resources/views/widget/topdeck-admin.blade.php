<x-admin-widget-edit-layout :widget="$widget">
    <h3 class="text-lg font-medium text-gray-900">
        {{ __('Список ссылок') }}
    </h3>
    @foreach ($config['urlList'] as $url)
    <div>
        <input
            type="text"
            value="{{ $url }}"
            style="width: 100%; display: block; margin-top: 10px;"
            name="url[]"
        >
    </div>
    @endforeach
    <input
        type="text"
        value=""
        style="width: 100%; display: block; margin-top: 10px;"
        name="url[]"
    >
</x-admin-widget-edit-layout>