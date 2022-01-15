<!DOCTYPE html>
<html>
<head>
    <title>Visit Japan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- CSS only -->
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>



<!--nav bar -->

<!-- end of nav bar -->

@include('parts.nav')

<div class="contents">

@include('pages.home')

</div>

@include('parts.footer')

@include('parts.scripts')


</body>

</html>