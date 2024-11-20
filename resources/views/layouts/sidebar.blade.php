<div class="list-group list-group-flush">
    <a href="/dashboard" class="list-group-item list-group-item-action">
        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard
    </a>
    <!-- Divider -->
    <hr class="my-2 bg-secondary">

    @auth
        @if(Auth::user()->level == 'admin')
            <a href="/periode" class="list-group-item list-group-item-action bg-dark text-white">
                <i class="fas fa-calendar mr-2"></i> Periode
            </a>
            <a href="/anggota" class="list-group-item list-group-item-action bg-dark text-white">
                <i class="fas fa-user-friends mr-2"></i> Anggota
            </a>
            <a href="/keanggotaan" class="list-group-item list-group-item-action bg-dark text-white">
                <i class="fas fa-users mr-2"></i> Keanggotaan
            </a>
            <a href="/pengurus" class="list-group-item list-group-item-action bg-dark text-white">
                <i class="fas fa-user-tie mr-2"></i> Pengurus
            </a>
            <a href="/kepanitiaan" class="list-group-item list-group-item-action bg-dark text-white">
                <i class="fas fa-hands-helping mr-2"></i> Kepanitiaan
            </a>
            <a href="/keuangan" class="list-group-item list-group-item-action bg-dark text-white">
                <i class="fas fa-coins mr-2"></i> Keuangan
            </a>
        @endif
        <!-- Menu Utama -->
        @if(Auth::user()->level == 'admin' || Auth::user()->level == 'User')
            <a href="/kegiatan" class="list-group-item list-group-item-action bg-dark text-white">
                <i class="fas fa-calendar-check mr-2"></i> Kegiatan
            </a>
            <a href="/prestasi" class="list-group-item list-group-item-action bg-dark text-white">
                <i class="fas fa-trophy mr-2"></i> Prestasi
            </a>
            {{-- <a href="#absensi" class="list-group-item list-group-item-action bg-dark text-white">
                <i class="fas fa-user-check mr-2"></i> Absensi
            </a> --}}

            <!-- Divider -->
            <hr class="my-2 bg-secondary">

            <a href="/organisasi" class="list-group-item list-group-item-action bg-dark text-white">
                <i class="fas fa-sitemap mr-2"></i> Struktur Organisasi
            </a>

            <a href="/galery" class="list-group-item list-group-item-action bg-dark text-white">
                <i class="fas fa-images mr-2"></i> Galeri Kegiatan
            </a>

            <!-- Divider -->
            <hr class="my-2 bg-secondary">

            <a href="/calon" class="list-group-item list-group-item-action bg-dark text-white">
                <i class="fas fa-sign-in-alt mr-2"></i> Calon Anggota
            </a>

            <a href="/struktur-organisasi" class="list-group-item list-group-item-action bg-dark text-white">
                <i class="fas fa-sign-in-alt mr-2"></i> Struktur Organisasi
            </a>
        @endif
    @endauth

    @guest
    <a href="/calon" class="list-group-item list-group-item-action bg-dark text-white">
        <i class="fas fa-sign-in-alt mr-2"></i> Calon Anggota
    </a>

    <a href="/struktur-organisasi" class="list-group-item list-group-item-action bg-dark text-white">
        <i class="fas fa-sign-in-alt mr-2"></i> Struktur Organisasi
    </a>

    <!-- Divider -->
    <hr class="my-2 bg-secondary">

    <!-- Login/Logout -->
    <a href="{{ route('login') }}" class="list-group-item list-group-item-action bg-dark text-white">
        <i class="fas fa-sign-in-alt mr-2"></i> Login
    </a>

    @else

    @if(Auth::user()->level == 'admin')
        <!-- Menu Manajemen User dan Login/Logout -->
        <a href="/user-manajemen" class="list-group-item list-group-item-action bg-dark text-white">
            <i class="fas fa-users-cog mr-2"></i> Manajemen User
        </a>
    @endif

        <a href="{{ route('logout') }}" class="list-group-item list-group-item-action bg-dark text-white" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt mr-2"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    @endguest

</div>
