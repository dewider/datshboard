@extends('layouts.base')

@section('title', '')

@section('main')
<table class="table table-striped">
    <thead>
        <tr>
            <td>Продавец</td>
            @foreach ($table['cardNameByColIndex'] as $cardName)
                <td>{{ $cardName }}</td>
            @endforeach
        </tr>
    </thead>
    <tboby>
        @foreach ($table['rows'] as $sellerName => $row)
        <tr>
            <td>{{ $sellerName }}</td>
            @for ($colIndex = 0; $colIndex < count($table['cardNameByColIndex']); $colIndex++)
                <td>{{ isset($row[$colIndex]) ? $row[$colIndex] . 'р' : '-' }}</td>
            @endfor
        </tr>
        @endforeach
    </tboby>
</table>
@endsection('main')

