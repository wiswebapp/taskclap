<!DOCTYPE html>
<html lang="en">
<head>
    @include('layouts.linkcss')
</head>

<body class="mt-0">
    <div class="tc-loading-screen">
        <!-- <div id="tc-loader"></div> -->
    </div>
	<div class="main-wrapper" style="filter: blur(8px);">
		<div class="page-wrapper">
			<div class="content">
				<div class="container">
					<div class="row">
                        <div class="col-md-12 col-lg-10 mx-auto">
						<div class="col-md-12 col-lg-10 mx-auto">

							<div class="login-back">
								<a href="{{ url()->previous() }}"><i class="feather-arrow-left"></i> Back</a>
							</div>

							<div class="row">
								<div class="col-lg-12 mx-auto">
                                    <div class="container">
                                        <div class="row">
                                            <!-- Service Profile -->
                                            <div class="col-md-8">
                                                <div class="serv-profile">
                                                    <h2>{{ $category->name }}</h2>
                                                    <ul>
                                                        <li class="service-map"><i class="fa fa-star rating-star"></i> 3.5 Rating (100 Bookings Made)</li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <!-- Like Share Section -->
                                            </div>
                                            <div class="col-md-12">
                                                <div class="service-gal">
                                                    <div class="row gx-2">
                                                        <div class="col-md-12">
                                                            <div class="service-images big-gallery">
                                                                <img src="/storage/uploads/category/{{ $category->image }}" class="img-fluid" alt="img">
                                                                {{-- <a href="assets/img/services/service-ban-01.jpg" data-fancybox="gallery" class="btn btn-show"><i class="feather-image me-2"></i>Show all photos</a> --}}
                                                            </div>
                                                        </div>
                                                        {{-- <div class="col-md-3">
                                                            <div class="service-images small-gallery">
                                                                <a  href="assets/img/services/service-ban-02.jpg" data-fancybox="gallery">
                                                                    <img src="assets/img/services/service-ban-02.jpg" class="img-fluid" alt="img">
                                                                    <span class="circle-icon"><i class="feather-plus"></i></span>
                                                                </a>
                                                            </div>
                                                            <div class="service-images small-gallery">
                                                                <a  href="assets/img/services/service-ban-03.jpg" data-fancybox="gallery">
                                                                    <img src="assets/img/services/service-ban-03.jpg" class="img-fluid" alt="img">
                                                                    <span class="circle-icon"><i class="feather-plus"></i></span>
                                                                </a>
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- /Service Profile -->
                                        </div>

                                        <div class="row">
                                            <!-- Service Details -->
                                            <div class="col-lg-7">
                                                <div class="service-wrap">
                                                    <div>{!! $category->description  !!}</div>
                                                </div>
                                                <hr>
                                                <div class="service-wrap provide-service">
                                                    <div class="row">
                                                        @forelse($service_type as $serviceType)
                                                        <div class="col-3 text-center" role="button" id="{{ createSlug($serviceType) }}">
                                                            <img class="img-fluid mb-2 cart-service-icon" alt="{{ $serviceType }}" src="https://www.vijayhomeservices.com/assets/img/ac-repair-large.jpg">
                                                            <div class="provide-info">
                                                                <p class="text-dark">{{ $serviceType }}</p>
                                                            </div>
                                                        </div>
                                                        @empty
                                                        @endforelse
                                                    </div>
                                                </div>
                                                <hr>
                                                @foreach ($service_type as $serviceType)
                                                <div class="product-section" id="service_{{ createSlug($serviceType) }}">
                                                    <h3 class="mb-5">{{ $serviceType }}</h3>
                                                    @foreach ($pageData[$serviceType] as $product)
                                                    <div class="product-inner-section row">
                                                        <div class="col-9">
                                                            @if($product->warranty)
                                                            <small class="dash-value">{{ $product->warranty }} Days Warranty</small>
                                                            @endif
                                                            <p class="mb-0 text-dark"><b>{{ $product->title }}</b></p>
                                                            <small class="text-body"><i class="fa fa-solid fa-star rating-star"></i> 4.83 (1.54M reviews)</small>
                                                            @if($product->children->count())
                                                            <p class="text-dark"><small><strong>{{ $product->children->count() }} Service</strong></small></p>
                                                            @else
                                                            <p class="text-dark"><small><strong>₹ {{ $product->price }}</strong>&nbsp;&nbsp;&nbsp;<strike>₹ {{ $product->strike_price }}</strike></small></p>
                                                            @endif
                                                        </div>
                                                        <div class="col-3">
                                                            @if ($product->image)
                                                            <img class="img-thumbnail p-0" src="/storage/uploads/products/{{ $product->image }}" alt="{{ $product->title }}">
                                                            @else
                                                            <img class="img-thumbnail p-0" src="https://dummyimage.com/200x200/000/fff" alt="{{ $product->title }}">
                                                            @endif

                                                            @if(! $product->children->count())
                                                            <div>
                                                                <div class="quantity-cart input-group w-auto justify-content-center align-items-center">
                                                                    <input type="button" value="-" class="cart-btn button-minus border rounded-circle  icon-shape icon-sm mx-1 " data-field="quantity">
                                                                    <input
                                                                        data-subCategoryId="{{ $product->sub_category_id }}"
                                                                        data-productId="{{ $product->id }}"
                                                                        data-price="{{ $product->price }}"
                                                                        data-strikeprice="{{ $product->strike_price }}"
                                                                        type="text"
                                                                        step="1"
                                                                        max="10"
                                                                        value="{{ $cartArray[$product->id] ? $cartArray[$product->id] : 0 }}"
                                                                        name="quantity"
                                                                        class="cart-btn quantity-field text-center"
                                                                        readonly
                                                                    >
                                                                    <input type="button" value="+" class="cart-btn button-plus border rounded-circle icon-shape icon-sm mx-1"
                                                                        data-field="quantity">
                                                                </div>
                                                            </div>
                                                            @endif
                                                        </div>
                                                        <div class="col-12">
                                                            <div class="product-description">
                                                                {{ $product->description }}
                                                            </div>
                                                            <p style="cursor: pointer;font-size: 14px;color: #4c40ed">View More</p>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    @endforeach
                                                </div>
                                                @endforeach
                                                <!-- <div class="service-wrap">
                                                    <h5>Reviews</h5>
                                                    <ul>
                                                        <li class="review-box">
                                                            <div class="review-profile">
                                                                <div class="review-img">
                                                                    <img src="assets/img/profiles/avatar-05.jpg" class="img-fluid" alt="img">
                                                                    <div class="review-name">
                                                                        <h6>Bradley</h6>
                                                                        <p>1 month ago  |  17:35PM </p>
                                                                    </div>
                                                                </div>
                                                                <div class="rating">
                                                                    <i class="fas fa-star filled"></i>
                                                                    <i class="fas fa-star filled"></i>
                                                                    <i class="fas fa-star filled"></i>
                                                                    <i class="fas fa-star"></i>
                                                                    <i class="fas fa-star"></i>
                                                                </div>
                                                            </div>
                                                            <p>Lorem ipsum dolor sit amet, consectetur adipicing elit</p>
                                                        </li>
                                                    </ul>
                                                </div> -->
                                            </div>
                                            <div class="col-lg-5 theiaStickySidebar">
                                                <div class="card card-provide mb-0">
                                                    <div class="card-body">
                                                        <div class="package-widget">
                                                            <h5>What You'll Get</h5>
                                                            <ul>
                                                                <li>Full car wash and clean</li>
                                                                <li>Auto Electrical</li>
                                                                <li>Pre Purchase Inspection</li>
                                                                <li>Pre Purchase Inspection</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cart-widget package-widget row" style="display: none;">
                                                    <div class="col-8 col-md-8 col-sm-6">
                                                        <h6 class="cart-total">₹ 0</h6>
                                                    </div>
                                                    <div class="col-4 col-md-4 col-sm-6">
                                                        <a href="{{ route('checkout', [
                                                            'category' => $product->category->slug,
                                                            'subcategory' => $product->subcategory->slug,
                                                            ]) }}" class="btn btn-sm btn-success">View Cart</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Cursor -->
		<div class="mouse-cursor cursor-outer"></div>
		<div class="mouse-cursor cursor-inner"></div>
		<!-- /Cursor -->

	</div>

	@include('layouts.scripts')
    <script>
    $(document).ready(function() {
        loadCartItems({{ $product->sub_category_id }});
        @foreach($service_type as $serviceType)
            $("#{{ createSlug($serviceType)}}").click(function() {
                $('html,body').animate({
                    scrollTop: $("#service_{{ createSlug($serviceType)}}").offset().top
                },'slow');
            });
        @endforeach

        setInterval(function () {
            finishTcLoading();
        }, 1000);
    });
    </script>
</body>
</html>
