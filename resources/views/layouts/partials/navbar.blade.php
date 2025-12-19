<!-- Navbar -->
<header id="header" class="fixed-top header-inner-pages">
    <nav class="main-header navbar navbar-expand navbar-light" style="background-color: #3A7CA5;">

        <!-- Left Navbar -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}" style="margin-left: 10px;">
            <span class="ml-2 site-title">Data Pustaka</span>
        </a>
        <!-- Right Navbar -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto align-items-center">
                <li class="nav-item ">
                    <a class="nav-link" href="{{ route(name: 'home') }}">Beranda</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="{{ route(name: 'koleksi') }}">Koleksi</a>
                </li>
                <li class="nav-item ">
                    <a class="nav-link" href="{{ route(name: 'peminjaman.index') }}">Peminjaman</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link d-flex align-items-center" href="#" id="layananDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Layanan
                        <i class="fas fa-caret-down ml-1" style="font-size: 12px;"></i>
                    </a>

                    <div class="dropdown-menu shadow animated--grow-in" aria-labelledby="layananDropdown">
                        <a class="dropdown-item" href="{{ route('waktu') }}">Waktu Layanan</a>
                        <a class="dropdown-item" href="{{ route('referensi') }}">Layanan Referensi</a>
                        <a class="dropdown-item" href="{{ route('peraturan') }}">Peraturan Perpustakaan</a>
                        <a class="dropdown-item" href="{{ route('panduan') }}">Panduan Peminjaman</a>
                    </div>
                </li>

                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" id="userDropdown"
                        role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-white"
                            style="font-size: 1.15rem; font-family: 'Poppins', sans-serif;">
                            {{ auth()->user()->name }}</span>
                        <img class="img-profile rounded-circle" src="{{ asset('/uploads/profile/' . auth()->user()->photo) }}"
                            style="width: 24px; height: 24px; object-fit: cover;">
                        <i class="fas fa-caret-down ml-1" style="font-size: 12px;"></i>
                    </a>
                    <div class="dropdown-menu shadow animated--grow-in" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="{{ route('profil.index') }}">
                            <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                            Profile
                        </a>
                        <div class="dropdown-divider"></div>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                        <a class="dropdown-item text-danger" href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2"></i>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>