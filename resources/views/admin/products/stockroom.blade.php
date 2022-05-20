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

        .sortable::before,
        .sortable::after {
            position: absolute;
            right: 0.75em;
            font-family: 'Font Awesome 5 Pro';
            opacity: 0.3;
        }

        .sortable::before {
            content: '\f0de';
            top: calc(50% - 0.75em);
        }

        .sortable::after {
            content: '\f0dd';
            bottom: calc(50% - 0.75em);
        }

        .sortable.asc::before,
        .sortable.desc::after {
            opacity: 1;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="content-header-text">@lang('admin.Products stockroom')</div>
        </section>
        <section class="content-container">
            @include('admin.partials.session_messages')
            <div class="search-field-container">
                <input id="searchProducts" name="input" value="{{ $_GET['name'] ?? '' }}" class="form-control" style="width:20%" placeholder="@lang('admin.Search products')">
            </div>
            @if(count($products) > 0)
                <div class="col-md-12">
                    <table id="categoriesTable" style="text-align: center" class="table custom-table">
                        <thead>
                        <tr>
                            <th class="sortable">@lang('admin.ID')</th>
                            <th class="sortable">@lang('admin.Name')</th>
                            <th class="sortable">@lang('admin.Price')</th>
                            <th class="sortable">@lang('admin.Quantity')</th>
                            <th class="sortable">@lang('admin.GBV')</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($products as $product)
                            <tr class="{{ $product->name == "Draft" ? 'table-warning' : ''}}">
                                <td>{{$product->id}}</td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->getPrice()}}</td>
                                <td>{{$product->quantity }}</td>
                                <td>{{ $product->getGBV() }}</td>
                                <td class="buttons-cell">
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
    </script>
@endsection

