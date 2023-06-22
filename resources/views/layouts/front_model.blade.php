<style>
.animate-bottom {
    position: relative;
    animation: animatebottom 0.5s;
}

@keyframes animatebottom {
    from {
        bottom: -160px;
        opacity: 0;
    }

    to {
        bottom: 0;
        opacity: 1;
    }
}
</style>
<div id="tc-address-modal" class="modal fade" data-keyboard="false" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content animate-bottom">
            <div class="modal-header border-bottom-0 justify-content-between">
                <h5 class="modal-title">Enter Your Address</h5>
                {{-- <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i class="feather-x"></i></button> --}}
            </div>
            <div class="modal-body pt-0">
                <div class="write-review">
                    <form id="submit-tc-address">
                        <div class="form-group row mb-0">
                            <div class="pass-group col-md-4">
                                <label style="font-size:14px;" class="col-form-label">House/Flat Number</label>
                                <input type="text" id="tc-house_no" name="house_no" class="form-control" placeholder="House/Flat Number">
                                <p id="tc-house_no-error" class="text-danger"></p>
                            </div>
                            <div class="pass-group col-md-8">
                                <label style="font-size:14px;" class="col-form-label">Landmark</label>
                                <input type="text" id="tc-landmark" name="landmark" class="form-control" placeholder="Start Typing Landmark">
                                <p id="tc-landmark-error" class="text-danger"></p>
                            </div>
                            <div class="pass-group col-md-12">
                                <label style="font-size:14px;" class="col-form-label">Address</label>
                                <input type="text" id="tc-address" name="address" class="form-control" placeholder="Start typing Address">
                                <p id="tc-address-error" class="text-danger"></p>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="tc-select-address" style="display: none">
                    <p class="text-center text-dark"><strong>Or Select From Existing One</strong></p>
                    <div class="d-flex">
                        <div class="contact-info flex-fill" role="button">
                            <span style="width: 40px;height:40px;"><i class="feather-map-pin"></i></span>
                            <div class="contact-data">
                                <h6>Your Added Address</h6>
                                <p id="tc-existing-address-text"></p>
                                <input type="hidden" id="tc-existing-address" value="">
                                <input type="hidden" id="tc-existing-house_no" value="">
                                <input type="hidden" id="tc-existing-landmark" value="">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-submit text-end">
                    <a class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</a>
                    <button id="submit-address" type="submit" class="btn btn-tc">Confirm & Procced to Pay</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="tc-payment-modal" class="modal fade" data-keyboard="false" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content animate-bottom">
            <div class="modal-header border-bottom-0 justify-content-between">
                <h5 class="modal-title">How you would like to pay ?</h5>
                {{-- <button type="button" class="close-btn" data-bs-dismiss="modal" aria-label="Close"><i class="feather-x"></i></button> --}}
            </div>
            <hr>
            <div class="modal-body pt-0">
                <div class="write-review">
                    <form id="submit-tc-payment" method="POST" action="{{ route('placeOrder') }}">
                        @csrf
                        <input type="hidden" name="payment_method" id="payment_method" value="">
                        <input type="hidden" name="category" value="{{ $cartArray[0]->category->id }}">
                        <input type="hidden" name="subCategory" value="{{ $cartArray[0]->subCategory->id }}">
                        <input type="hidden" name="cartArray" value="{{ base64_encode(json_encode($cartArray)) }}">
                        <div class="form-group row mb-0">
                            <div class="alert alert-danger payment-error" style="display: none;">
                                <strong>Please Choose any of one method</strong>
                            </div>
                            <div class="linked-item">
                                <div class="linked-wrap">
                                    <div class="linked-acc">
                                        <span class="link-icon">
                                            <img style="width: 100%;" src="https://cdn.pixabay.com/photo/2021/01/25/12/21/money-5948190_1280.png" alt="cash">
                                        </span>
                                        <div class="linked-info">
                                            <h6>Cash/UPI Payment</h6>
                                            <p>Cash/UPI Payment after service is completed</p>
                                        </div>
                                    </div>
                                    <div class="linked-action">
                                        <a id="tc-cash-payment" class="paymentBtn btn btn-sm btn-secondary btn-set">Select</a>
                                    </div>
                                </div>
                                <!-- <div class="linked-wrap">
                                    <div class="linked-acc">
                                        <span class="link-icon">
                                            <img style="width: 100%;" src="https://cdn.iconscout.com/icon/free/png-256/free-upi-2085056-1747946.png" alt="UPI">
                                        </span>
                                        <div class="linked-info">
                                            <h6>UPI Payment</h6>
                                            <p>Pay right now using any UPI Application.</span></p>
                                        </div>
                                    </div>
                                    <div class="linked-action">
                                        <a id="tc-upi-payment" class="paymentBtn btn btn-sm btn-secondary btn-set">Select</a>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </form>
                </div>
                <hr>
                <div class="modal-submit text-end">
                    <a class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancel</a>
                    <button id="submit-payment" type="submit" class="btn btn-tc">Confirmed & Place Order</button>
                </div>
            </div>
        </div>
    </div>
</div>
