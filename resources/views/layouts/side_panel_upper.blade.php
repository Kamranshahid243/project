<aside class="main-sidebar" ng-controller="LayoutController">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{Auth::user()->photo}}" class="img-circle"
                     alt="User Image">
            </div>
            <div class="pull-left info">
                <p>
                    @if(Auth::user())
                        {{Auth::user()->name}}
                    @endif
                </p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>
        <sidebar-menu></sidebar-menu>
    </section>
</aside>
@include('layouts.sidebar-menu-directive')
