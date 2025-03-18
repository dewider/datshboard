<x-admin-widget-edit-layout :widget="$widget">
    <h3 class="text-lg font-medium text-gray-900">
        {{ __('URL модуля счетчика') }}
    </h3>
    <input
        type="text"
        value="{{ $config['url'] }}"
        style="width: 100%; display: block; margin-top: 10px;"
        name="url"
    >
</x-admin-widget-edit-layout>