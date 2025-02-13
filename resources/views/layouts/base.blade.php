<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>

<body>
    <div class="container">
        <h1 class="my-3 text-center">@yield('title')</h1>
        @yield('main')
        @if (!empty($widgets))
        <table class="table table-striped">
            <thead>
                @foreach ($widgets as $widget)
                <tr>
                    <td>{{$widget->title}}</td>
                    <td>
                        <a href="/{{$widget->id}}/">Детали</a>
                    </td>
                </tr>
                @endforeach
            </thead>
        </table>
        @endif
    </div>
</body>

</html>