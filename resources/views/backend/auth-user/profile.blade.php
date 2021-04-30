@extends('backend.layouts.master')

@section('title', 'Profile')

@section('content')
     <!-- Start Content-->
 <div class="container-fluid my-4">
    @php $mainAuthUser = auth()->user()->isAdmin() @endphp

    <div class="row">
        <div class="col-lg-4 col-xl-4">
            <div class="card-box text-center">

                @if(auth()->check() && !is_null(auth()->user()->photo))
                <img src="{{ asset('storage/users').'/'.auth()->user()->photo }}" alt="user-image" class="rounded-circle avatar-xl img-thumbnail">
                @else 
                <img src="{{ asset('img/default.PNG')}}" alt="user-image" class="rounded-circle avatar-xl img-thumbnail">
                @endif

                @if(auth()->check())
                    <h4 class="mb-0"> {{ auth()->user()->name??''  }}</h4>
                @else
                    <h4 class="mb-0">Nik G. Patel</h4>
                    <p class="text-muted">@webdesigner</p>
                @endif

            
                <div class="text-left mt-3">
                    <h4 class="font-13 text-uppercase">About Me :</h4>
                    @if(!is_null(auth()->user()->bio))
                    {!! auth()->user()->bio??'' !!}
                    @else 
                    <p class="text-muted main-paragrap font-13 my-2 p-0">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit. Maxime nam nostrum iusto laudantium molestiae eum voluptatibus unde accusamus, alias magni.
                    </p>
                    @endif

                    <p class="mb-2 font-13">
                        <strong>Mobile &nbsp;&nbsp;&nbsp;&nbsp;:</strong>
                        <span class="ml-2">0919345345</span>
                    </p>

                    <p class="mb-2 font-13">
                        <strong>Email &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</strong> 
                        <span class="ml-2 ">{{ auth()->user()->email??'' }}</span>
                    </p>

                    <p class="mb-1 font-13">
                        <strong>Location :</strong>
                        <span class="ml-2">Bangladesh</span>
                    </p>
                </div>

                <ul class="social-list list-inline mt-3 mb-0">
                    <li class="list-inline-item">
                        <a href="javascript: void(0);" class="social-list-item border-purple text-purple"><i class="mdi mdi-facebook"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="javascript: void(0);" class="social-list-item border-danger text-danger"><i class="mdi mdi-google"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="javascript: void(0);" class="social-list-item border-info text-info"><i class="mdi mdi-twitter"></i></a>
                    </li>
                    <li class="list-inline-item">
                        <a href="javascript: void(0);" class="social-list-item border-secondary text-secondary"><i class="mdi mdi-github-circle"></i></a>
                    </li>
                </ul>
            </div> <!-- end card-box -->

        </div> <!-- end col-->

        <div class="col-lg-8 col-xl-8">
            <div class="card-box">
                <ul class="nav nav-pills navtab-bg">
                    <li class="nav-item">
                        <a href="#settings" data-toggle="tab" aria-expanded="true" class="nav-link active ml-0">
                            <i class="mdi mdi-settings-outline mr-1"></i>Settings
                        </a>
                    </li>
                </ul>

                <div class="tab-content">

                    <div class="tab-pane show active" id="settings">
                        <form action="{{ route('users.update',auth()->user()->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf 
                            @method('PUT')
                            <input type="hidden" name="from_profile" value="true">
                            <h5 class="mb-3 text-uppercase bg-light p-2"><i class="mdi mdi-account-circle mr-1"></i> Personal Info</h5>
                            
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="full_name">Name</label>
                                        <input type="text" class="form-control" readonly value="{{ auth()->user()->name??'' }}" id="full_name" placeholder="Enter Full name">
                                    </div>
                                </div>
                            </div> <!-- end row -->

                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="bio">Bio</label>
                                        <textarea class="form-control" id="bio" rows="4" name="bio" placeholder="Write something...">
                                            {{ auth()->user()->bio??'' }}
                                        </textarea>
                                    </div>
                                </div> <!-- end col -->
                            </div> <!-- end row -->

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Profile Photo</label>
                                    <div class="input-group">
                                        <div class="input-group-append">
                                            <button title="Image Preview" class="btn btn-primary collapsed" type="button" data-toggle="collapse" data-target="#collapseExample1" aria-expanded="false" aria-controls="collapseExample"><i class="fa fa-image fa-lg"></i></button>
                                        </div>
                                        <input type="file" name="photo" id="profile-image" class="form-control" accept="image/*">
                                    </div>

                                    <div class="collapse pt-4" id="collapseExample1">
                                        <div class="d-flex justify-content-center" onclick="javascript: document.getElementById('profile-image').click()">
                                            @if(auth()->check() && !is_null(auth()->user()->photo))
                                                <img title="Click to upload image" src="{{ asset('storage/users').'/'.auth()->user()->photo }}" alt="PROFILE PHOTO" id="profile-img-preview" class="img-fluid img-responsive img-thumbnail" ondragstart="javascript: return false;" style="cursor:pointer;width:300px; height: 300px !important;">
                                            @else
                                                <img title="Click to upload image" src="{{ asset('/img/blank-user.jpg') }}" alt="PROFILE PHOTO" id="profile-img-preview" class="img-fluid img-responsive img-thumbnail" ondragstart="javascript: return false;" style="cursor:pointer;width:300px; height: 300px !important;">
                                            @endif
                                        </div>
                                    </div>

                                </div>

                            </div> 
                            
                            
                            <div class="text-right">
                                <button type="submit" class="btn btn-success waves-effect waves-light mt-2"><i class="mdi mdi-content-save"></i> Save</button>
                            </div>
                        </form>
                    </div>
                    <!-- end settings content-->

                </div> <!-- end tab-content -->
            </div> <!-- end card-box-->

        </div> <!-- end col -->
    </div>
    <!-- end row-->
    
</div> <!-- container -->
@endsection

@push('js')
<script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
<script>
   $(document).ready(function(){
       CKEDITOR.replace('bio',{
           width: '100%',
           height:'auto',
           resize_dir: 'vertical',
           resize_maxHeight: 500,
       });

       $(document).on('change', '#profile-image', readFile);
   })


    function readFile() 
    {
        if (this.files && this.files[0]) 
        {
            const FR = new FileReader();
            FR.addEventListener("load", function(e) {
                $(document).find('#profile-img-preview').attr('src', e.target.result);
            }); 
            
            FR.readAsDataURL( this.files[0] );
        }
    }

    
</script>
@endpush

@push('css')
<style>
    .main-paragrap p{
        margin: 0 !important;
        padding: 0 !important;
        line-height: 0 !important;
    }
</style>
@endpush