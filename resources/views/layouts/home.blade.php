<!DOCTYPE html>
<html>
<head>
    <title>Visit Japan</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link rel="stylesheet" href="/css/app.css">
</head>
<body>



<!--nav bar -->
    <nav>
        <input id="nav-toggle" type="checkbox">
        <div class="logo">Visit Japan</div>
        <ul class="links">
            <li><a href="#home">Home</a></li>
            {{--<li><a href="#about">Link</a></li>--}}
            {{--<li><a href="#work">Link</a></li>--}}
            {{--<li><a href="#projects">Link</a></li>--}}
            {{--<li><a href="#contact">Link</a></li>--}}
        </ul>
        <label for="nav-toggle" class="icon-burger">
            <div class="line"></div>
            <div class="line"></div>
            <div class="line"></div>
        </label>
    </nav>
<!-- end of nav bar -->

<div class="contents">

@include('pages.home')


</div>
<footer>
    <p>&copy;Visit Japan 2022</p>
</footer>

<script src="/js/app.js">

</script>

<script src="/js/nav.js"></script>

</body>

</html>