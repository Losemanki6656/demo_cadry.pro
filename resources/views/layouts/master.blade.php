<!doctype html>
<html id="html_main" lang="en">

<head>
    <meta charset="utf-8" />
    <title>Exodim</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Exodim" name="description" />
    <meta content="Themesbrand" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/logo.png') }}">

    <!-- plugin css -->
    <link href="{{ asset('assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- preloader css -->
    <link rel="stylesheet" href="{{ asset('assets/css/preloader.min.css') }}" type="text/css" />

    <link rel="stylesheet" href="{{ asset('assets/libs/glightbox/css/glightbox.min.css') }}">

    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/libs/alertifyjs/build/css/alertify.min.css') }}" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css"
        integrity="sha256-FdatTf20PQr/rWg+cAKfl6j4/IY3oohFAJ7gVC3M34E=" crossorigin="anonymous">
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme/dist/select2-bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ asset('assets/libs/choices.js/public/assets/styles/choices.min.css') }}" rel="stylesheet"
        type="text/css" />

    <link rel="stylesheet" href="{{ asset('assets/libs/flatpickr/flatpickr.min.css') }}">
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" id="app-style" rel="stylesheet" type="text/css" />

</head>

<body id="body_main" data-topbar="dark" data-layout-mode="" data-sidebar-size="" data-sidebar="">
    <div id="layout-wrapper">


        <header id="page-topbar">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box">

                        <a href="/" class="logo logo-light">
                            <span class="logo-sm">
                                <img src="{{ asset('assets/images/logo.png') }}" alt="" height="30">
                            </span>
                            <span class="logo-lg">
                                <img src="{{ asset('assets/images/logo.png') }}" alt="" height="50"
                                    width="43"> <span class="logo-txt">Exodim</span>
                            </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 font-size-16 header-item" id="vertical-menu-btn">
                        <i class="fa fa-fw fa-bars"></i>
                    </button>

                    <!-- App Search-->
                    <form class="app-search d-none d-lg-block">
                        <div class="position-relative">
                            <input type="search" class="form-control" placeholder="{{ __('messages.search') }}...">
                            <button class="btn btn-primary" type="button"><i
                                    class="bx bx-search-alt align-middle"></i></button>
                        </div>
                    </form>
                </div>

                <div class="d-flex">

                    <div class="dropdown d-inline-block d-lg-none ms-2">
                        <button type="button" class="btn header-item" id="page-header-search-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i data-feather="search" class="icon-lg"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-search-dropdown">

                            <form class="p-3">
                                <div class="form-group m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control"
                                            placeholder="{{ __('messages.search') }} ..." aria-label="Search Result">
                                        <button class="btn btn-primary" type="submit"><i
                                                class="mdi mdi-magnify"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                    <div class="dropdown d-none d-sm-inline-block">
                        <button type="button" class="btn header-item" data-bs-toggle="dropdown" id=""
                            aria-haspopup="true" aria-expanded="false">
                            @if (session()->get('locale') == 'ru')
                                <img id="language_img" src="{{ asset('assets/images/flags/ru.jpg') }}"
                                    alt="Header Language" height="16">
                            @elseif(session()->get('locale') == 'uz')
                                <img id="language_img" src="{{ asset('assets/images/flags/uz.jpg') }}"
                                    alt="Header Language" height="16">
                            @else
                                <img id="language_img" src="{{ asset('assets/images/flags/us.jpg') }}"
                                    alt="Header Language" height="16">
                            @endif
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <a href="{{ url('change/locale/uz') }}" class="dropdown-item notify-item language"
                                data-lang="uz">
                                <img src="{{ asset('assets/images/flags/uz.jpg') }}" alt="user-image" class="me-1"
                                    height="12"> <span class="align-middle">O'zbekcha</span>
                            </a>
                            <a href="{{ url('change/locale/ru') }}" class="dropdown-item notify-item language"
                                data-lang="ru">
                                <img src="{{ asset('assets/images/flags/ru.jpg') }}" alt="user-image" class="me-1"
                                    height="12"> <span class="align-middle">Russian</span>
                            </a>
                            <a href="{{ url('change/locale/en') }}" class="dropdown-item notify-item language"
                                data-lang="en">
                                <img src="{{ asset('assets/images/flags/us.jpg') }}" alt="user-image" class="me-1"
                                    height="12"> <span class="align-middle">English</span>
                            </a>
                        </div>
                    </div>

                    <div class="dropdown d-none d-sm-inline-block">
                        <button type="button" class="btn header-item" id="mode-setting-btn">
                            <i data-feather="moon" class="icon-lg layout-mode-dark"></i>
                            <i data-feather="sun" class="icon-lg layout-mode-light"></i>
                        </button>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item noti-icon position-relative"
                            id="page-header-notifications-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <i data-feather="bell" class="icon-lg"></i>
                            <span class="badge bg-success rounded-pill">5</span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-notifications-dropdown">
                            <div class="p-3">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0"> Notifications </h6>
                                    </div>
                                    <div class="col-auto">
                                        <a href="/" class="small text-reset text-decoration-underline"> Unread
                                            (3)</a>
                                    </div>
                                </div>
                            </div>
                            <div data-simplebar style="max-height: 230px;">
                                <a href="#!" class="text-reset notification-item">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 me-3">
                                            <img src="{{ asset('assets/images/logo.png') }}"
                                                class="rounded-circle avatar-sm" alt="user-pic">
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-1">Demo Version</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2 border-top d-grid">
                                <a class="btn btn-sm btn-link font-size-14 text-center" href="javascript:void(0)">
                                    <i class="mdi mdi-arrow-right-circle me-1"></i> <span>View More..</span>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item right-bar-toggle me-2">
                            <i data-feather="settings" class="icon-lg"></i>
                            {{-- <i class="fas fa-cog fa-spin"></i> --}}
                        </button>
                    </div>

                    <div class="dropdown d-inline-block">
                        <button type="button" class="btn header-item bg-soft-light border-start border-end"
                            id="page-header-user-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                            aria-expanded="false">
                            <img class="rounded-circle header-profile-user"
                                src="{{ asset(Auth::user()->userorganization->photo) }}" alt="Header Avatar">
                            <span class="d-none d-xl-inline-block ms-1 fw-medium">{{ Auth::user()->name }}</span>
                            <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <a class="dropdown-item" href="{{ route('user_edit') }}"><i
                                    class="mdi mdi-face-profile font-size-16 align-middle me-1"></i> Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="mdi mdi-logout font-size-16 align-middle me-1"></i> Logout</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </header>

        <!-- ========== Left Sidebar Start ========== -->
        <div class="vertical-menu">

            <div data-simplebar class="h-100">

                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <!-- Left Menu Start -->
                    <ul class="metismenu list-unstyled" id="side-menu">
                        @can('product-list')
                            <li class="menu-title" data-key="t-menu">{{ __('messages.menu') }}</li>
                            <li>
                                <a href="{{ route('statistics') }}">
                                    <i data-feather="pie-chart"></i>
                                    <span data-key="t-dashboard">{{ __('messages.statistika') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('cadry_search') }}">
                                    <i data-feather="search"></i>
                                    <span data-key="t-dashboard">{{ __('messages.xodimlar') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('uty_organ') }}">
                                    <i data-feather="list"></i>
                                    <span data-key="t-dashboard">{{ __('messages.korxonalar') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                    <i data-feather="codesandbox"></i>
                                    <span data-key="t-contacts">Qo'shimcha</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ route('users') }}" data-key="t-user-list">Foydalanuvchilar</a></li>
                                    <li><a href="{{ route('userDevices') }}" data-key="t-user-list">Kirishlar</a></li>
                                    <li><a href="{{ route('sessions') }}" data-key="t-user-list">Amallar</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="{{ route('turnicet') }}">
                                    <i data-feather="log-in"></i>
                                    <span data-key="t-dashboard">Turnicet</span>
                                </a>
                            </li>
                        @endcan
                        @can('role-edit')
                            <li>
                                <a href="{{ route('cadry_leader') }}">
                                    <i data-feather="list"></i>
                                    <span data-key="t-dashboard">{{ __('messages.korxonalar') }}</span>
                                </a>
                            </li>
                        @endcan
                        @can('role-list')
                            <li class="menu-title" data-key="t-menu">{{ __('messages.xodimlar') }}</li>
                            <li>
                                <a href="{{ route('cadry_statistics') }}">
                                    <i data-feather="pie-chart"></i>
                                    <span data-key="t-dashboard">{{ __('messages.statistika') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('cadry') }}">
                                    <i data-feather="users"></i>
                                    <span data-key="t-dashboard">{{ __('messages.xodimlar') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('staff') }}">
                                    <i data-feather="user-check"></i>
                                    <span data-key="t-dashboard">{{ __('messages.shtat') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('departments') }}">
                                    <i data-feather="bar-chart-2"></i>
                                    <span data-key="t-dashboard">{{ __('messages.bulimlar') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('vacations') }}">
                                    <i data-feather="bar-chart-2"></i>
                                    <span data-key="t-dashboard">Ta'tillar</span>
                                    <span class="badge bg-primary">New</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('meds') }}">
                                    <i data-feather="bar-chart-2"></i>
                                    <span data-key="t-dashboard">Tibbiy ko'rik</span>
                                    <span class="badge bg-success">New</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript: void(0);" class="has-arrow">
                                    <i data-feather="codesandbox"></i>
                                    <span data-key="t-contacts">{{ __('messages.boshqa') }}</span>
                                </a>
                                <ul class="sub-menu" aria-expanded="false">
                                    <li><a href="{{ route('incentives') }}" data-key="t-user-list">Rag'batlanirishlar</a>
                                    </li>
                                    <li><a href="{{ route('regions') }}" data-key="t-user-list">{{ __('messages.regions') }}</a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <a href="{{ route('archive_cadry') }}">
                                    <i data-feather="archive"></i>
                                    <span data-key="t-dashboard">{{ __('messages.arxiv') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('receptions') }}">
                                    <i data-feather="info"></i>
                                    <span data-key="t-dashboard">Taklif va murojatlar</span>
                                </a>
                            </li>
                        @endcan

                        @can('product-create')
                            <li class="menu-title" data-key="t-menu">{{ __('messages.xatlar') }}</li>
                            <li>
                                <a href="{{ route('sendtask') }}">
                                    <i data-feather="users"></i>
                                    <span data-key="t-dashboard">{{ __('messages.chxabar') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('received') }}">
                                    <i data-feather="user-check"></i>
                                    <span data-key="t-dashboard">{{ __('messages.kxabar') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('send_files') }}">
                                    <i data-feather="bar-chart-2"></i>
                                    <span data-key="t-dashboard">{{ __('messages.chxat') }}</span>
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('received_files') }}">
                                    <i data-feather="bar-chart-2"></i>
                                    <span data-key="t-dashboard">{{ __('messages.kxat') }}</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </div>
                <!-- Sidebar -->
            </div>
        </div>

        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">

                    @yield('content')

                </div>
                <!-- End Page-content -->

                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6">
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> © Exodim. All rights Reserved
                            </div>
                            <div class="col-sm-6">
                                <div class="text-sm-end d-none d-sm-block">
                                    Hand-crafted By <a href="#!" class="text-decoration">Boboqulov Jobir</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->


        <!-- Right Sidebar -->
        <div class="right-bar">
            <div data-simplebar class="h-100">
                <div class="rightbar-title d-flex align-items-center p-3">

                    <h5 class="m-0 me-2">Theme Customizer</h5>

                    <a href="javascript:void(0);" class="right-bar-toggle ms-auto">
                        <i class="mdi mdi-close noti-icon"></i>
                    </a>
                </div>

                <!-- Settings -->
                <hr class="m-0" />

                <div class="p-4">
                    <h6 class="mb-3">Select Custome Colors</h6>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input theme-color" type="radio" name="theme-mode"
                            id="theme-default" value="default"
                            onchange="document.documentElement.setAttribute('data-theme-mode', 'default')" checked>
                        <label class="form-check-label" for="theme-default">Default</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input theme-color" type="radio" name="theme-mode" id="theme-red"
                            value="red" onchange="document.documentElement.setAttribute('data-theme-mode', 'red')">
                        <label class="form-check-label" for="theme-red">Red</label>
                    </div>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input theme-color" type="radio" name="theme-mode"
                            id="theme-purple" value="purple"
                            onchange="document.documentElement.setAttribute('data-theme-mode', 'purple')">
                        <label class="form-check-label" for="theme-purple">Purple</label>
                    </div>

                    <h6 class="mt-4 mb-3 pt-2 sidebar-setting">Sidebar Color</h6>

                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-color" id="sidebar-color-light"
                            value="light" onchange="document.body.setAttribute('data-sidebar', 'light')">
                        <label class="form-check-label" for="sidebar-color-light">Light</label>
                    </div>
                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-color" id="sidebar-color-dark"
                            value="dark" onchange="document.body.setAttribute('data-sidebar', 'dark')">
                        <label class="form-check-label" for="sidebar-color-dark">Dark</label>
                    </div>
                    <div class="form-check sidebar-setting">
                        <input class="form-check-input" type="radio" name="sidebar-color" id="sidebar-color-brand"
                            value="brand" onchange="document.body.setAttribute('data-sidebar', 'brand')">
                        <label class="form-check-label" for="sidebar-color-brand">Brand</label>
                    </div>


                </div>

            </div> <!-- end slimscroll-menu-->
        </div>
        <!-- /Right-bar -->

        <!-- Right bar overlay-->
        <div class="rightbar-overlay"></div>

        <!-- JAVASCRIPT -->
        <script src="{{ asset('assets/libs/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js') }}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
        <script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
        <script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
        <!-- pace js -->
        <script src="{{ asset('assets/libs/pace-js/pace.min.js') }}"></script>

        <!-- Plugins js-->
        <script src="{{ asset('assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
        <script src="{{ asset('assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-world-mill-en.js') }}">
        </script>


        <!-- glightbox js -->
        <script src="{{ asset('assets/libs/glightbox/js/glightbox.min.js') }}"></script>

        <!-- lightbox init -->

        <script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js') }}"></script>
        <script src="{{ asset('assets/js/pages/lightbox.init.js') }}"></script>

        <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"
            integrity="sha256-AFAYEOkzB6iIKnTYZOdUf9FFje6lOTYdwRJKwTN5mks=" crossorigin="anonymous"></script>

        <script src="{{ asset('assets/libs/pristinejs/pristine.min.js') }}"></script>

        <script src="{{ asset('assets/js/pages/form-validation.init.js') }}"></script>

        <script src="{{ asset('assets/libs/alertifyjs/build/alertify.min.js') }}"></script>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
        
        @yield('scripts')
        @stack('scripts')

        <script src="{{ asset('assets/js/app.js') }}"></script>
        <script>
            let cat = localStorage.getItem('data_layout_mode');
            $("#body_main").attr('data-layout-mode', cat);
            let x = localStorage.getItem('data_sidebar_size');
            $("#body_main").attr('data-sidebar-size', x);
            let y = localStorage.getItem('data-sidebar');
            $("#body_main").attr('data-sidebar', y);
            let z = localStorage.getItem('data-theme-mode');
            $("#html_main").attr('data-theme-mode', z);
        </script>
        <script>
            $(document).ready(function() {
                document.getElementById('mode-setting-btn').onclick = function() {
                    let c = $("#body_main").attr('data-layout-mode');
                    if (c == "dark") {
                        localStorage.setItem('data_layout_mode', 'dark');
                    } else {
                        localStorage.setItem('data_layout_mode', 'light');
                        $("#body_main").attr('data-topbar', 'dark');
                    }
                };

                document.getElementById('vertical-menu-btn').onclick = function() {
                    let c = $("#body_main").attr('data-sidebar-size');
                    if (c == "sm") {
                        localStorage.setItem('data_sidebar_size', 'sm');
                    } else {
                        localStorage.setItem('data_sidebar_size', 'lg');
                    }
                };

                document.getElementById('sidebar-color-dark').onclick = function() {
                    localStorage.setItem('data-sidebar', 'dark');
                };
                document.getElementById('sidebar-color-light').onclick = function() {
                    localStorage.setItem('data-sidebar', '');
                };
                document.getElementById('sidebar-color-brand').onclick = function() {
                    localStorage.setItem('data-sidebar', 'brand');
                };
                document.getElementById('theme-red').onclick = function() {
                    localStorage.setItem('data-theme-mode', 'red');
                };
                document.getElementById('theme-purple').onclick = function() {
                    localStorage.setItem('data-theme-mode', 'purple');
                };
                document.getElementById('theme-default').onclick = function() {
                    localStorage.setItem('data-theme-mode', '');
                };

            });
        </script>
</body>

</html>
