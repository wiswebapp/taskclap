@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="booking-done">
                    <h6>Successfully Completed Payment</h6>
                    <p>Your Booking has been Successfully Competed</p>
                    <div class="book-submit">
                        <a href="{{ route('homepage') }}" class="btn btn-primary"><i class="feather-home"></i> Go to
                            Home</a>
                        <a href="{{ route('homepage') }}" class="btn btn-secondary">Booking History</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="booking-done">
                    <img src="/assets/img/booking-done.png" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
