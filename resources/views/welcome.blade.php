<!DOCTYPE html>
<html lang="en" amp>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8" />

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
</head>

<body>
    <div id="app">
        <app-home></app-home>
    </div>
</body>
<script src="{{ mix('js/app.js')}}" defer></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>


</html>