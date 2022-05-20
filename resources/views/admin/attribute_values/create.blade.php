@extends('admin.layout')
@section('custom_css')
    <link href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/themes/classic.min.css"/>
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="content-header-text">@lang('admin.Attribute values') / @lang('admin.create')</div>
        </section>
        <section class="content-container">
            <form method="POST" class="crud-form">
                <input type="hidden" name="color" id="color">
                @csrf
                <div class="form-group col-md-6" >
                    <label for="value">@lang('admin.Value')</label>
                    <input value="{{ old('value') }}" type="text" class="form-control @error('value') input-error-danger @enderror" id="value" name="value" placeholder="@lang('admin.Value')">
                    @error('value') <span style="color:red">{{$message}}</span>@enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="color">@lang('admin.Color')</label>
                    <div class="color-picker"></div>
                </div>
                <div class="form-group col-md-6">
                    <button type="submit" class="btn btn-primary" style="position:absolute; bottom:10%">@lang('admin.Save')</button>
                </div>
            </form>
        </section>
    </div>
@endsection
@section('custom_scripts')
    <script src="https://cdn.jsdelivr.net/npm/@simonwep/pickr/dist/pickr.min.js"></script>
    <script>
        // Simple example, see optional options for more configuration.
        const colorPicker = Pickr.create({
            el: '.color-picker',
            theme: 'classic',

            defaultRepresentation: 'RGBA',
            default: 'transparent',

            components: {
                preview: true,
                opacity: true,
                hue: true,
                interaction: {
                    input: true,
                    save: true
                }
            }
        });
        colorPicker.on('save', function (color, instance){
            instance.hide()
            document.querySelector('input[name="color"]').value = color.toRGBA().toString();
        });
    </script>
@endsection

