<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="/" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini">{{config('app.nameShort')}}</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg">{{config('app.name')}}</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <i class="fas fa-bars"></i>
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- Notifications: style can be found in dropdown.less -->
                <li class="dropdown notifications-menu">
                @if((Session::has('shop')) && (Auth::user()->role->role == 'Admin'))
                        <a href=""><i class="fas fa-store"></i> {{ Session::get('shop')->shop_name }}</a>

                @endif
                    @if((Session::has('shop')) && (Auth::user()->role->role == 'Super Admin'))
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-store"></i> {{ session('shop')->shop_name }}
                        </a>
                    @endif
                    @if(!(Session::has('shop')) && (Auth::user()->role->role == 'Super Admin'))
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fas fa-store"></i> --Select Shop--
                        </a>
                    @endif
                    <ul class="dropdown-menu">
                        <li class="header">Select a shop from following</li>
                        <li>                            <!-- inner menu: contains the actual data -->
                            <ul class="menu">

                                @foreach(\App\Shop::all() as $shop)
                                    @if($shop->shop_status=='Active' && Auth::user()->role->role == 'Super Admin')
                                <li>
                                    <a href="shop-session/{{$shop->shop_id}}">
                                        <i class="fas fa-store text-aqua"></i> {{ $shop->shop_name }}
                                    </a>
                                </li>
                                    @endif
                                    @endforeach
                            </ul>
                        </li>
                        <li class="footer"><a href="#">View all</a></li>
                    </ul>
                </li>
                <!-- User Account Menu -->
                <li class="dropdown user user-menu">
                    <!-- Menu Toggle Button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <!-- The user image in the navbar-->
                        <img src="{{Auth::user()->photo}}" class="user-image"
                             alt="User Image">
                        <span class="hidden-xs">
                            @if(Auth::user()) {{Auth::user()->name}} @endif
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- The user image in the menu -->
                        <li class="user-header">
                            <img src="{{Auth::user()->photo}}" class="img-circle" alt="User Image">
                            <p>
                                @if(Auth::user())
                                    {{Auth::user()->name}} - {{Auth::user()->role->role}}
                                    <small>Member since {{Auth::user()->created_at->toFormattedDateString()}}</small>
                                @endif
                            </p>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">
                            <div class="pull-left">
                                <a href="/user/profile"><i class="fa fa-user"></i> Profile</a>
                            </div>
                            <div class="pull-right">
                                @include('common.logout-btn')
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>