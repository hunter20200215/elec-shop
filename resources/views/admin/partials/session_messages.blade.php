@if(Session::has('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>@lang('admin.Error!')</strong> {{Session::get('error')}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if(Session::has('message'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>@lang('admin.Success!')</strong> {{ Session::get('message') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
