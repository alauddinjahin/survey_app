<!-- ========== Left Sidebar Start ========== -->
<div class="left-side-menu">

<div class="slimscroll-menu">

    <!--- Sidemenu -->
    <div id="sidebar-menu">

        <ul class="metismenu" id="side-menu">

            <li>
                <a href="{{ route('dashboard.index') }}" class="waves-effect">
                    <i class="mdi mdi-view-dashboard"></i>
                    <span> Dashboard </span>
                </a>
            </li>

            @can('users.viewAny')
            <li>
                <a href="{{ route('users.index') }}" class="waves-effect">
                    <i class="fa fa-users"></i>
                    <span> Users </span>
                </a>
            </li>

            <li>
                <a href="{{ route('surveys.index') }}" class="waves-effect">
                    <i class="fas fa-table"></i>
                    <span> Surveys </span>
                </a>
            </li>

            <li>
                <a href="{{ route('questions.index') }}" class="waves-effect">
                    <i class="fa fa-question-circle"></i>
                    <span> Questions </span>
                </a>
            </li>

            <li>
                <a href="{{ route('payments.index') }}" class="waves-effect">
                    <i class="fas fa-money-bill-alt"></i>
                    <span> Payments </span>
                </a>
            </li>

            @endcan

            <li>
                <a href="javascript: void(0);" class="waves-effect">
                    <i class="fab fa-artstation"></i>
                    <span>Settings</span>
                    <span class="menu-arrow"></span>
                </a>

                {{-- <ul class="nav-second-level" aria-expanded="false">
                    <li>
                        <a href="{{route('categories.index')}}">Category List</a>
                    </li>
                    <li>
                        <a href="{{route('subcategories.index')}}">Sub Category List</a>
                    </li>
                </ul> --}}
            </li>

        </ul>

    </div>
    <!-- End Sidebar -->

    <div class="clearfix"></div>

</div>
<!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->