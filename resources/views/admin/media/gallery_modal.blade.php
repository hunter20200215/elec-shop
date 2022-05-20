<div class="modal fade" id="mediaGallery">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('admin.Media gallery')</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="modalBody">
                @include('admin.media.media_gallery', ['dropzone_class'=>'col-md-12', 'label_class' => 'col-md-12'])
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary btn-md" id="addImageButton" disabled>@lang('admin.Select image(s)')</button>
            </div>
        </div>
    </div>
</div>
