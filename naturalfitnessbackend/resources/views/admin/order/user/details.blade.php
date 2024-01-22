@extends('admin.layouts.app', ['isNavbar' => true, 'isSidebar' => true, 'isFooter' => true])
@push('styles')
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
@endpush
@section('content')
    @php
        $total=0;
        $detailedStatus = collect($order->status_description);
    @endphp
    <div class="container-fluid">
        <div class="card shadow order-card">
            <div class="card-header">
                <div class="d-flex">
                    <h1 class="col-6 m-0">Order Details</h1>
                    <div class="col-6 text-right">
                        <a href="{{ route('admin.order.user.list') }}" class="btn btn-warning btn-icon-split">
                            <span class="icon text-white-50">
                                <i class="fas fa-arrow-left"></i>
                            </span>
                            <span class="text">Back</span>
                        </a>
                    </div>
                </div>
                <div class="mt-2 border rounded font-weight-bold">
                    <div class="d-flex">
                        <h5 class="col-4 m-0 font-weight-bold">Tracking No:- <code>{{ $order->order_no }}</code> </h5>
                        <h5 class="col-4 m-0 font-weight-bold">Address:- <code>{{ implode(',',$order->orderAddress?->full_address) }}</code> </h5>
                        <h5 class="col-4 m-0 font-weight-bold">Ordered By:- <code>{{$order->user?->full_name }}</code> </h5>
                    </div>
                    <hr>
                    <div class="d-flex ">
                        <h5 class="col-6 m-0 font-weight-bold">Ordered At:- <code>{{ \Carbon\Carbon::parse($order->created_at)->format('M d , Y \\a\\t\\ H:i:s') }}</code> </h5>
                        <h5 class="col-6 m-0 font-weight-bold">Expected Delivery:- <code>{{ \Carbon\Carbon::parse($order->created_at)->addDays(10)->format('M d , Y \\a\\t\\ H:i:s') }}</code> </h5>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="col-lg-12 mb-2">
                    <div class="p-3">
                        <form class="user formSubmit fileUpload" enctype="multipart/form-data" method="post" action="{{ route('admin.order.user.change.status', $order->uuid) }}" id="orderSubmit">
                            @csrf
                            <div class="row d-flex justify-content-center">
                                <div class="col-12">
                                    <ul id="progressbar" class="text-center">
                                        @for($i=0;$i<=4;$i++)
                                            <li class="step0 @if ( $i<= $order->delivery_status) active @endif"></li>
                                        @endfor
                                    </ul>
                                </div>
                            </div>
                            <div class="row justify-content-between top">
                                <div class="row d-flex icon-content">
                                    <img class="order-icon" src="{{ asset('assets/images/process.png') }}" alt="">
                                    <div class="d-flex flex-column font-weight-bold">
                                        <p class="@if ($order->status == 0) font-weight-bolder text-success @endif">Order<br>Processed</p>
                                    </div>
                                </div>
                                <div class="row d-flex icon-content">
                                    <img class="order-icon" src="{{ asset('assets/images/packed.png') }}" alt="">
                                    <div class="d-flex flex-column font-weight-bold">
                                        <p class="@if ($order->status == 1) font-weight-bolder text-success @endif">Order<br>Packed</p>
                                    </div>
                                </div>
                                <div class="row d-flex icon-content">
                                    <img class="order-icon" src="{{ asset('assets/images/shipped.png') }}" alt="">
                                    <div class="d-flex flex-column">
                                        <p class="font-weight-bold">Order<br>Shipped</p>
                                    </div>
                                </div>
                                <div class="row d-flex icon-content">
                                    <img class="order-icon" src="{{ asset('assets/images/outfordelivery.png') }}" alt="">
                                    <div class="d-flex flex-column">
                                        <p class="font-weight-bold">Order<br>En Route</p>
                                    </div>
                                </div>
                                <div class="row d-flex icon-content">
                                    <img class="order-icon" src="{{ asset('assets/images/delivered.png') }}" alt="">
                                    <div class="d-flex flex-column">
                                        <p class="font-weight-bold">Order<br>Arrived</p>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row col-lg-12">
                    @forelse ($order->details as $detail)
                        <div class="d-flex border rounded col-12 mb-2">
                            <div class="col-3">
                                <label class="form-label font-weight-bold">Product Name:-</label><br>
                                <span>
                                    {{ $detail->product->name }}
                                </span>
                            </div>
                            <div class="col-3">
                                <label class="form-label font-weight-bold">Product Price:-</label><br>
                                <span>
                                    ${{ $detail->discounted_price }}
                                </span>
                            </div>
                            <div class="col-3">
                                <label class="form-label font-weight-bold">Product Quantity:-</label><br>
                                <span>
                                    {{ $detail->quantity }}
                                </span>
                            </div>
                            <div class="col-3">
                                <label class="form-label font-weight-bold">Total Price:-</label><br>
                                <span>
                                    {{ $detail->quantity*$detail->discounted_price }}
                                </span>
                            </div>

                        </div>
                    @empty
                    @endforelse
                    <div class="d-flex border rounded col-12 mb-2 text-right">
                        <div class="col-6">
                            <label class="form-label font-weight-bold">Shipping Cost:-</label>
                            <span>
                                ${{ $detail->sum('shipping_cost') }}
                            </span>
                        </div>
                        <div class="col-6">
                            <label class="form-label font-weight-bold">Total Price:-</label>
                            <span>
                                ${{ $order->total + $detail->sum('shipping_cost')}}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
@endpush
