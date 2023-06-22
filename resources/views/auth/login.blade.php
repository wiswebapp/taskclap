@extends('layouts.app')

@section('content')
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-lg-6 mx-auto">
                    <div class="login-wrap">
                        <div class="login-back">
                            <a href="{{ route('homepage') }}"><img src="assets/img/icons/undo-icon.svg" class="me-2" alt="icon">Back To Home</a>
                        </div>
                        <div class="login-header">
                            <h3>{{ request()->type ? ucfirst(request()->type) : 'Login' }}</h3>
                            <p>We'll send a confirmation code to your Phone.</p>
                        </div>
                        <div id="dialogue-box" style="display: none;"></div>
                        <!-- Login Screen -->
                        <div class="login-screen">
                            <form method="POST" id="login-form" onkeydown="return event.key != 'Enter';">
                                <div class="log-form">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="col-form-label">Phone Number</label>
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-lg group_formcontrol" id="phone" name="phone" placeholder="Enter your Phone Number" value="7383742776" required>
                                            </div>
                                        </div>
                                        <div id="recaptcha-container"></div>
                                    </div>
                                </div>
                            </form>
                            <button type="button" onclick="sendSmsForVerify();" class="btn btn-primary w-100 login-btn">Login</button>
                        </div>

                        <!-- OTP Screen -->
                        <div class="login-screen-otp" style="display: none;">
                            <div class="form-group">
                                <div class="passcode-wrap digit-group passcode-verified">
                                    <input type="text" id="digit-1" name="digit-1" data-next="digit-2" maxlength="1">
                                    <input type="text" id="digit-2" name="digit-2" data-next="digit-3" data-previous="digit-1" maxlength="1">
                                    <input type="text" id="digit-3" name="digit-3" data-next="digit-4" data-previous="digit-2" maxlength="1">
                                    <input type="text" id="digit-4" name="digit-4" data-next="digit-5" data-previous="digit-3" maxlength="1">
                                    <input type="text" id="digit-5" name="digit-5" data-next="digit-6" data-previous="digit-4" maxlength="1">
                                    <input type="text" id="digit-6" name="digit-6" data-previous="digit-5" maxlength="1">
                                </div>
                            </div>
                            <div class="text-center">
                                <div class="login-time-expiry" style="display: none;">
                                    <i class="feather-clock me-1"></i><span class="expiry-time-block"></span>
                                </div>
                                <p class="no-acc no-otp-recieved"></p>
                            </div>
                            <button class="btn btn-primary w-100 login-btn mb-0" type="button"  onclick="VerfySmsForAuth()">Verify code</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://www.gstatic.com/firebasejs/6.0.2/firebase.js"></script>
    <script>
        var firebaseConfig = {
            apiKey: "AIzaSyB8J5VxtjPFjjFB54QbQ0p8wLfMnZwdH0w",
            authDomain: "taskclap-2023.firebaseapp.com",
            databaseURL: "https://taskclap-2023.firebaseio.com",
            projectId: "taskclap-2023",
            storageBucket: "taskclap-2023.appspot.com",
            messagingSenderId: "380954429436",
            appId: "1:380954429436:web:fed0c4bb3e2215ef4d5479"
        };
        firebase.initializeApp(firebaseConfig);

        window.onload = function () {
            renderLoginScreen();
        };
    </script>
@endsection
