@extends('adminlte::page')
@section('title', 'Order Detail | ' . $order->order_id)
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.AdminCustom', true)

@section('content_header')
<style>
    .select2-container{
        width: 100%!important;
    }
</style>
<div class="card">
    <div class="card-header">
        <div class="float-left">
            <h1>Order Detail</h1>
        </div>
        <div class="float-right">
            <a href="{{ route('admin.orders') }}" class="btn btn-default"><i class="fa fa-arrow-alt-circle-left"></i> Back</a>
        </div>
    </div>
</div>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        @include('layouts.alert-msg')
        <div class="row">
            <!-- Manage Order -->
            @if(in_array($order->order_status, ['Placed', 'Pending']))
            <div class="col-md-12">
                <div class="card card-outline card-danger">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-cog"></i> Manage Order</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <form action="{{ route('admin.orders.detail', $order) }}" method="post" class="form-group">
                    <div class="card-body row" style="padding-bottom: 0px;">
                        @csrf
                        <input type="hidden" name="type" value="order_status">
                        @if(in_array($order->order_status, ['Placed', 'Pending']))
                        <div class="form-group col-md-3">
                            <label>Change Order Status To</label>
                            <select class="form-control select2" name="order_status">
                                <option value="" disabled selected>Select Order Status</option>
                                @foreach($orderStatus as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        @if(in_array($order->payment_status, ['Started', 'Pending']))
                        <div class="form-group col-md-3">
                            <label>Change Payment Status To</label>
                            <select class="form-control select2" name="payment_status">
                                <option value="" disabled selected>Select Payment Status</option>
                                @foreach($paymentStatus as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        @if(in_array($order->payment_status, ['Started', 'Pending']))
                        <div class="form-group col-md-3">
                            <label>Payment Type</label>
                            <select class="form-control select2" name="payment_type">
                                <option value="" disabled selected>Select Payment Type</option>
                                @foreach(['Upi', 'NetBanking', 'Cash'] as $status)
                                <option value="{{ $status }}">{{ $status }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <div class="form-group col-md-3">
                            <label>&nbsp;</label>
                            <div class="form-group">
                                <input type="submit" class="btn btn-default" value="Change Status">
                            </div>
                        </div>
                    </div>
                </form>
                </div>
            </div>
            @endif

            <!-- User Details -->
            <div class="col-md-6">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fa fa-user"></i> Customer Detail</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <tbody>
                                <tr><th>Name</th><td>{{ $order->name }}</td></tr>
                                <tr><th>Phone</th><td>{{ $order->phone }}</td></tr>
                                <tr><th>Email</th><td>{{ ($order->email) ? $order->email : '--' }}</td></tr>
                                @if($order->user->address_lat && $order->user->address_long)
                                <tr><th>Address (Map)</th><td>{{ $order->user->address_lat }},{{ $order->user->address_long }}</td></tr>
                                @else
                                <tr><th>Address</th><td>--</td></tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Provider Details -->
            <div class="col-md-6">
                <div class="card card-outline card-warning">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-users-cog"></i> Provider Detail</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($order->provider)
                        <table class="table table-bordered">
                            <tbody>
                                <tr><th>Name</th><td>{{ $order->provider->name }}</td></tr>
                                <tr><th>Phone</th><td>{{ $order->provider->phone }}</td></tr>
                                <tr><th>Email</th><td>{{ $order->provider->email }}</td></tr>
                                <tr><th>Address</th><td>{{ $order->provider->address }}</td></tr>
                            </tbody>
                        </table>
                        @else
                        <h4>No Provider assigned yet !</h4>
                        <button class="btn btn-success btn-sm" id="assignProviderBtn" data-toggle="modal" data-target="#assignProviderMdl">Assign Now</button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Details
            <div class="col-md-12">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-archive"></i> Order Detail</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    @foreach ($order->orderDetail as $orderDetail)
                    <div class="card-body">
                        <h4 class="text-danger">Purchased Product {{$loop->iteration}}</h4>
                        <table class="table table-bordered">
                            <tbody>
                                <tr colspan="4">
                                    <th>Product Title</th><td colspan="4">{{ $orderDetail->product_title }}</td>
                                </tr>
                                <tr>
                                    <th>Product Description</th><td colspan="4">{!! $orderDetail->product_description !!}</td>
                                </tr>
                                <tr>
                                    <th>Strike Price</th><td><del>{{ $orderDetail->product_strike_price }}</del></td>
                                    <th>Actual Price</th><td>{{ $orderDetail->product_price }}</td>
                                </tr>
                                <tr>
                                    <th>Product Commission</th><td>{{ $orderDetail->product_commission }} %</td>
                                    <th>Service Duration (in time)</th><td>{{ $orderDetail->product_approx_duration }}</td>
                                </tr>
                                <tr>
                                    <th>Warranty (in time)</th><td>{{ $orderDetail->warranty }} Days</td>
                                    <th>Status</th><td><span class="badge badge-{{($orderDetail->product->status == "Active") ? 'success' : 'danger' }}">{{ $orderDetail->product->status }}</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    @endforeach
                </div>
            </div> -->

            <!-- Invoice Details -->
             <div class="col-md-12">
                <div class="card card-outline card-info">
                    <div class="card-header">
                        <h3 class="card-title"><i class="fas fa-file-invoice"></i> Invoice Detail</h3>
                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="card-body" id="printable-invoice">
                        <div class="row" style="margin-bottom: 6em;">
                            <div class="col-12 table-responsive">
                                <div class="row invoice-info">

                                    <div class="col-sm-4 invoice-col">
                                        <b>Order ID:</b> #{{ $orderDetail->order }}<br>
                                        <b>Order Date:</b> {{ formatDt($orderDetail->created_at) }}
                                    </div>

                                    <div class="col-sm-5 invoice-col">

                                    </div>

                                    <div class="col-sm-3 invoice-col">
                                        To
                                        <address>
                                            <strong>{{ $order->user->name }}</strong><br>
                                            {{ $order->user->house_no }}, {{ $order->user->landmark }}<br>
                                            {{ $order->user->address }}<br>
                                            <span class="text-bold">Phone: </span> {{ $order->user->phone }}<br>
                                            <span class="text-bold">Email: </span> {{ ($order->user->email) ? $order->user->email : 'n/a' }}
                                        </address>
                                    </div>

                                </div>
                                <p class="btn btn-sm">{{ $orderDetail->product->category->name }} <i class="fa fa-sm fa-arrow-right"></i> {{ $orderDetail->product->subcategory->name }}</p>
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th style="width: 20%;">Product</th>
                                            <th style="width: 60%">Description</th>
                                            <th style="width: 10%;">Warranty</th>
                                            <th style="width: 10%;">Price</th>
                                            @if($order->order_status == "Pending" && (empty($orderDetail->material_charge) || empty($orderDetail->additional_charge)))
                                            <th>Action</th>
                                            @endif
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order->orderDetail as $orderDetail)
                                            <tr style="background:#b0b0b0">
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{ $orderDetail->product_title }}</td>
                                                <td>-</td>
                                                <td>{{ $orderDetail->warranty }} Days</td>
                                                <td>₹ {{ $orderDetail->product_price }}</td>
                                                @if($order->order_status == "Pending")
                                                <td>
                                                    @if($orderDetail->material_charge === null)
                                                    <button data-id="{{ $orderDetail->id }}" class="btn btn-sm btn-default addMaterialCharge"><i class="fa fa-plus fa-sm"></i> Material Charges</button><br>
                                                    @endif
                                                    @if($orderDetail->additional_charge === null)
                                                    <button data-id="{{ $orderDetail->id }}" class="btn btn-sm btn-default addAdditionalCharge"><i class="fa fa-plus fa-sm"></i> Additional Charges</button>
                                                    @endif
                                                </td>
                                                @endif
                                            </tr>
                                            @if($orderDetail->material_description)
                                            <tr>
                                                <td></td>
                                                <td>Material Charges</td>
                                                <td>
                                                    <textarea style="width: 100%;border:none;resize: none;pointer-events: none;" readonly>{{$orderDetail->material_description}}</textarea>
                                                </td>
                                                <td>{{ $orderDetail->warranty }} Days</td>
                                                <td>₹ {{ $orderDetail->material_charge }}</td>
                                            </tr>
                                            @endif
                                            @if($orderDetail->additional_charge_description)
                                            <tr>
                                                <td></td>
                                                <td>Additional Charges</td>
                                                <td>
                                                    <textarea style="width: 100%;border:none;resize: none;pointer-events: none;" readonly>{{ $orderDetail->additional_charge_description }}</textarea>
                                                </td>
                                                <td>{{ $orderDetail->warranty }} Days</td>
                                                <td>₹ {{ $orderDetail->additional_charge }}</td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p>Order Status : <span class="text-bold">{{ $order->order_status }}</span></p>
                                <p>Payment Status: <span class="text-bold">{{ $order->payment_status }}</span></p>
                                <p>Payment Type : <span class="text-bold">{{ $order->payment_type }}</span></p>
                                @if($order->payment_type == "Cash")
                                <img src="<?= asset('assets/img/payment/cash.png') ?>" alt="Cash" style="height: 30px;">
                                @elseif($order->payment_type == "Upi")
                                <img src="<?= asset('assets/img/payment/upi.png') ?>" alt="Cash" style="height: 30px;">
                                @elseif($order->payment_type == "NetBanking")
                                <img src="<?= asset('assets/img/payment/net_banking.png') ?>" alt="Cash" style="height: 32px;">
                                @else
                                <img src="<?= asset('assets/img/payment/pending.jpg') ?>" alt="Cash" style="height: 40px;">
                                @endif
                                <p class="text-bold well well-sm shadow-none" style="margin: 2.6em 0 0 0;">Notes :</p>
                                <ul class="px-3">
                                    <li>Warranty will be covered only on changed parts.</li>
                                    <li>No warrant will be covered on existing parts.</li>
                                    <li>Please ask to provider for list of covered.</li>
                                </ul>
                            </div>
                            <div class="col-6">
                                <div class="table-responsive">
                                    <table class="table">
                                        <tbody>
                                            <tr>
                                                <th style="width:50%">Subtotal:</th>
                                                <td>₹ {{ $order->subtotal }}</td>
                                            </tr>
                                            <tr>
                                                <th>Material Charges Total</th>
                                                <td>₹ {{ ($order->material_charge_amount_total) ? formatNumber($order->material_charge_amount_total) : "0.00" }}</td>
                                            </tr>
                                            <tr>
                                                <th>Additional Charges Total</th>
                                                <td>₹ {{ ($order->additional_charge_amount_total) ? formatNumber($order->additional_charge_amount_total) : "0.00" }}</td>
                                            </tr>
                                            <tr>
                                                <th>Discount</th>
                                                <td>₹ {{ ($order->discount) ? formatNumber($order->discount) : "0.00" }}</td>
                                            </tr>
                                            <tr>
                                                <th>Tax (0%)</th>
                                                <td>₹ {{ ($order->tax) ? formatNumber($order->tax) : "0.00" }}</td>
                                            </tr>
                                            <tr style="background: rgba(0,0,0,.05);">
                                                <th>Total:</th>
                                                <td><strong>₹ {{ $order->total }}</strong></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <div class="row no-print">
                            <div class="col-12">
                                <button onclick="printInvoice()" class="btn btn-default"><i class="fas fa-print"></i>Print</button>
                                <button type="button" class="btn btn-primary float-right" style="margin-right: 5px;">
                                    <i class="fas fa-download"></i> Download
                                </button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="assignProviderMdl">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.orders.detail', $order) }}" method="POST">
            <div class="modal-header">
                <h4 class="modal-title">Assign Service Provider</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @csrf
                <input type="hidden" name="type" value="assign_provider">
                <select name="provider_id" class="select2 form-control" required>
                    <option value="" selected disabled>Select Provider</option>
                    @foreach($providerList as $provider)
                    <option value="{{ $provider->id }}">{{ $provider->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Assign Now</button>
            </div>
        </form>
        </div>
    </div>
</div>
<div class="modal fade" id="addChargesMdl">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.orders.detail', $order) }}" method="POST">
                <input type="hidden" name="orderDetailId" id="orderDetailId">
                <div class="modal-header">
                    <h4 class="modal-title">Add Charges Detail</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @csrf
                    <input type="hidden" id="chargeType" name="type" value="">
                    <div class="chargeModalInput"></div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary chargeTypeBtn"></button>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
function printInvoice() {
    var printContents = document.getElementById("printable-invoice").innerHTML;
    var originalContents = document.body.innerHTML;
    document.body.innerHTML = printContents;
    window.print();
    document.body.innerHTML = originalContents;
}
</script>
@endsection
