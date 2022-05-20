@extends('admin.layout')
@section('custom_css')
    <style>
        .sortable {
            cursor: pointer;
            user-select: none;
        }
        .sortable {
            position: relative;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="content-header-text">@lang('admin.Products')</div>
            <a href="{{route('admin.products.create')}}" class="content-header-add-item" id="createNew"><i class="fa fa-plus"></i> @lang('admin.NEW PRODUCT')</a>
        </section>
        <section class="content-container">
            @include('admin.partials.session_messages')
            <div class="search-field-container">
                <input id="searchProducts" name="input" value="{{ $_GET['name'] ?? '' }}" class="form-control" style="width:20%" placeholder="@lang('admin.Search products')">
                <a href="{{route('admin.products.stockroom')}}" class="content-header-add-item"><i class="fa fa-truck"></i> @lang('admin.Stockroom')</a>
            </div>
            @if(count($products) > 0)
                <div class="col-md-12">
                    <table id="categoriesTable" style="text-align: center" class="table custom-table">
                        <thead>
                        <tr>
                            <th class="sortable">@lang('admin.ID')</th>
                            <th class="sortable">@lang('admin.Name')</th>
                            <th class="sortable">@lang('admin.Price')</th>
                            <th>@lang('admin.Published')</th>
                            <th class="sortable">@lang('admin.Category')</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr class="{{ $product->name == "Draft" ? 'table-warning' : ''}}">
                                <td>{{$product->id}}</td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->getPrice()}}</td>
                                <td>{{$product->published == 1 ? Lang::get('admin.Yes') : Lang::get('admin.No')}}</td>
                                <td>{{$product->category?->name}}</td>
                                <td class="buttons-cell">
                                    <form style="margin-right: 5px" action="{{ route('admin.products.copy', ['id' => $product->id]) }}" method="POST">
                                        @csrf
                                        <button type="button" class="btn btn-sm btn-secondary" onclick="copyProduct(this)">
                                            <i class="fa fa-copy"></i>
                                        </button>
                                    </form>
                                    <a href="{{route('admin.products.edit', ['id' => $product->id])}}"><button type="button" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i></button></a>
                                    <x-delete-button :route="route('admin.products.destroy', ['id' => $product->id])"></x-delete-button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div>{{ $products->links() }}</div>
                @endif
            </div>
        </section>
    </div>
@endsection
@section('custom_scripts')
    <script>
        document.querySelectorAll('.sortable').forEach((th) => {
            th.addEventListener('click', function (){
                removeSortedFromOthers(this);
                this.classList.add('sortedBy');
                let orderType;
                if(this.classList.contains('desc')){
                    this.classList.remove('desc');
                    this.classList.add('asc');
                    orderType = 'asc';
                }
                else {
                    this.classList.remove('asc');
                    this.classList.add('desc');
                    orderType = 'desc';
                }
                const table = this.closest('table');
                const index = Array.from(this.parentNode.children).indexOf(this);
                const rows = table.querySelectorAll('tbody>tr');

                let values = Array.from(rows).map(row => {
                    return {value: row.children[index].innerText || row.children[index].textContent, row: row.cloneNode(true)}
                });

                values.sort(({value: valueA}, {value: valueB}) => {
                    let result;
                    if(isNaN(valueA) && isNaN(valueB)) result = valueA.toString().localeCompare(valueB);
                    else result = parseFloat(valueA) > parseFloat(valueB) ? 1 : -1;

                    return orderType === 'desc' ? result : -result;
                })

                Array.from(table.querySelector('tbody').children).map((tr, i) => {
                    table.querySelector('tbody').removeChild(tr);
                    table.querySelector('tbody').appendChild(values[i].row);
                })
            });
        })

        const removeSortedFromOthers = (clickedTh) => {
            document.querySelectorAll('.sortable').forEach((th) => th !== clickedTh ? th.classList.remove('sortedBy', 'asc', 'desc') : '');
        }

        document.querySelector('#searchProducts').addEventListener('keydown', function(e){
            if(e.keyCode === 13) location.href = `?name=${this.value}`;
        })
        function copyProduct(_this){
            Swal.fire({
                title: "@lang('admin.Are you sure?')",
                text: '@lang("admin.You will have to manually remove it later!")',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "@lang('admin.Yes, copy it!')"
            }).then((result) => {
                if (result.isConfirmed) {
                    _this.form.submit();
                }
            })
        }
        document.querySelector('a#createNew').addEventListener('click', function(e){
            e.preventDefault();
            const draft = Boolean({{ is_object($draft) }});
            if(draft){
                Swal.fire({
                    title: "@lang('admin.A draft of a product exists!')",
                    text: '@lang("admin.Do you want to open that draft or create a new product?")',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: "@lang('admin.Open it!')",
                    cancelButtonText: "@lang('admin.Create new!')",
                }).then((result) => {
                    if(result.isConfirmed) location.href = '{{ route('admin.products.edit', ['id' => $draft?->id ?? 0 ]) }}';
                    else location.href = this.href;
                })
            }
            else location.href = this.href;
        })
    </script>
@endsection

