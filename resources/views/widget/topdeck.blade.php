@extends('layouts.base')

@section('title', $widget->title)

@section('main')
<div>
    Обновлено: {{ $widget->updated_at }}
</div>
<table class="table table-striped">
    <thead>
        <tr>
            <td>Продавец</td>
            @foreach ($data['cardNameByColIndex'] as $colIndex => $cardName)
                <td>
                    <div>{{ $cardName }}</div>
                    <div>min: {{ $data['minPrices'][$colIndex] }}р</div>
                </td>
            @endforeach
        </tr>
    </thead>
    <tboby>
        @foreach ($data['rows'] as $sellerName => $row)
        <tr>
            <td>{{ $sellerName }}</td>
            @for ($colIndex = 0; $colIndex < count($data['cardNameByColIndex']); $colIndex++)
                <td>{{ isset($row[$colIndex]) ? $row[$colIndex] . 'р' : '-' }}</td>
            @endfor
        </tr>
        @endforeach
    </tboby>
</table>
@endsection('main')

