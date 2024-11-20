<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>@yield('title', 'Sistem Informasi Organisasi Mahasiswa')</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('css/style-utama.css') }}">
    @yield('css')
</head>
<body>
    <div class="container-fluid">
        <!-- Header -->
        @include('layouts.header')

        <div class="row">
            <!-- Sidebar Menu for Larger Screens -->
            <div class="col-md-3 col-lg-2 bg-light p-0 d-none d-md-block">
                @include('layouts.sidebar')
            </div>

            <!-- Collapsible Sidebar for Smaller Screens -->
            <div class="col-12 d-md-none bg-light p-0">
                <nav class="navbar navbar-light bg-light">
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <span class="navbar-brand mb-0 h1">Menu</span>
                </nav>
                <div class="collapse" id="sidebarMenu">
                    @include('layouts.sidebar')
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-md-9 col-lg-10 py-4">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    @yield('js')
</body>
</html>
