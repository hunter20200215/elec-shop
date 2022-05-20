@extends('admin.layout')
@section('custom_css')
    <link rel="stylesheet" href="{{asset('css/dropzone.min.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css" rel="stylesheet">
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="content-header-text">@lang('admin.Pages') / @lang('admin.edit')</div>
        </section>
        <section class="content-container">
            <form method="POST" class="crud-form" action="">
                @csrf
                <div class="form-group col-md-6" >
                    <label for="title">@lang('admin.Title')</label>
                    <input type="text" class="form-control @error('title') input-error-danger @enderror" id="title" name="title" value="{{ $page->title }}" placeholder="@lang('admin.Title')">
                    @error('title') <span style="color:red">{{$message}}</span>@enderror
                </div>
                <div class="form-group col-md-6" >
                    <label for="published">@lang('admin.Active')</label>
                    <div class="col-md-6" style="margin-top: 5px">
                        <div class="pretty p-default p-round p-thick">
                            <input type="radio" name="status" value="1" {{ $page->status === 1 ? 'checked' : '' }} />
                            <div class="state p-primary-o">
                                <label>@lang('admin.Yes')</label>
                            </div>
                        </div>
                        <div class="pretty p-default p-round p-thick">
                            <input type="radio" name="status" value="0" {{ $page->status === 0 ? 'checked' : '' }} />
                            <div class="state p-primary-o">
                                <label>@lang('admin.No')</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6" >
                    <label for="content">@lang('admin.Content')</label>
                    <textarea id="content" name="content">{{ $page->content }}</textarea>
                    @error('content') <span style="color:red">{{$message}}</span>@enderror
                </div>
                <div class="form-group col-md-6">
                    <label class="control-label">@lang('admin.Upload background image')</label>
                    <div class="dropzone" id="imageUpload">
                        <div class="dz-preview dz-file-preview">
                            <div class="dz-success-mark"><span>✔</span></div>
                            <div class="dz-error-message"><span data-dz-errormessage></span></div>
                        </div>
                    </div>
                </div>
                <div class="form-group col-md-6" >
                    <label for="background_image">@lang('admin.Background image')</label>
                    <div>
                        <img class="img-fluid" src="{{ $page->background_image
                            ? Storage::url('/pages/' . $page->background_image)
                            : Storage::url('imagePlaceholder.png') }}"
                             id="backgroundImage"
                        >
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
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <script src="{{asset('js/dropzone.min.js')}}"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        CKEDITOR.replace('content', {
            maxHeight: 500,
            minHeight: 150,
            toolbar: [
                {
                    name: 'clipboard',
                    items: ['Undo', 'Redo', 'clipboard']
                },
                {
                    name: 'styles',
                    items: ['Format', 'Font', 'FontSize']
                },
                {
                    name: 'colors',
                    items: ['TextColor', 'BGColor']
                },
                {
                    name: 'align',
                    items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock']
                },
                '/',
                {
                    name: 'basicstyles',
                    items: ['Bold', 'Italic', 'Underline', 'Strike', 'RemoveFormat', 'CopyFormatting']
                },
                {
                    name: 'links',
                    items: ['Link', 'Unlink']
                },
                {
                    name: 'paragraph',
                    items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote']
                },
                {
                    name: 'tools',
                    items: ['Maximize']
                }
            ]
        });
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
            url: '{{ route('admin.pages.change_background_image') }}',
            paramName: "file",
            maxFilesize: 200,
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
            sending: function(file, xhr, formData) {
                formData.append('page_id', '{{ $page->id }}');
            },
            init: function() {
                this.on("success", function(file, response) {
                    fireToast('success', '@lang("admin.Image was successfully uploaded.")');
                    file.previewElement.remove();
                    console.log(response);
                    document.querySelector('#imageUpload').classList.remove('dz-started');
                    document.querySelector('#backgroundImage').src = response.url;
                });
            },
        });
    </script>
@endsection

