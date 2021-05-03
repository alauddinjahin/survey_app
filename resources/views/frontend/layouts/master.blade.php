<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} | @yield('title','Home')</title>
    <link href="{{ asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/wizard.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/style.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('ui/backend/dist/assets/libs/jquery-toast/jquery.toast.min.css') }}">

    @stack('css')

</head>
<body>
    
    <div class="container">
        @include('frontend.layouts.partials.header') 
    </div>

    @yield('content')

     @include('frontend.layouts.partials.footer') 

    <script src="{{ asset('ui/backend/dist')}}/assets/js/pages/jquery.min.js"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('ui/backend/dist/assets/libs/jquery-toast/jquery.toast.min.js') }}"></script>
    <script src="{{ asset('ui/backend/src/js/pages/global-js/init-global-toast.js') }}"></script>
    <script src="{{ asset('ui/backend/src/js/pages/global-js/global-common.js') }}"></script>
    <script>
        $(document).ready(function(){
            // $(window).scroll(function(){
            //     var sc = $(window).scrollTop();
            //     if(sc > 100){
            //     $(".navbar").addClass("sticky");
            //     }else{
            //     $(".navbar").removeClass("sticky");
            //     }
            // });
        })
    </script> 
    <script src="{{ asset('js/wizard.js') }}"></script> 
    @stack('js')  
</body>
</html>