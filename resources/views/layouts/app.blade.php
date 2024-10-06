<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Mi Aplicación')</title>

    <!-- CSS de Bootstrap -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOMsZq0FfHM69fGmP6TjT1Y21zYc1NjFhgjB1TRh" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


    @vite(['resources/css/app.css', 'resources/css/colors.css', 'resources/css/partials.css', 'resources/js/app.js'])

</head>
<body>


    @include('partials.navbar')
    @include('partials.toast')
    <div class="container-fluid ">
        <div class="row ">
            @auth
                @include('partials.sidebar') <!-- Sidebar solo para usuarios autenticados -->
            @endauth

            <main class="col col-md-9 col-lg-10">
                @yield('content')
            </main>
        </div>
    </div>

    @include('partials.footer')

    <!-- JS de Bootstrap y dependencias -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



</body>
</html>
