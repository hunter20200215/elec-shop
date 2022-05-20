@extends('admin.layout')
@section('custom_css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css"/>
    <style>
        .accordion-button::after{
            margin-left:unset;
        }
        .accordion-button{
            width: unset;
        }
        .accordion-button:not(.collapsed) {
            color:black;
            background-color: transparent;
            box-shadow: none;
        }
    </style>
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="content-header-text">@lang('admin.Orders')</div>
        </section>
        <section class="content-container" style="overflow-x: unset; overflow-y: unset">
            @include('admin.partials.session_messages')
            <div class="col-md-12">
                <div style="padding:5px; width: 100%;  display: flex;
            justify-content: space-between;
            align-items: center;
            align-content: center;
            border-bottom: 2px solid #dddddd !important;
            color: #3379b7;
            margin-bottom: 10px">
                    <div class="col-md-2" style="font-weight: bold">@lang('admin.ID')</div>
                    <div class="col-md-2"  style="font-weight: bold">@lang('admin.User')</div>
                    <div class="col-md-2"  style="font-weight: bold">@lang('admin.Price')</div>
                    <div class="col-md-2"  style="font-weight: bold">@lang('admin.Order date')</div>
                    <div class="col-md-2"  style="font-weight: bold">@lang('admin.Status')</div>
                    <div class="col-md-1"  style="font-weight: bold">@lang('admin.Actions')</div>
                    <div class="col-md-1"  style="font-weight: bold"></div>
                </div>
                <div class="accordion"  id="ordersAccordion">
                    @foreach($orders as $order)
                        <div class="accordion-item" style="margin-bottom: 20px; border-top: 1px solid rgba(0,0,0,.125);">
                            <h2 class="accordion-header" style="display: flex;align-items:center;font-size:12pt; padding: 5px;border-bottom: 1px solid rgba(0,0,0,.125)" id="heading_{{$order->id}}">
                                <div class="col-md-2">{{$order->getIDWithYear()}}</div>
                                <div class="col-md-2">{{$order->getUser()}}</div>
                                <div class="col-md-2">{{$order->getPrice()}}</div>
                                <div class="col-md-2">{{\Carbon\Carbon::parse($order->order_date)->format('d.m.Y')}}</div>
                                <div class="col-md-2">
                                    <div class="col-md-8">
                                        <select class="select-picker" name="status" id="status" data-order-id="{{ $order->id }}">
                                            <option value="1" @if($order->status === 1) selected @endif>
                                                @lang('admin.Paid')
                                            </option>
                                            <option value="2" @if($order->status === 2) selected @endif>
                                                @lang('admin.Shipped')
                                            </option>
                                            <option value="3" @if($order->status === 3) selected @endif>
                                                @lang('admin.Delivered')
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-1">
                                    <x-delete-button :route="route('admin.orders.destroy', ['id' => $order->id])"></x-delete-button>
                                </div>
                                <div class="accordion-button col-md-1 {{ $loop->iteration === 1 ? '' : 'collapsed'}}" type="button" data-bs-toggle="collapse" data-bs-target="#collapse_{{$order->id}}" aria-expanded="false" aria-controls="collapse_{{$order->id}}">
                                </div>
                            </h2>
                            <div id="collapse_{{$order->id}}" class="accordion-collapse collapse {{ $loop->iteration === 1 ? 'show' : ''}}" aria-labelledby="heading_{{$order->id}}">
                                <div class="accordion-body">
                                    <table class="table" id="orderItemsTable">
                                        <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">@lang('front.Product')</th>
                                            <th scope="col">@lang('admin.SKU')</th>
                                            <th scope="col">@lang('front.Quantity')</th>
                                            <th scope="col">@lang('front.Price')</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($order->order_items as $order_item)
                                            <tr>
                                                <th scope="row">{{$loop->iteration}}</th>
                                                <td>{{$order_item->product->name}}</td>
                                                <td>{{$order_item->product->sku}}</td>
                                                <td>{{$order_item->quantity}}</td>
                                                <td>{{$order_item->getPrice()}}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    <div class="form-group" >
                                        <label class="col-form-label" style="font-weight: bold;">@lang('admin.Note'):</label>
                                        {{$order->note}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div>{{ $orders->links() }}</div>
            </div>
        </section>
    </div>
@endsection
@section('custom_scripts')
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
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
        const statusSelects = document.querySelectorAll('select#status');
        [...statusSelects].map((element) => {
            new Choices(element, {
                placeholder: true,
                itemSelectText: '@lang('admin.Click to select item')',
                shouldSort: false,
            });
        })

        statusSelects.forEach((select) => {
            select.addEventListener('change', function (e) {
                axios.post('{{ route('admin.orders.change_status') }}', {
                    headers: {
                        'x-csrf-token': document.querySelector('meta[name="csrf-token"]').getAttributeNode('content').value,
                    },
                    data: {
                        'id': this.dataset.orderId,
                        'status': this.value
                    }
                }).then(() => fireToast('success', '@lang("admin.Status successfully changed.")'), (error) => fireToast('error', 'ERROR'));
            });
            select.addEventListener('showDropdown', function (e) {
                e.stopPropagation();
            });
        });
    </script>
@endsection

