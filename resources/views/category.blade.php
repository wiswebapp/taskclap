@extends('layouts.app')

@section('content')
<div class="main-wrapper">

    <div class="bg-img">
        <img src="/assets/img/bg/work-bg-03.png" alt="img" class="bgimg1">
        <img src="/assets/img/bg/work-bg-03.png" alt="img" class="bgimg2">
        <img src="/assets/img/bg/feature-bg-03.png" alt="img" class="bgimg3">
    </div>

    <!-- Breadcrumb -->
    <div class="breadcrumb-bar">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-12">
                    <h2 class="breadcrumb-title">{{ $category->name }}</h2>
                    <nav aria-label="breadcrumb" class="page-breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <!-- /Breadcrumb -->

    <div class="content">
        <div class="container">
            <div class="row">
                <!-- Service -->
                <div class="col-lg-12 col-sm-12">
                    <div class="row sorting-div">
                        <div class="col-lg-4 col-sm-12 ">
                            <div class="count-search">
                                <h6>Found {{ $category->children->count() }} Services</h6>
                                <br>
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <!-- subcategory List -->
                        @foreach ($category->children as $category)
                        @if($category->product->count() > 0)
                        <div class="col-xl-4 col-md-6">
                            <div class="service-widget servicecontent">
                                <div class="service-img">
                                    <a href="{{ route('cart', $category->slug) }}">
                                        <img class="img-fluid serv-img" alt="{{ $category->name }}" src="/storage/uploads/category/{{ $category->image }}">
                                    </a>
                                    <div class="fav-item">
                                        <a><span style="background: #2D4059;color: white;" class="item-cat">₹100 Flat Off</span></a>
                                    </div>
                                </div>
                                <div class="service-content">
                                    <h3 class="title">
                                        <a href="{{ route('cart', $category->slug) }}">{{ $category->name }}</a>
                                    </h3>
                                    <p>Starts From ₹400<span class="rate"><i class="fas fa-star filled"></i>4.9 Rating</span></p>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="col-xl-4 col-md-6">
                            <div class="service-widget servicecontent">
                                <div class="service-img">
                                    <a>
                                        <img class="img-fluid serv-img" alt="{{ $category->name }}" src="/storage/uploads/category/{{ $category->image }}">
                                    </a>
                                    <div class="fav-item">
                                        <a><span class="item-cat" style="background:black; color:white;">Coming Soon</span></a>
                                    </div>
                                </div>
                                <div class="service-content">
                                    <h3 class="title">
                                        <a>{{ $category->name }}</a>
                                    </h3>
                                    <p>Available soon</p>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
