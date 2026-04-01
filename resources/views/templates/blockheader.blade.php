<div class="block-header">
    <div class="row">
        <div class="col-lg-7 col-md-6 col-sm-12">
            @isset($pagename)
            <h2>{{$pagename}}
                @endisset
            <small class="text-muted">Welcome to <b>Build Arya</b></small>
            </h2>
        </div>
        <div class="col-lg-5 col-md-6 col-sm-12">                
          
            <ul class="breadcrumb float-md-right">
                <li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i class="zmdi zmdi-home"></i> Dashboard</a></li>
                <li class="breadcrumb-item active"> @isset($pagename)
                    {{$pagename}}
                    @endisset
                </li>
            </ul>                
        </div>
    </div>
</div>