<!DOCTYPE html>
<html>
<head>
    <title>Find Places</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- CSS only -->
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>
@include('parts.nav')

<div id="app" class="content">

    <places-component :api-data='{{$api_data}}' :places-data="{{$places}}" :radius-data="{{$radius}}" :ll-data="{{$ll}}"></places-component>

</div>


@include('parts.footer')
@include('parts.scripts')
</body>
</html>
