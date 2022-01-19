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

    <places-component :places-data='{{$places_data}}' :places-info-data="{{$places_info_data}}" :radius-data="{{$radius_data}}" :ll-data="{{$ll_data}}" :weather-data="{{$weather_data}}"></places-component>

</div>


@include('parts.footer')
@include('parts.scripts')
</body>
</html>
