<nav class="navbar navbar-expand-lg fixed-top navbar-light ">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo03" aria-controls="navbarTogglerDemo03" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <a href="{{ url('/') }}" class="navbar-brand"><img src="{{ asset('img/logo.png') }}" alt="" width="50" height="35"></a>
  
    <div class="collapse navbar-collapse" id="navbarTogglerDemo03">
      <ul class="navbar-nav ml-auto my-2">
        <li class="nav-item active pt-1 mx-2">
          <a class="nav-link" href="{{ url('/') }}">Home</a>
        </li>
        @if(!auth()->check())
        <li class="nav-item">
            <a href="{{ route('login') }}" class="nav-link text-dark d-inline-block btn btn-rounded" id="login2">Login</a>
        </li>
        @endif
        @if(auth()->check())
        <li class="nav-item">
            <a href="javascript:void(0)" id="profile" class="nav-link">
                <ul class="text-dark d-inline-block btn btn-rounded py-0 pl-0">
                    <li class="nav-item dropdown pl-0">

                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            @if(auth()->check() && !is_null(auth()->user()->photo))
                            <img width="35" height="35" src="{{ asset('storage/users').'/'.auth()->user()->photo }}" alt="user-image" class="rounded-circle">
                            @else 
                            <img width="35" height="35" src="{{ asset('img/default.PNG')}}" alt="user-image" class="rounded-circle p-4">
                            @endif
                            {{ auth()->user()->name??'' }}
                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a href="{{ route('logout') }}" 
                                class="dropdown-item no-underline hover:underline notify-item"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();"><i class="mdi mdi-lock"></i> {{ __('Logout') }}</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden" class="d-inline-block">
                                {{ csrf_field() }}
                            </form>
                        </div>
                    </li>
                </ul>
            </a>            
        </li>
        @endif
      </ul>

    </div>
  </nav>