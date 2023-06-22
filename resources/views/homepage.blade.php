@extends('layouts.app')

@section('content')

<!-- Banner Section -->
@include('layouts.home-banner')
<!-- /Banner Section -->

<!-- Feature Section -->
<section class="feature-section">
    <div class="container">
        <div class="section-heading">
            <div class="row">
                <div class="col-md-6 aos" data-aos="fade-up">
                    <h2>Featured Services</h2>
                    <p>Just Click it and get it !</p>
                </div>
            </div>
        </div>
        <div class="row">
            @forelse($categories as $cateogry)
            <div class="col-6 col-md-4">
                <a href="{{ route('category', $cateogry->slug) }}" class="feature-box aos" data-aos="fade-up">
                    <div class="feature-icon">
                        <span>
                            <img style="max-height: 80px;" src="{{ asset('storage/uploads/category/' . $cateogry->image) }}" alt="{{ $cateogry->name }}">
                        </span>
                    </div>
                    <h5>{{ $cateogry->name }}</h5>
                    <div class="feature-overlay">
                        <img class="fo-image" src="https://png.pngtree.com/background/20210716/original/pngtree-swirl-round-neon-colorful-smoke-background-picture-image_1394763.jpg" alt="{{ $cateogry->name }}">
                    </div>
                </a>
            </div>
            @empty
            <div class="col-12">
                <a class="feature-box aos" data-aos="fade-up">
                    <h5>Coming Soon</h5>
                </a>
            </div>
            @endforelse
        </div>
    </div>
</section>
<!-- /Feature Section -->

<!-- Appointment Section -->
<section class="appointment-section aos" data-aos="fade-up">
    <div class="container">
        <div class="appointment-main">
            <h6>GET A MODERN LOOK</h6>
            <h1>Upto 25% offer on First Appointment</h1>
            <p>No one you see is smarter than he so join us here are sure to get a smile from seven stranded.</p>
            <div class="appointment-btn">
                <a href="free-trial.html" class="btn btn-primary" >BOOK AN APPOINTMENT NOW</a>
            </div>
        </div>
    </div>
</section>
<!-- /Appointment Section -->

<!-- popular service -->
<section class="popular-service-seven-section">
    <div class="container">
        <div class="section-heading section-heading-seven">
            <div class="row">
                <div class="col-md-6 aos" data-aos="fade-up">
                    <h2>Best Offers</h2>
                    <p>Grab or gone offers. Grab it now</p>
                </div>
                <div class="col-md-6 text-md-end aos" data-aos="fade-up">
                    <div class="owl-nav mynav-seven-two"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="owl-carousel recent-projects-seven">
                    @for ($i = 1; $i <= 5; $i++)
                    <div class="service-widget service-two service-seven aos" data-aos="fade-up">
                        <div class="service-img">
                            <a href="service-details.html">
                                <img class="img-fluid serv-img" alt="Service Image" src="https://img.freepik.com/premium-photo/plumber-repairing-washing-machine_392895-4242.jpg?w=2000">
                            </a>
                            <div class="fav-item">
                                <a><span class="item-cat">Flat ₹ {{ rand(1,9) * $i }} Off</span></a>
                            </div>
                        </div>
                        <div class="service-content service-content-seven">
                            <h3 class="title">
                                <a>Washing Machine Repairing</a>
                            </h3>
                        </div>
                    </div>
                    @endfor
                </div>
            </div>
        </div>
    </div>
</section>
<!-- /popular service -->

<section class="works-eight-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 text-center">
                <div class="section-heading section-heading-eight aos" data-aos="fade-up">
                    <img src="assets/img/icons/dog.svg" alt="">
                    <h2>How it Works</h2>
                    <p>Mauris ut cursus nunc. Morbi eleifend, ligula at consectetur vehicula</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <div class="works-eights-main">
                    <div class="works-eights-img">
                        <img src="assets/img/icons/gui-calendar-planner-eight.svg" alt="">
                        <div class="works-eights-arrow">
                            <img src="assets/img/icons/arrow-eight-1.svg" alt="">
                        </div>
                    </div>
                    <p>Connect with your Calendar</p>

                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <div class="works-eights-main">
                    <div class="works-eights-img">
                        <img src="assets/img/icons/pointer-eight.svg" alt="">
                        <div class="works-eights-arrow works-eights-arrow-two">
                            <img src="assets/img/icons/arrow-eight-2.svg" alt="">
                        </div>
                    </div>
                    <p>Connect with your Calendar</p>

                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <div class="works-eights-main">
                    <div class="works-eights-img">
                        <img src="assets/img/icons/dog-face-eight.svg" alt="">
                        <div class="works-eights-arrow">
                            <img src="assets/img/icons/arrow-eight-1.svg" alt="">
                        </div>
                    </div>
                    <p>Connect with your Calendar</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                <div class="works-eights-main">
                    <div class="works-eights-img">
                        <img src="assets/img/icons/pay-per-eight.svg" alt="">
                    </div>
                    <p>Connect with your Calendar</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- register section -->
<section class="register-section aos" data-aos="fade-up">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-12">
                <div class="register-content">
                    <p>Get Registered and List your Saloon for free!!!</p>
                    <div class="register-btn">
                        <a href="register.html"><i class="feather-users me-2"></i>Register /</a>
                        <a href="login.html">Login</a>
                    </div>
                </div>
            </div>
            </div>
    </div>
</section>
<!--/register section  -->
@endsection
