@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-10 mx-auto">
        <div class="row align-items-center">
            <div class="col-md-6">
                <div class="booking-done">
                    <h6>Whoops !</h6>
                    <p>Something went wrong in your order. We've note down this and we are working on this.</p>
                    <p>Kindly Contact on <a href="mailto:taskclap@gmail.com">taskclap@gmail.com.</a></p>
                    <div class="book-submit">
                        <a href="{{ route('homepage') }}" class="btn btn-primary"><i class="feather-home"></i> Go to Home</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="booking-done">
                    <img src="/assets/img/coming-soon.png" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
