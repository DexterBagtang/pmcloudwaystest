<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{route('index')}}" class="brand-link">
        <img src="{{asset('backend/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('backend/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{Auth::user()->email}}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item {{ (request()->routeIs('*sales*')) ? 'menu-is-opening menu-open' : '' }} ">
                    <a href="#" class="nav-link {{(request()->routeIs('sales*')) ? 'active' : ''}}">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Sales
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item">
                            <a href="{{url('sales')}}" class="nav-link {{ (request()->routeIs('sales')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                @if(request()->routeIs('sales'))
                                    <span class="badge badge-info right">{{$salesrequests->count()}}</span>
                                @endif
                                <p>Sales Request</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{url('disapproved-sales')}}" class="nav-link {{ (request()->routeIs('disapproved-sales')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                @if(request()->routeIs('disapproved-sales'))
                                    <span class="badge badge-info right">{{$salesrequests->count()}}</span>
                                @endif
                                <p>Disapproved Projects</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{url('sales-uploads-proofs')}}" class="nav-link {{ (request()->routeIs('sales-upload-proofs')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Send Proposal</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{url('sales-proposal-status')}}" class="nav-link {{ (request()->routeIs('sales-proposal-status')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Proposal Status</p>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a href="{{url('sales-malls')}}" class="nav-link {{ (request()->routeIs('sales-malls')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                @if(request()->routeIs('sales-malls'))
                                <span class="badge badge-info right">{{$malls->count()}}</span>
                                @endif
                                <p>Malls</p>
                            </a>
                        </li>

                    </ul>
                </li>


                <li class="nav-item {{ (request()->routeIs('*review*')) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link {{(request()->routeIs('*review*')) ? 'active' : ''}}">
                        <i class="nav-icon fas fa-hammer"></i>
                        <p>
                            PM Supervisor
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('pm-review-sales')}}" class="nav-link {{ (request()->routeIs('pm-review-sales')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Review Request</p>
                            </a>

                            <a href="{{url('review-projects')}}" class="nav-link {{ (request()->routeIs('review-projects')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Review Project Design</p>
                            </a>

                            <a href="{{url('review-bidders')}}" class="nav-link {{ (request()->routeIs('review-bidder')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Choose Bid Winner</p>
                            </a>

                            <a href="{{url('review-technicals')}}" class="nav-link {{ (request()->routeIs('review-technicals')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Technical Check</p>
                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item {{ (request()->routeIs('*assigned*')) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link {{(request()->routeIs('*assigned*')) ? 'active' : ''}}">
                        <i class="nav-icon fas fa-ruler"></i>
                        <p>
                            Assigned PM
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('assigned-pm')}}" class="nav-link {{ (request()->routeIs('assigned-pm')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Project Design Upload</p>
                            </a>

                            <a href="{{url('redesign-assigned-pm')}}" class="nav-link {{ (request()->routeIs('redesign-assigned-pm')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Redesign Project Upload</p>
                            </a>

                            <a href="{{url('assigned-project-completion')}}" class="nav-link {{ (request()->routeIs('assigned-project-completion')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Project Completion</p>
                            </a>

                        </li>

                    </ul>
                </li>

                <li class="nav-item {{ (request()->routeIs('*bidding*')) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link {{(request()->routeIs('bidding*')) ? 'active' : ''}}">
                        <i class="nav-icon fas fa-gavel"></i>
                        <p>
                            Purchasing
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('bidding')}}" class="nav-link {{ (request()->routeIs('bidding')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Biddings</p>
                            </a>

                            <a href="{{url('disapproved-bidding')}}" class="nav-link {{ (request()->routeIs('disapproved-bidding')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Rebid</p>
                            </a>

                            <a href="{{url('bidding-project-completion')}}" class="nav-link {{ (request()->routeIs('bidding-project-completion')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Project Completion</p>
                            </a>

                        </li>

                    </ul>
                </li>
                <li class="nav-item {{ (request()->routeIs('revenue-mark')) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link {{(request()->routeIs('revenue-mark')) ? 'active' : ''}}">
                        <i class="nav-icon fas fa-chart-line"></i>
                        <p>
                            Revenue
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('revenue-markups')}}" class="nav-link {{ (request()->routeIs('revenue-mark-ups')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Mark Bidders</p>
                            </a>

                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('revenue-disapproved')}}" class="nav-link {{ (request()->routeIs('revenue-mark-ups')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Disapproved Proposals</p>
                            </a>

                        </li>
                    </ul>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('revenue-bid-summary')}}" class="nav-link {{ (request()->routeIs('revenue-bid-summary')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Upload Bid Summary</p>
                            </a>

                        </li>
                    </ul>
                </li>

                <li class="nav-item {{ (request()->routeIs('revenue-head*')) ? 'menu-is-opening menu-open' : '' }}">
                    <a href="#" class="nav-link {{(request()->routeIs('revenue-head*')) ? 'active' : ''}}">
                        <i class="nav-icon fas fa-chart-bar"></i>
                        <p>
                            Revenue Head
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('revenue-head-markups')}}" class="nav-link {{ (request()->routeIs('revenue-head-markups')) ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Check Mark up</p>
                            </a>

                        </li>
                    </ul>

                </li>

{{--                <li class="nav-item {{ (request()->routeIs('')) ? 'menu-is-opening menu-open' : '' }}">--}}
{{--                    <a href="#" class="nav-link {{(request()->routeIs('')) ? 'active' : ''}}">--}}
{{--                        <i class="nav-icon fas fa-ruler"></i>--}}
{{--                        <p>--}}
{{--                            Projects--}}
{{--                            <i class="fas fa-angle-left right"></i>--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                    <ul class="nav nav-treeview">--}}
{{--                        <li class="nav-item">--}}

{{--                            <a href="{{url('projects')}}" class="nav-link {{ (request()->routeIs('')) ? 'active' : '' }}">--}}
{{--                                <i class="far fa-circle nav-icon"></i>--}}
{{--                                <p>Review Project Design</p>--}}
{{--                            </a>--}}
{{--                        </li>--}}

{{--                    </ul>--}}
{{--                </li>--}}

            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
