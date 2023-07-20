@php
    $location_paths = config('app.paths.locations');
    $order_paths = config('app.paths.order');
    $segments = explode('/',request()->path());
    $route = $segments[2] ;
@endphp
<header>
    <!-- Sidebar -->
    <nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
        <div class="position-sticky">
            <div class="list-group list-group-flush mx-3 mt-4">
                <a href="{{url('/v1/admin/location')}} " class="list-group-item list-group-item-action py-2 ripple {{in_array($route,$location_paths) ? 'nav-active' : ''}}" aria-current="true">
                    <i class="fas fa-solid fa-calendar fa-fw me-3"></i><span>Locations</span>
                </a>
                {{-- <a href="#" class="list-group-item list-group-item-action py-2 ripple">
                        <i class="fas fa-chart-area fa-fw me-3"></i><span></span>
                    </a> --}}
                <a href="{{url('/v1/admin/view-orders')}}" class="list-group-item list-group-item-action py-2 ripple {{in_array($route,$order_paths) ? 'nav-active':''}}">
                    <i class="fas fa-sharp fa-solid fa-cart-shopping fa-fw me-3"></i>
                    <span>Orders</span>
                </a>
                    {{--
                    <a href="#" class="list-group-item list-group-item-action py-2 ripple"><i
                            class="fas fa-lock fa-fw me-3"></i><span>Password</span></a>
                    <a href="#" class="list-group-item list-group-item-action py-2 ripple"><i
                            class="fas fa-chart-line fa-fw me-3"></i><span>Analytics</span></a>
                    <a href="#" class="list-group-item list-group-item-action py-2 ripple">
                        <i class="fas fa-chart-pie fa-fw me-3"></i><span>SEO</span>
                    </a>
                    <a href="#" class="list-group-item list-group-item-action py-2 ripple"><i
                            class="fas fa-chart-bar fa-fw me-3"></i><span>Orders</span></a>
                    <a href="#" class="list-group-item list-group-item-action py-2 ripple"><i
                            class="fas fa-globe fa-fw me-3"></i><span>International</span></a>
                    <a href="#" class="list-group-item list-group-item-action py-2 ripple"><i
                            class="fas fa-building fa-fw me-3"></i><span>Partners</span></a>
                    <a href="#" class="list-group-item list-group-item-action py-2 ripple"><i
                            class="fas fa-calendar fa-fw me-3"></i><span>Calendar</span></a>
                    <a href="#" class="list-group-item list-group-item-action py-2 ripple"><i
                            class="fas fa-users fa-fw me-3"></i><span>Users</span></a>
                    <a href="#" class="list-group-item list-group-item-action py-2 ripple"><i
                            class="fas fa-money-bill fa-fw me-3"></i><span>Sales</span></a> --}}
            </div>
        </div>
    </nav>
    <!-- Sidebar -->

    <!-- Navbar -->
    <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
        <!-- Container wrapper -->
        <div class="container-fluid">
            <!-- Toggle button -->
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#sidebarMenu"
                aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Brand -->
            <a class="navbar-brand" href="{{ url('v1/admin/location') }}">
                <img src="{{asset('images/logo.png')}}" height="25"
                    alt="Maximum Delivery Logo" loading="lazy" />
            </a>

            <!-- Right links -->
            <ul class="navbar-nav ms-auto d-flex flex-row">
                <li class="nav-item">
                    <a class="nav-link d-flex align-items-center" href="{{url('v1/logout')}}">
                        <button class="btn btn-danger"><i class="fa-sharp fa-solid fa-right-from-bracket"></i></button>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->
</header>
<!--Main layout-->


<!--Main layout-->
