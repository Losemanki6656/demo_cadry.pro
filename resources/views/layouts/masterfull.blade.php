<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head> 
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
        content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
      
    <title>E-xodim</title>
    <link rel="shortcut icon" type="image/x-icon" href="../../../app-assets/images/favicon.png">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/vendors.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/charts/apexcharts.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/extensions/tether-theme-arrows.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/extensions/tether.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/extensions/shepherd-theme-default.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/forms/select/select2.min.css')}}">
    
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/ag-grid/ag-grid.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/tables/ag-grid/ag-theme-material.css')}}">
    <!-- END: Vendor CSS-->

    <link rel="stylesheet" type="text/css" href="../../../app-assets/vendors/css/tables/datatable/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/vendors/css/extensions/toastr.css')}}">
    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('app-assets/css/bootstrap-extended.css')}}">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/themes/semi-dark-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/dashboard-analytics.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/card-analytics.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/plugins/tour/tour.css">

    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/app-chat.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/plugins/extensions/toastr.css">

    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/app-todo.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/app-todo.min.css">
    
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/app-user.css">
    <link rel="stylesheet" type="text/css" href="../../../app-assets/css/pages/aggrid.css">
    <!-- END: Page CSS-->


    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="../../../assets/css/style.css">
    <!-- END: Custom CSS-->

</head>

    <body class="vertical-layout vertical-menu-modern content-left-sidebar chat-application navbar-floating footer-static" data-open="click"
    data-menu="vertical-menu-modern" data-col="2-columns">

    <!-- BEGIN: Header-->
    <nav class="header-navbar navbar-expand-lg navbar navbar-with-menu floating-nav navbar-light navbar-shadow">
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="navbar-collapse" id="navbar-mobile">
                    <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                        <ul class="nav navbar-nav">
                            <li class="nav-item mobile-menu d-xl-none mr-auto"><a
                                    class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                        class="ficon feather icon-menu"></i></a></li>
                        </ul>
                        <ul class="nav navbar-nav bookmark-icons">
                            <li class="nav-item d-none d-lg-block"><a class="nav-link" href="/"
                                    data-toggle="tooltip" data-placement="top" title="Kadrlar"><i
                                        class="ficon feather icon-users"></i></a></li>
                            <li class="nav-item d-none d-lg-block"><a class="nav-link" href="/"
                                    data-toggle="tooltip" data-placement="top" title="Chat"><i
                                        class="ficon feather icon-message-square"></i></a></li>
                            <li class="nav-item d-none d-lg-block"><a class="nav-link" href="/"
                                    data-toggle="tooltip" data-placement="top" title="Email"><i
                                        class="ficon feather icon-mail"></i></a></li>
                        </ul>
                    </div>
                    <ul class="nav navbar-nav float-right">
                        <li class="dropdown dropdown-language nav-item"><a class="dropdown-toggle nav-link"
                                id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false"><i class="flag-icon flag-icon-uz"></i><span
                                    class="selected-language">O'zbek</span></a>
                            <div class="dropdown-menu" aria-labelledby="dropdown-flag"><a class="dropdown-item" href="#"
                                    data-language="en"><i class="flag-icon flag-icon-uz"></i> O'zbek</a><a
                                    class="dropdown-item" href="#" data-language="ru"><i
                                        class="flag-icon flag-icon-fr"></i> Русский</a><a class="dropdown-item" href="#"
                                    data-language="de"><i class="flag-icon flag-icon-us"></i> English</a>
                            </div>
                        </li>
                        <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-expand"><i
                                    class="ficon feather icon-maximize"></i></a></li>
                        <li class="nav-item nav-search"><a class="nav-link nav-link-search"><i
                                    class="ficon feather icon-search"></i></a>
                            <div class="search-input">
                                <div class="search-input-icon"><i class="feather icon-search primary"></i></div>
                                <input class="input" type="text" placeholder="Search..." tabindex="-1">
                                <div class="search-input-close"><i class="feather icon-x"></i></div>
                                <ul class="search-list search-list-main"></ul>
                            </div>
                        </li>
                        <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#"
                                data-toggle="dropdown"><i class="ficon feather icon-bell"></i><span
                                    class="badge badge-pill badge-primary badge-up">5</span></a>
                            <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                <li class="dropdown-menu-header">
                                    <div class="dropdown-header m-0 p-2">
                                        <h3 class="white">5 ta o'qilmagan</h3><span class="notification-title"> xabarlar</span>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <li class="dropdown dropdown-user nav-item"><a
                                class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <div class="user-nav d-sm-flex d-none"><span class="user-name text-bold-600">{{Auth::user()->name}}</span>
                                    <span class="user-status">Available</span></div><span><img
                                        class="round" src="{{asset(Auth::user()->userorganization->photo)}}"
                                        alt="avatar" height="40" width="40"></span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item"
                                    href="/"><i class="feather icon-user"></i> Edit Profile</a><a
                                    class="dropdown-item" href="/"><i class="feather icon-mail"></i> My
                                    Inbox</a><a class="dropdown-item" href="/"><i
                                        class="feather icon-check-square"></i> Task</a><a class="dropdown-item"
                                    href="/"><i class="feather icon-message-square"></i> Chats</a>
                                <div class="dropdown-divider"></div><a class="dropdown-item" href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="feather icon-power"></i> Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->


    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto"><a class="navbar-brand"
                        href="/">
                        <img src="{{asset('app-assets/images/logo.png')}}" width="35" height="35">
                        <h2 class="brand-text mb-0">E-xodim</h2>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i
                            class="feather icon-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i
                            class="toggle-icon feather icon-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary"
                            data-ticon="icon-disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
               @can('product-list')
                    <li class=" navigation-header"><span>main</span>
                    </li>
                    <li class="{{ url()->current() == route('cadry_search')? 'active' : ''}}">
                        <a href="{{route('cadry_search')}}"><i class="fa fa-users"></i><span
                                class="menu-item" data-i18n="Analytics">Xodimlar ro'yxati</span>
                        </a>
                    </li>
                    <li class="{{ url()->current() == route('uty_organ')? 'active' : ''}}">
                        <a href="{{route('uty_organ')}}"><i class="fa fa-sitemap"></i><span
                                class="menu-item" data-i18n="Analytics">Korxonalar</span>
                        </a>
                    </li>
               @endcan
               
                @can('role-edit')
                    <li class="{{ url()->current() == route('cadry_leader')? 'active' : ''}}">
                        <a href="{{route('cadry_leader')}}"><i class="fa fa-users"></i><span
                                class="menu-item" data-i18n="Analytics">Korxonalar</span>
                        </a>
                    </li>
                @endcan

                <li class=" navigation-header"><span>Kadr</span>
                </li>
                <li class="{{ url()->current() == route('cadry')? 'active' : ''}}">
                    <a href="{{route('cadry')}}"><i class="fa fa-users"></i><span
                            class="menu-item" data-i18n="Analytics">Kadrlar</span>
                    </a>
                </li>
                <li class="{{ url()->current() == route('staff')? 'active' : ''}}">
                    <a href="{{route('staff')}}"><i class="fa fa-tasks"></i><span
                            class="menu-item" data-i18n="Analytics">Shtat Lavozimlari</span>
                    </a>
                </li>

                <li class="{{ url()->current() == route('departments')? 'active' : ''}}">
                    <a href="{{route('departments')}}"><i class="fa fa-sitemap"></i><span
                            class="menu-item" data-i18n="Analytics">Bo'limlar</span>
                    </a>
                </li>

                <li class="{{ url()->current() == route('regions')? 'active' : ''}}">
                    <a href="{{route('regions')}}"><i class="fa fa-map-signs"></i><span
                            class="menu-item" data-i18n="Analytics">Viloyat va tumanlar</span>
                    </a>
                </li> 
                @can('role-delete')
                <li class=" navigation-header"><span>Xat va xabarlar</span>
                </li>
                <li class="{{ url()->current() == route('sendtask')? 'active' : ''}}">
                    <a href="{{route('sendtask')}}"><i class="fa fa-share-square"></i>
                        <span class="menu-item" data-i18n="Analytics">Chiquvchi xabarlar</span>
                    </a>
                </li>
                <li class="{{ url()->current() == route('received')? 'active' : ''}}">
                    <a href="{{route('received')}}"><i class="fa fa-sign-in"> </i><span
                            class="menu-item" data-i18n="eCommerce">Kiruvchi xabarlar</span>
                    </a>
                </li>
                <li class="{{ url()->current() == route('send_files')? 'active' : ''}}">
                    <a href="{{route('send_files')}}"><i class="fa fa-upload"> </i>
                        <span
                            class="menu-item" data-i18n="eCommerce">Chiquvchi xatlar</span>
                     </a>
                </li>
                <li class="{{ url()->current() == route('received_files')? 'active' : ''}}">
                    <a href="{{route('received_files')}}"><i class="fa fa-download"></i>
                        <span class="menu-item" data-i18n="eCommerce">Kiruvchi xatlar</span>
                    </a>
                </li>
                <li class="{{ url()->current() == route('chat')? 'active' : ''}}">
                    <a href="{{route('chat')}}"><i class="fa fa-comments"></i>
                        <span class="menu-item" data-i18n="eCommerce">Chat</span>
                    </a>
                </li>
                @endcan
            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content">
        <div class="{{ url()->current() == route('chat')? 'content-area-wrapper' : 'content-wrapper'}}">
            
            @yield('content')
          
        </div>
    </div>
    <!-- END: Content-->

    <!-- BEGIN: Footer-->
    <footer class="footer footer-static footer-light">
        <p class="clearfix blue-grey lighten-2 mb-0"><span
                class="float-md-left d-block d-md-inline-block mt-25">&copy; 2022
                <a href="/" class="text-bold-800 grey darken-2">E-xodim,</a>All rights Reserved</span><span
                class="float-md-right d-none d-md-block">Hand-crafted by <a href="https://www.instagram.com/losemanki_official/">Boboqulov Jobir</a> </span>
            
        </p>
    </footer>
    <!-- END: Footer-->


    <!-- BEGIN: Vendor JS-->
    
    <script src="{{asset('app-assets/vendors/js/vendors.min.js')}}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="../../../app-assets/vendors/js/charts/apexcharts.min.js"></script>
    <script src="../../../app-assets/vendors/js/extensions/tether.min.js"></script>
    <script src="../../../app-assets/vendors/js/extensions/shepherd.min.js"></script>
    <!-- END: Page Vendor JS-->

    <script src="../../../app-assets/vendors/js/tables/ag-grid/ag-grid-community.min.noStyle.js"></script>
    
    <script src="../../../app-assets/vendors/js/forms/select/select2.full.min.js"></script>
    <!-- BEGIN: Theme JS-->
    <script src="../../../app-assets/js/core/app-menu.js"></script>
    <script src="../../../app-assets/js/core/app.js"></script>
    <script src="../../../app-assets/js/scripts/components.js"></script>
    
    <script src="../../../app-assets/js/scripts/modal/components-modal.js"></script>
    <!-- END: Theme JS-->

    <script src="../../../app-assets/js/scripts/forms/select/form-select2.js"></script>
    
    <script src="../../../app-assets/js/scripts/pages/app-chat.js"></script>
   
    <script src="../../../app-assets/js/scripts/extensions/toastr.js"></script>
    
    <script src="../../../app-assets/js/scripts/extensions/sweet-alerts.min.js"></script>
    
    <script src="../../../app-assets/js/scripts/pages/app-todo.js"></script>
    <script src="../../../app-assets/js/scripts/pages/app-todo.min.js"></script>
    
    <script src="../../../app-assets/js/scripts/pages/app-user.js"></script>
    
    @yield('scripts')
    @stack('scripts')

</body>
<!-- END: Body-->

</html>