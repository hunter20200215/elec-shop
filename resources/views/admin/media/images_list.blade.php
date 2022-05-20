@if(sizeof($images) > 0)
    <label class="col-md-12 control-label" style="font-weight: bold!important; margin-bottom: 10px; margin-top: 10px">@lang('admin.Image gallery')</label>
    <div class="col-md-12" style="display: flex; flex-direction: row; justify-content: space-between; flex-wrap: wrap;">
        @php $counter = 0; @endphp
        @foreach($images as $image)
            <div class="image-container image-gallery">
                <img class="mediaGalleryImage" id="{{ $image->id }}" src="{{Storage::url($image->getDimensionPath('preview'))}}" data-src="{{Storage::url($image->getDimensionPath('preview'))}}" data-id="{{$image->id}}">
                <button class="btn btn-danger delete-button" onclick="deleteImage({{$image->id}})"><i class="fa fa-trash"></i></button>
                <a href="{{Storage::url($image->getDimensionPath('l'))}}" data-fslightbox="gallery-{{$page}}" class="preview-button"><button type="button" class="btn btn-info"><i class="fa fa-search"></i></button></a>
            </div>
            @php $counter++; @endphp
            @if($counter % 4 == 0) <div class="clearfix"></div> @endif
        @endforeach
    </div>
    <div class="row">
        <div class="col-xs-12 text-center">
            @if($pages_num > 1)
                <ul class="pagination" id="pagination" role="navigation">
                    <li class="page-item {{ $page == 1 ? "disabled" : 'clickable' }}" aria-disabled="true" data-page="{{ ($page-1) }}" aria-label="@lang('pagination.previous')">
                        <span class="page-link" aria-hidden="true">&laquo;</span>
                    </li>
                    @if($pages_num<7)
                        @for($i=1; $i<=$pages_num; $i++) <li class="page-item clickable {{ $i==$page ? "active" : "" }}" data-page="{{ $i }}"><span class="page-link">{{ $i }}</span></li> @endfor
                    @else
                        @php $first_pages=7; $last_pages=3; $per_side=2;@endphp
                        @if($page >= $first_pages)
                            <li class="page-item clickable" data-page="1"><span class="page-link">1</span></li>
                            <li class="page-item clickable" data-page="2"><span class="page-link">2</span></li>
                            <li class="page-item clickable" data-page="3"><span class="page-link">3</span></li>
                            <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
                            @for($i=$page-$per_side; $i<=$page+$per_side; $i++)
                                @if($i > $pages_num-$last_pages) @break @endif
                                <li class="page-item clickable {{ $i==$page ? "active" : "" }}" data-page="{{ $i }}"><span class="page-link">{{ $i }}</span></li>
                            @endfor
                            @if($page < ($pages_num-$last_pages-$per_side))
                                <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
                            @endif
                            @for($i=$pages_num-2; $i<=$pages_num; $i++)
                                <li class="page-item clickable {{ $i==$page ? "active" : "" }}" data-page="{{ $i }}"><span class="page-link">{{ $i }}</span></li>
                            @endfor
                        @else
                            @for($i=1; $i<=$first_pages; $i++)
                                <li class="page-item clickable {{ $i==$page ? "active" : "" }}" data-page="{{ $i }}"><span class="page-link">{{ $i }}</span></li>
                            @endfor
                            @if($pages_num > $first_pages+$last_pages)
                                <li class="page-item disabled" aria-disabled="true"><span class="page-link">...</span></li>
                            @endif
                            @for($i=$pages_num-2; $i<=$pages_num; $i++)
                                @if($i <= $first_pages) @continue @endif
                                <li class="page-item clickable {{ $i==$page ? "active" : "" }}" data-page="{{ $i }}"><span class="page-link">{{ $i }}</span></li>
                            @endfor
                        @endif
                    @endif
                    <li class="page-item {{ $page == $pages_num ? "disabled" : 'clickable' }}" data-page="{{ ($page+1) }}" aria-disabled="true" aria-label="@lang('pagination.next')">
                        <span class="page-link" aria-hidden="true">&raquo;</span>
                    </li>
                </ul>
            @endif
        </div>
    </div>
@endif

