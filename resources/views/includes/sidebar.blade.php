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
            <li class="nav-item {{ isActiveRoute('Dashboard') }}">
                <a class="nav-link" href="{{ route('Dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            @if (count($sidebar->operational_group) != 0)
            <!-- Heading -->
            <div class="sidebar-heading">
                Operational
            </div>
            <!-- Nav Item - Pages Collapse Menu -->
            <li class="nav-item {{ areActiveRoutes($sidebar->groups->operational) }}">
                <a class="nav-link {{ areCollapseRoutes($sidebar->groups->operational) }}" href="#" data-toggle="collapse" data-target="#collapseTwo"
                    aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Components</span>
                </a>
                <div id="collapseTwo" class="collapse {{ areActiveRoutes($sidebar->groups->operational, 'show') }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        @if (in_array('contract-po',$sidebar->operational_group))
                        <a class="collapse-item {{ areActiveRoutes($sidebar->groups->contract) }}" href="{{ route('contract-po') }}">Contract / PO</a>
                        @endif
                        @if (in_array('operational-cost',$sidebar->operational_group))
                        <a class="collapse-item {{ areActiveRoutes($sidebar->groups->opncost) }}" href="{{ route('operational-cost') }}">Operational & Cost</a>                            
                        @endif
                    </div>
                </div>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">  
            @endif

            @if (count($sidebar->monitoring_group) != 0)
            <!-- Heading -->
            <div class="sidebar-heading">
                Monitoring
            </div>
            
            
            <!-- Nav Item - Project Card -->
            <li class="nav-item {{ isActiveRoute('Monitoringproject-card') }}">
                <a class="nav-link" href="charts.html">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Project Card</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
            @endif

            @if (count($sidebar->configuration_group) != 0)
            <!-- Heading -->
            <div class="sidebar-heading">
                Configuration
            </div>

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item {{ areActiveRoutes(['Settingsmaster-clients']) }}">
                <a class="nav-link {{ areCollapseRoutes(['Settingsmaster-clients']) }}" href="#" data-toggle="collapse" data-target="#collapseUtilities"
                    aria-expanded="true" aria-controls="collapseUtilities">
                    <i class="fas fa-fw fa-wrench"></i>
                    <span>Settings</span>
                </a>
                <div id="collapseUtilities" class="collapse {{ areActiveRoutes(['Settingsmaster-clients'], 'show') }}" aria-labelledby="headingUtilities"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item {{ isActiveRoute('Settingsmaster-clients') }}" href="{{ route('Settingsmaster-clients') }}">Master Clients</a>
                    </div>
                </div>
            </li>
            @endif
            
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->
@show