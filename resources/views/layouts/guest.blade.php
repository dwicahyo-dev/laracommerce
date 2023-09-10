<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>{{ $title }} &mdash; {{ config('app.name') }}</title>

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

</head>

<body class="layout-2">
    <div id="app">
        <div class="main-wrapper">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <a href="{{ url('/') }}" class="navbar-brand sidebar-gone-hide">LaraCommerce</a>
                <a href="#" class="nav-link sidebar-gone-show" data-toggle="sidebar">
                    <i class="fas fa-bars"></i>
                </a>

                <form class="form-inline ml-auto" method="GET"
                    action="{{ route('products.index', request()->query('*')) }}">
                    <ul class="navbar-nav">
                        <li>
                            <a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none">
                                <i class="fas fa-search"></i>
                            </a>
                        </li>
                    </ul>
                    <div class="search-element">
                        <input class="form-control" type="search" name="name" placeholder="Search" aria-label="Search"
                            data-width="250" value="{{ request()->query('name') }}">
                        <button class="btn" type="submit"><i class="fas fa-search"></i></button>
                        <div class="search-backdrop"></div>
                    </div>
                    <ul class="navbar-nav navbar-right">
                        <li class="dropdown"><a href="#" data-toggle="dropdown"
                                class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                                <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle mr-1">
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="{{ route('login') }}" class="dropdown-item has-icon">
                                    <i class="fas fa-sign-out-alt"></i> Login
                                </a>
                            </div>
                        </li>
                    </ul>
            </nav>
            <div class="main-sidebar">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand sidebar-gone-show">
                        <a href="{{ url('/') }}">LaraCommerce</a>
                    </div>

                    <ul class="sidebar-menu">
                        <li class="menu-header">Pricing</li>

                        <li class="menu-header">
                            <input type="number" class="form-control" name="minimum_price" id="minimum_price"
                                value="{{ request()->query('minimum_price') }}" placeholder="Minimum Price">
                        </li>
                        <li class="menu-header">
                            <input type="number" class="form-control" name="maximum_price" id="maximum_price"
                                value="{{ request()->query('maximum_price') }}" placeholder="Maximum Price">
                        </li>
                    </ul>

                    <div class="mt-4 mb-4 p-3 hide-sidebar-mini">
                        <button type="submit" class="btn btn-primary btn-lg btn-block btn-icon-split">
                            <i class="fas fa-rocket"></i> Apply Filter
                        </button>
                    </div>
                    </form>
                </aside>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <section class="section">
                    <div class="section-header">
                        <h1>Products</h1>
                        <div class="section-header-breadcrumb">
                            <div class="breadcrumb-item active">
                                <a href="{{ url('/') }}">Products</a>
                            </div>
                        </div>
                    </div>

                    <div class="section-body">

                        {{ $slot }}
                    </div>
                </section>
            </div>
            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; 2018 <div class="bullet"></div> Design By <a href="https://nauval.in/">Muhamad
                        Nauval Azhar</a>
                </div>
                <div class="footer-right">

                </div>
            </footer>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/modules/tooltip.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/modules/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>

    <!-- JS Libraies -->
    <script src="{{ asset('assets/modules/sticky-kit.js') }}"></script>

    <!-- Page Specific JS File -->

    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
</body>

</html>