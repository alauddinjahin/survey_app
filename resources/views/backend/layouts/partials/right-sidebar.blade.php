
<div class="right-bar">
    <div class="rightbar-title">
        <a href="javascript:void(0);" class="right-bar-toggle float-right">
            <i class="fe-x noti-icon"></i>
        </a>
        <h4 class="m-0 text-white">Settings</h4>
    </div>
    <div class="slimscroll-menu">
        <!-- User box -->
        <div class="user-box">
            <div class="user-img">
                <img src="{{ asset('ui/backend/dist/assets/images/users/avatar-10.jpg')}}" alt="user-img" title="Mat Helme" class="rounded-circle img-fluid">
                <a href="javascript:void(0);" class="user-edit"><i class="mdi mdi-pencil"></i></a>
            </div>
            
            <h5><a href="javascript: void(0);"><span>{{ Auth::user()->name??'Nike Patel' }}</span></a> </h5>
            <p class="text-muted mb-0"><small>{{ auth()->user()->role->name??'' }}</small></p>
        </div>

        <ul class="nav nav-pills bg-light nav-justified">
            <li class="nav-item">
                <a href="#home1" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0">
                    General
                </a>
            </li>
            <li class="nav-item">
                <a href="#messages1" data-toggle="tab" aria-expanded="false" class="nav-link rounded-0 active">
                    Chat
                </a>
            </li>
        </ul>
        <div class="tab-content pl-3 pr-3">
            <div class="tab-pane" id="home1">
                <div class="row mb-2">
                    <div class="col">
                        <h5 class="m-0 font-15">Notifications</h5>
                        <p class="text-muted"><small>Do you need them?</small></p>
                    </div> <!-- end col-->
                    <div class="col-auto">
                        <div class="custom-control custom-switch mb-2">
                            <input type="checkbox" class="custom-control-input" id="tabswitch1">
                            <label class="custom-control-label" for="tabswitch1"></label>
                        </div>
                    </div> <!-- end col -->
                </div>
                <!-- end row-->

                <div class="row mb-2">
                    <div class="col">
                        <h5 class="m-0 font-15">API Access</h5>
                        <p class="text-muted"><small>Enable/Disable access</small></p>
                    </div> <!-- end col-->
                    <div class="col-auto">
                        <div class="custom-control custom-switch mb-2">
                            <input type="checkbox" class="custom-control-input" checked id="tabswitch2">
                            <label class="custom-control-label" for="tabswitch2"></label>
                        </div>
                    </div> <!-- end col -->
                </div>
                <!-- end row-->

                <div class="row mb-2">
                    <div class="col">
                        <h5 class="m-0 font-15">Auto Updates</h5>
                        <p class="text-muted"><small>Keep up to date</small></p>
                    </div> <!-- end col-->
                    <div class="col-auto">
                        <div class="custom-control custom-switch mb-2">
                            <input type="checkbox" class="custom-control-input" id="tabswitch3">
                            <label class="custom-control-label" for="tabswitch3"></label>
                        </div>
                    </div> <!-- end col -->
                </div>
                <!-- end row-->

                <div class="row mb-2">
                    <div class="col">
                        <h5 class="m-0 font-15">Online Status</h5>
                        <p class="text-muted"><small>Show your status to all</small></p>
                    </div> <!-- end col-->
                    <div class="col-auto">
                        <div class="custom-control custom-switch mb-2">
                            <input type="checkbox" class="custom-control-input" checked id="tabswitch4">
                            <label class="custom-control-label" for="tabswitch4"></label>
                        </div>
                    </div> <!-- end col -->
                </div>
                <!-- end row-->

                <div class="alert alert-success alert-dismissible fade mt-3 show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                    <h5>Unlimited Access</h5>
                    Upgrade to plan to get access to unlimited reports
                    <br/>
                    <a href="javascript: void(0);" class="btn btn-outline-success mt-3 btn-sm">Upgrade<i class="ml-1 mdi mdi-arrow-right"></i></a>
                </div>
                
            </div>
            <div class="tab-pane show active" id="messages1">
                <div>
                    <div class="inbox-widget">
                        <h5 class="mt-0">Recent</h5>
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="{{ asset('ui/backend/dist/assets/images/users/avatar-2.jpg')}}" class="rounded-circle" alt=""> <i class="online user-status"></i></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Tomaslau</a></p>
                            <p class="inbox-item-text">I've finished it! See you so...</p>
                        </div>
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="{{ asset('ui/backend/dist/assets/images/users/avatar-3.jpg')}}" class="rounded-circle" alt=""> <i class="away user-status"></i></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Stillnotdavid</a></p>
                            <p class="inbox-item-text">This theme is awesome!</p>
                        </div>
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="{{ asset('ui/backend/dist/assets/images/users/avatar-4.jpg')}}" class="rounded-circle" alt=""> <i class="online user-status"></i></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Kurafire</a></p>
                            <p class="inbox-item-text">Nice to meet you</p>
                        </div>
                        
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="{{ asset('ui/backend/dist/assets/images/users/avatar-5.jpg')}}" class="rounded-circle" alt=""> <i class="busy user-status"></i></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Shahedk</a></p>
                            <p class="inbox-item-text">Hey! there I'm available...</p>
                        </div>
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="{{ asset('ui/backend/dist/assets/images/users/avatar-6.jpg')}}" class="rounded-circle" alt=""> <i class="user-status"></i></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Adhamdannaway</a></p>
                            <p class="inbox-item-text">This theme is awesome!</p>
                        </div>

                        <hr/>
                        <h5>Favorite <span class="float-right badge badge-pill badge-danger">18</span></h5>
                        <hr/>
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="{{ asset('ui/backend/dist/assets/images/users/avatar-7.jpg')}}" class="rounded-circle" alt=""> <i class="busy user-status"></i></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Kennith</a></p>
                            <p class="inbox-item-text">I've finished it! See you so...</p>
                        </div>
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="{{ asset('ui/backend/dist/assets/images/users/avatar-3.jpg')}}" class="rounded-circle" alt=""> <i class="busy user-status"></i></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Stillnotdavid</a></p>
                            <p class="inbox-item-text">This theme is awesome!</p>
                        </div>
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="{{ asset('ui/backend/dist/assets/images/users/avatar-10.jpg')}}" class="rounded-circle" alt=""> <i class="online user-status"></i></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Kimberling</a></p>
                            <p class="inbox-item-text">Nice to meet you</p>
                        </div>
                        
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="{{ asset('ui/backend/dist/assets/images/users/avatar-4.jpg')}}" class="rounded-circle" alt=""> <i class="user-status"></i></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Kurafire</a></p>
                            <p class="inbox-item-text">Hey! there I'm available...</p>
                        </div>
                        <div class="inbox-item">
                            <div class="inbox-item-img"><img src="{{ asset('ui/backend/dist/assets/images/users/avatar-9.jpg')}}" class="rounded-circle" alt=""> <i class="away user-status"></i></div>
                            <p class="inbox-item-author"><a href="javascript: void(0);" class="text-dark">Leonareade</a></p>
                            <p class="inbox-item-text">This theme is awesome!</p>
                        </div>

                        <div class="text-center mt-2">
                            <a href="javascript:void(0);" class="text-muted"><i class="mdi mdi-spin mdi-loading mr-1"></i> Load more </a>
                        </div>

                    </div> <!-- end inbox-widget -->
                </div> <!-- end .p-3-->
            </div>
        </div>

    </div> <!-- end slimscroll-menu-->
</div>