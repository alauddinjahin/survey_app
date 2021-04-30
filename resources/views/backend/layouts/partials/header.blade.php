   
  <!-- Topbar Start -->
  <div class="navbar-custom">
        <ul class="list-unstyled topnav-menu float-right mb-0">

            <li class="d-none d-sm-block">
                <form class="app-search">
                    <div class="app-search-box">
                        <div class="input-group">
                            <input type="text" class="form-control text-dark" placeholder="Search...">
                            <div class="input-group-append">
                                <button class="btn" type="submit">
                                    <i class="fe-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </li>

            <li class="dropdown d-none d-lg-block">
                <a class="nav-link dropdown-toggle mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="{{ asset('ui/backend/dist')}}/assets/images/flags/us.jpg" alt="user-image" class="mr-1" height="12"> <span class="align-middle">English <i class="mdi mdi-chevron-down"></i> </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <img src="{{ asset('ui/backend/dist')}}/assets/images/flags/germany.jpg" alt="user-image" class="mr-1" height="12"> <span class="align-middle">German</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <img src="{{ asset('ui/backend/dist')}}/assets/images/flags/italy.jpg" alt="user-image" class="mr-1" height="12"> <span class="align-middle">Italian</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <img src="{{ asset('ui/backend/dist')}}/assets/images/flags/spain.jpg" alt="user-image" class="mr-1" height="12"> <span class="align-middle">Spanish</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <img src="{{ asset('ui/backend/dist')}}/assets/images/flags/russia.jpg" alt="user-image" class="mr-1" height="12"> <span class="align-middle">Russian</span>
                    </a>

                </div>
            </li>

            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle  waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="fe-bell noti-icon"></i>
                    <span class="badge badge-danger rounded-circle noti-icon-badge">
                        @if(auth()->user() && count(auth()->user()->unreadNotifications) > 0)
                            {{count(auth()->user()->unreadNotifications)}}
                        @else 
                        {{ 0 }}    
                        @endif
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-lg">

                    <!-- item-->
                    <div class="dropdown-item noti-title">
                        <h5 class="m-0">
                            <span class="float-right">
                            </span>Notification
                        </h5>
                    </div>

                    <div class="slimscroll noti-scroll">

                        @if(auth()->user() && count(auth()->user()->unreadNotifications) > 0)
                            @foreach (auth()->user()->unreadNotifications as $notification)
                            @php 
                                $words = preg_replace('/(?<!\ )[A-Z]/', ' $0', explode('\\',$notification->type)[2]);
                            @endphp

                            @if($notification->data['requisition']['requisition_type'] == 1)
                            <!-- item-->
                            <a href="{{ route('requisitions.show',$notification->data['requisition']['id']) }}?notificationId={{ $notification->id }}" class="dropdown-item notify-item active">
                                <div class="notify-icon bg-soft-primary text-primary">
                                    <i class="mdi mdi-comment-account-outline"></i>
                                </div>
                                <p class="notify-details"><strong>Center Store Purchase Requisition</strong>
                                    <small class="text-muted">{{$notification->created_at->format('Y-m-d')}} &nbsp;&nbsp;&nbsp;&nbsp; {{$notification->created_at->diffForHumans()}}</small>
                                    <mark class="small text-gray">by {{$notification->data['requisition']['created_by']['name'] }}</mark> <br> 
                                </p>
                            </a>
                            @elseif($notification->data['requisition']['requisition_type'] == 2)
                            <a href="{{ route('substore_requisitions.show',$notification->data['requisition']['id']) }}?notificationId={{ $notification->id }}" class="dropdown-item notify-item active">
                                <div class="notify-icon bg-soft-primary text-primary">
                                    <i class="mdi mdi-comment-account-outline"></i>
                                </div>
                                <p class="notify-details"><strong>Substore Purchase Requisition</strong>
                                    <small class="text-muted">{{$notification->created_at->format('Y-m-d')}} &nbsp;&nbsp;&nbsp;&nbsp; {{$notification->created_at->diffForHumans()}}</small>
                                    <mark class="small text-gray">by {{$notification->data['requisition']['created_by']['name'] }}</mark> <br>
                                </p>
                            </a>
                            @else 
                            <a href="{{ route('substore_requisitions.store_show',$notification->data['requisition']['id']) }}?notificationId={{ $notification->id }}" class="dropdown-item notify-item active">
                                <div class="notify-icon bg-soft-primary text-primary">
                                    <i class="mdi mdi-comment-account-outline"></i>
                                </div>
                                <p class="notify-details"> <strong>Substore Store Requisition</strong>
                                    <small class="text-muted">{{$notification->created_at->format('Y-m-d')}} &nbsp;&nbsp;&nbsp;&nbsp; {{$notification->created_at->diffForHumans()}}</small>
                                    <mark class="small text-gray">by {{$notification->data['requisition']['created_by']['name'] }}</mark> <br>
                                </p>
                            </a>
                            @endif
                            @endforeach
                        @else 
                        <a href="javascript:void(0);" class="dropdown-item notify-item active d-flex">
                            <i class="mdi mdi-comment-account-outline"></i>
                            <p class="notify-details"> <small>There is no notification</small></p>
                        </a>   
                        @endif

                    </div>

                </div>
            </li>

        
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                    <img src="{{ asset('ui/backend/dist')}}/assets/images/users/avatar-1.jpg" alt="user-image" class="rounded-circle">
                    <span class="pro-user-name ml-1">
                        <span>{{ auth()->user()->name ?? 'Nike Patel' }}</span> <i class="mdi mdi-chevron-down"></i> 
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                    <!-- item-->

                    <!-- item-->
                    <a href="{{ route('users.loadAuthUserProfile') }}" class="dropdown-item notify-item">
                        <i class="mdi mdi-account-circle"></i>
                        <span>Profile</span>
                    </a>

                    <!-- item-->
                    {{-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="mdi mdi-settings"></i>
                        <span>Settings</span>
                    </a> --}}

                    <!-- item-->
                    {{-- logout  --}}
                    <a href="{{ route('logout') }}"
                        class="no-underline hover:underline dropdown-item notify-item"
                        onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();"><i class="mdi mdi-lock"></i> {{ __('Logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        {{ csrf_field() }}
                    </form>
                    {{-- logout  --}}

                    <div class="dropdown-divider"></div>

                    <!-- item-->
                </div>
            </li>

            <li class="dropdown notification-list">
                <a href="javascript:void(0);" class="nav-link right-bar-toggle waves-effect waves-light">
                    <i class="fe-settings noti-icon"></i>
                </a>
            </li>


        </ul>

        <!-- LOGO -->
        <div class="logo-box">
            <a href="{{ route('dashboard.index') }}" class="logo text-center">
                <span class="logo-lg">
                    {{-- <i class="fas fa-clinic-medical "></i> --}}
                    <span class="logo-lg-text-light"> Dashboard</span>
                </span>
                <span class="logo-sm text-white">
                    <i class=" fas fa-clinic-medical " style="font-size: 20px;"></i>
                </span>
            </a>
        </div>

        <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
            <li>
                <button class="button-menu-mobile waves-effect waves-light">
                    <i class="fe-menu"></i>
                </button>
            </li>
        </ul>
    </div>
    <!-- end Topbar -->