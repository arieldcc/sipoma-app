<header class="bg-info text-white">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#"></a>
        <!-- Hapus tombol toggle di sini atau ubah menjadi `d-none` pada perangkat kecil -->
        <!-- Button ini dihapus -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    @auth
                        <a class="nav-link dropdown-toggle" href="#" id="profileMenu" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            {{ Auth::user()->level }}
                        </a>

                    @else

                        <a class="nav-link" href="{{ route('login') }}" id="profileMenu">
                            Login
                        </a>
                    @endauth
                    {{-- <div class="dropdown-menu dropdown-menu-right" aria-labelledby="profileMenu">
                        <a class="dropdown-item" href="#profile">Profil</a>
                        <a class="dropdown-item" href="#login">Login</a>
                        <a class="dropdown-item" href="#logout">Logout</a>
                    </div> --}}
                </li>
            </ul>
        </div>
    </nav>

    <!-- Carousel Slide -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="{{ asset('images/banner1.jpg') }}" class="d-block w-100" alt="Slide 1">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Slide 1</h5>
                    <p>Description for slide 1.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/banner2.jpg') }}" class="d-block w-100" alt="Slide 2">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Slide 2</h5>
                    <p>Description for slide 2.</p>
                </div>
            </div>
            <div class="carousel-item">
                <img src="{{ asset('images/banner3.jpg') }}" class="d-block w-100" alt="Slide 3">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Slide 3</h5>
                    <p>Description for slide 3.</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
    </div>
</header>
