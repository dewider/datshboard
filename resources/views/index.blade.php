@extends('layouts.base')

@section('title', 'Виджеты')

@section('main')
@if (!empty($widgets))
<table class="table table-striped">
    <thead>
        @foreach ($widgets as $widget)
        <tr>
            <td>{{$widget->title}}</td>
            <td>
                <a href="{{ route('widgetDetail', ['widgetModel' => $widget->id]) }}">Детали</a>
            </td>
        </tr>
        @endforeach
    </thead>
</table>
@endif
@endsection('main')