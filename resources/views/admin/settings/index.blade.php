@extends('admin.layout')
@section('custom_css')
    <link rel="stylesheet" href="{{asset('css/dropzone.min.css')}}">
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="content-header-text">@lang('admin.Settings') / @lang('admin.edit')</div>
        </section>
        <section class="content-container">
            @include('admin.partials.session_messages')
            <form method="POST" class="crud-form">
                @csrf
                <div class="form-group col-md-6" >
                    <label for="name">@lang('admin.Name')</label>
                    <input value="{{$setting->name}}" type="text" class="form-control @error('name') input-error-danger @enderror" id="name" name="name" placeholder="@lang('admin.Name')">
                    @error('name') <span style="color:red">{{$message}}</span>@enderror
                </div>
                <div class="form-group col-md-6" >
                    <label for="name">@lang('admin.Mobile')</label>
                    <input value="{{$setting->mobile}}" type="text" class="form-control @error('mobile') input-error-danger @enderror" id="mobile" name="mobile" placeholder="@lang('admin.Mobile')">
                    @error('mobile') <span style="color:red">{{$message}}</span>@enderror
                </div>
                <div class="form-group col-md-6" >
                    <label for="name">@lang('admin.Email')</label>
                    <input value="{{$setting->email}}" type="email" class="form-control @error('email') input-error-danger @enderror" id="email" name="email" placeholder="@lang('admin.Email')">
                    @error('email') <span style="color:red">{{$message}}</span>@enderror
                </div>
                <div class="form-group col-md-6" >
                    <label for="shipping">@lang('admin.Shipping')</label>
                    <input value="{{$setting->shipping}}" type="number" min="0" step="0.1" class="form-control @error('shipping') input-error-danger @enderror" id="shipping" name="shipping" placeholder="@lang('admin.Shipping')">
                    @error('email') <span style="color:red">{{$message}}</span>@enderror
                </div>
                <div class="form-group col-md-6">
                    <label class="control-label">@lang('admin.Upload image')</label>
                    <div class="dropzone" id="imageUpload">
                        <div class="dz-preview dz-file-preview">
                            <div class="dz-success-mark"><span>✔</span></div>
                            <div class="dz-error-message"><span data-dz-errormessage></span></div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6" >
                    <label for="logo">@lang('admin.Logo')</label>
                    <div>
                        <img class="img-fluid" src="{{ $setting->getRawOriginal('logo') ? Storage::url($setting->logo) : ''}}" id="logo">
                    </div>
                </div>
                <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-primary" style="margin-top:10px">@lang('admin.Save')</button>
                </div>
            </form>
        </section>
    </div>
@endsection
@section('custom_scripts')
    <script src="{{asset('js/dropzone.min.js')}}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        const fireToast = (icon, text) => {
            Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
            }).fire({
                icon: icon,
                title: text
            });
        };
        Dropzone.autoDiscover = false;
        const imagesUploadDropzone = new Dropzone("div#imageUpload", {
            url: '{{ route('admin.settings.logo_upload') }}',
            paramName: "file",
            maxFilesize: 50,
            addRemoveLinks: true,
            acceptedFiles: 'image/*',
            dictInvalidFileType: '@lang("admin.You can only post pictures!")',
            dictFileTooBig: '@lang("admin.Your image is too large!")',
            dictDefaultMessage: '@lang("admin.Drag files here")',
            method: "POST",
            timeout: 0,
            headers: {
                'x-csrf-token': document.querySelector('meta[name="csrf-token"]').getAttributeNode('content').value,
            },
            init: function() {
                this.on("success", function(file, response) {
                    fireToast('success', '@lang("admin.Image was successfully uploaded.")');
                    file.previewElement.remove();
                    document.querySelector('#imageUpload').classList.remove('dz-started');
                    document.querySelector('#logo').src = response.logo;
                });
            },
        });
    </script>
@endsection

