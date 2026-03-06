    <!DOCTYPE html>
    <html>
    <!-- Mirrored from mannatthemes.com/annex/vertical/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 09 Feb 2026 09:44:59 GMT -->

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0,minimal-ui">
        <title>Travel Umrah Haji - Rivanka</title>
        <meta content="Admin Dashboard" name="description">
        <meta content="Mannatthemes" name="author">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <link rel="shortcut icon" href="{{ asset ('assets/images/favicon.ico') }}">
        <link href="{{ asset ('assets/plugins/morris/morris.css') }}" rel="stylesheet">
        <link href="{{ asset ('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset ('assets/css/icons.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset ('assets/css/style.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset ('assets/css/custom.css') }}" rel="stylesheet" type="text/css">
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <body class="fixed-left"><!-- Loader -->
        <div id="preloader">
            <div id="status">
                <div class="spinner"></div>
            </div>
        </div><!-- Begin page -->
        <div id="wrapper">
            <!-- ========== Left Sidebar Start ========== -->
            <div class="left side-menu">
                <button type="button" class="button-menu-mobile button-menu-mobile-topbar open-left waves-effect">
                    <i class="ion-close"></i>
                </button>

                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="text-center">
                        <a href="#" class="logo">
                            <i class="mdi mdi-assistant"></i> Rivanka
                        </a>
                    </div>
                </div>

                <div class="sidebar-inner slimscrollleft">
                    <div id="sidebar-menu">
                        <ul>

                            @auth
                            @php
                            $userableType = auth()->user()->userable_type;
                            $isAdmin = $userableType === \App\Models\Admin::class;
                            $isAgent = $userableType === \App\Models\Agents::class;
                            $isJemaah = $userableType === \App\Models\People::class;
                            @endphp

                            {{-- ── DASHBOARD sesuai role ── --}}
                            <li class="menu-title">Dashboard</li>

                            @if($isAdmin)
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="waves-effect">
                                    <i class="mdi mdi-airplay"></i> <span>Dashboard</span>
                                </a>
                            </li>
                            @elseif($isAgent)
                            <li>
                                <a href="{{ route('agent.dashboard') }}" class="waves-effect">
                                    <i class="mdi mdi-airplay"></i> <span>Dashboard</span>
                                </a>
                            </li>
                            @elseif($isJemaah)
                            <li>
                                <a href="{{ route('jemaah.dashboard') }}" class="waves-effect">
                                    <i class="mdi mdi-airplay"></i> <span>Dashboard</span>
                                </a>
                            </li>
                            @endif

                            {{-- ── ADMIN ONLY ── --}}
                            @if($isAdmin)
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect">
                                    <i class="mdi mdi-layers"></i>
                                    <span>Management User</span>
                                    <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
                                </a>
                                <ul class="list-unstyled">
                                    <li><a href="{{ route('agent.tabel') }}">Agent</a></li>
                                    <li><a href="{{ route('jemaah.tabel') }}">Jemaah</a></li>
                                </ul>
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect">
                                    <i class="mdi mdi-bullseye"></i>
                                    <span>Management Paket</span>
                                    <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
                                </a>
                                <ul class="list-unstyled">
                                    <li>
                                        <a class="menu-link {{ !request()->route('type') ? 'active' : '' }}"
                                            href="{{ route('package.tabel') }}">Paket</a>
                                    </li>
                                </ul>
                            </li>
                            @endif

                            {{-- ── LIST PAKET (admin + agent + jemaah) ── --}}
                            @if($isAdmin || $isAgent || $isJemaah)
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect">
                                    <i class="mdi mdi-format-list-bulleted"></i>
                                    <span>List Paket</span>
                                    <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
                                </a>
                                <ul class="list-unstyled">
                                    <li>
                                        <a class="menu-link {{ request()->route('type') == 'umrah' ? 'active' : '' }}"
                                            href="{{ route('package.tabel', 'umrah') }}">Umrah</a>
                                    </li>
                                    <li>
                                        <a class="menu-link {{ request()->route('type') == 'haji' ? 'active' : '' }}"
                                            href="{{ route('package.tabel', 'haji') }}">Haji</a>
                                    </li>
                                </ul>
                            </li>
                            @endif

                            {{-- ── BOOKING (admin + agent) ── --}}
                            @if($isAdmin || $isAgent)
                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect">
                                    <i class="mdi mdi-package-variant"></i>
                                    <span>Booking</span>
                                    <span class="float-right"><i class="mdi mdi-chevron-right"></i></span>
                                </a>
                                <ul class="list-unstyled">
                                    <li><a href="{{ route('booking.tabel') }}">Semua Booking</a></li>
                                </ul>
                            </li>
                            @endif

                            {{-- ── LOGOUT ── --}}
                            <li class="menu-title">Akun</li>
                            <li>
                                <a href="#" class="waves-effect"
                                    onclick="event.preventDefault(); document.getElementById('logout-form-sidebar').submit();"
                                    style="color:#f46a6a;">
                                    <i class="mdi mdi-logout" style="color:#f46a6a;"></i>
                                    <span>Logout</span>
                                </a>
                                <form id="logout-form-sidebar" method="POST"
                                    action="{{ route('logout') }}" style="display:none;">
                                    @csrf
                                </form>
                            </li>

                            @endauth

                        </ul>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!-- end sidebar-inner -->

            </div>
            <!-- Left Sidebar End --><!-- Start right Content here -->
            <div class="content-page">
                @yield('content')
            </div>
        </div>
        <!-- Start content -->
        <footer class="footer text-right">
            2019 © Annex.
        </footer>
        <!-- END wrapper --><!-- jQuery  -->
        <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
        <script src="{{ asset('assets/js/popper.min.js') }}"></script>
        <script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('assets/js/modernizr.min.js') }}"></script>
        <script src="{{ asset('assets/js/detect.js') }}"></script>
        <script src="{{ asset('assets/js/fastclick.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.slimscroll.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.blockUI.js') }}"></script>
        <script src="{{ asset('assets/js/waves.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.nicescroll.js') }}"></script>
        <script src="{{ asset('assets/js/jquery.scrollTo.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/skycons/skycons.min.js') }}"></script>
        <script src="{{ asset('assets/plugins/raphael/raphael-min.js') }}"></script>
        <script src="{{ asset('assets/plugins/morris/morris.min.js') }}"></script>
        <script src="{{ asset('assets/pages/dashborad.js') }}"></script><!-- App js -->
        <script src="{{ asset('assets/js/app.js') }}"></script>

        @stack('scripts')

        <script>
            /* BEGIN SVG WEATHER ICON */
            if (typeof Skycons !== 'undefined') {
                var icons = new Skycons({
                        "color": "#fff"
                    }, {
                        "resizeClear": true
                    }),
                    list = [
                        "clear-day", "clear-night", "partly-cloudy-day",
                        "partly-cloudy-night", "cloudy", "rain", "sleet", "snow", "wind",
                        "fog"
                    ],
                    i;

                for (i = list.length; i--;)
                    icons.set(list[i], list[i]);
                icons.play();
            };

            // scroll

            $(document).ready(function() {

                $("#boxscroll").niceScroll({
                    cursorborder: "",
                    cursorcolor: "#cecece",
                    boxzoom: true
                });
                $("#boxscroll2").niceScroll({
                    cursorborder: "",
                    cursorcolor: "#cecece",
                    boxzoom: true
                });

            });
        </script>
    </body>
    <!-- Mirrored from mannatthemes.com/annex/vertical/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 09 Feb 2026 09:45:34 GMT -->

    </html>