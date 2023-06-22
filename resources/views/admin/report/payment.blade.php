@extends('adminlte::page')
@section('title', 'Payment Report')
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('plugins.Select2', true)
@section('plugins.AdminCustom', true)

@section('content_header')
<h1>Payment Report</h1>
@stop

@section('content')
<div class="card">
    @include('layouts.alert-msg')
    <form action="{{route('admin.report.payment')}}">
        <div class="card-body row">
            <div class="form-group col-md-2">
                <label>Filter By Order Number</label>
                <input type="text" name="order" value="{{ $params['order'] }}" class="form-control" placeholder="Enter Order No">
            </div>
            <div class="form-group col-md-3">
                <button class="btn btn-default filter-search"><i class="fa fa-search"></i></button>
                <a href="{{ route('admin.report.payment') }}" class="btn btn-default filter-search"><i
                        class="fas fa-undo"></i></a>
            </div>
        </div>
    </form>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered" id="data-table">
            <thead>
                <tr style="font-size: 13px;">
                    <th>Order No</th>
                    <th>Service Provider</th>
                    <th>Order Date</th>
                    <th>Order Total</th>
                    <th>Order Commission</th>
                    <th>Order Tax</th>
                    <th>SP Pay Amount</th>
                    <th>Site Earning</th>
                    <th>Order Status</th>
                    <th>Payment Method</th>
                    <th>Paid To Provider</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($pageData as $order)
                <tr>
                    <td>{{ $order->order_id }}</td>
                    <td>{{ $order->provider->name}}</td>
                    <td>{{ date('d-m-Y', strtotime($order->created_at)) }}</td>
                    <td>₹ {{ $order->total }}</td>
                    <td>₹ {{ getOrderCommission($order) }}</td>
                    <td>₹ {{ ($order->tax) ? $order->tax : '0.00' }}</td>
                    <td>₹ {{ (($order->total - getOrderCommission($order)) - $order->material_charge_actual) }}</td>
                    <td>₹ {{ (getOrderCommission($order) - $order->tax) }}</td>
                    <td>{{ generate_badge($order->order_status) }}</td>
                    <td><span class='badge badge-info'>{{ $order->payment_type }}<span></td>
                    <td>
                        @if($order->is_paid_to_provider == "Yes")
                        {{ generate_badge($order->is_paid_to_provider) }}
                        @else
                        <form action="{{ route('admin.orders.detail', $order) }}" method="POST">
                            @csrf
                            <input type="hidden" value="mark_as_paid_for_provider" name="type">
                            <button class="btn btn-sm btn-default">Mark As Paid</button>
                        </form>

                        @endif
                    </td>
                </tr>
                @empty
                <th colspan="14" style="text-align: center"><h4>No Orders found !</h4></th>
                @endforelse
            </tbody>
            <tfoot>
                <tr style="font-size: 13px;">
                    <th>Order No</th>
                    <th>Service Provider</th>
                    <th>Order Date</th>
                    <th>Order Total</th>
                    <th>Order Commission</th>
                    <th>Order Tax</th>
                    <th>SP Pay Amount</th>
                    <th>Site Earning</th>
                    <th>Order Status</th>
                    <th>Payment Method</th>
                    <th>Paid To Provider</th>
                </tr>
            </tfoot>
        </table>
        <div class="mt-4 float-right">
            {{ $pageData->links() }}
        </div>
    </div>
</div>
@stop

@section('js')
<x-alert-msg />
<script>
$(document).ready(function() {
    $(".fa-bars").click();
});
</script>
@stop
