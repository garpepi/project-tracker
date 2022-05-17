@section('sidebar')
<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <!-- <li class="nav-item {{ isActiveRoute('Dashboard') }}">
                <a class="nav-link" href="{{ route('Dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li> -->

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    @if (count($sidebar->menu) != 0)
    <!-- Heading -->
    <!-- <div class="sidebar-heading">
                Menu
            </div> -->
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ areActiveRoutes($sidebar->groups->menu) }}">
        <a class="nav-link {{ areCollapseRoutes($sidebar->groups->menu) }}" href="#" data-toggle="collapse" data-target="#collapseMenu" aria-expanded="true" aria-controls="collapseMenu">
            <i class="fas fa-fw fa-columns"></i>
            <span>Menu</span>
        </a>
        <div id="collapseMenu" class="collapse {{ areActiveRoutes($sidebar->groups->menu, 'show') }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @foreach($sidebar->menu as $item)
                <a class="collapse-item {{ (request()->is(''.$item->menu->url.'*')) ? 'active' : '' }}" href="/{{$item->menu->url}}">{{ $item->menu->name }}</a>
                @endforeach
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    @endif

    @if (count($sidebar->configuration) != 0)
    <!-- Heading -->
    <!-- <div class="sidebar-heading">
                Menu
            </div> -->
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ areActiveRoutes($sidebar->groups->configuration) }}">
        <a class="nav-link {{ areCollapseRoutes($sidebar->groups->configuration) }}" href="#" data-toggle="collapse" data-target="#collapseConfiguration" aria-expanded="true" aria-controls="collapseConfiguration">
            <i class="fas fa-fw fa-cog"></i>
            <span>Configuration</span>
        </a>
        <div id="collapseConfiguration" class="collapse {{ areActiveRoutes($sidebar->groups->configuration, 'show') }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                @foreach($sidebar->configuration as $item)
                <a class="collapse-item {{ (request()->is(''.$item->menu->url.'*')) ? 'active' : '' }}" href="/{{$item->menu->url}}">{{ $item->menu->name }}</a>
                @endforeach
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">
    @endif

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
@show
