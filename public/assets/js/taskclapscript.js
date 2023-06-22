const cartItems = getCookie('cartDetail') ? JSON.parse(getCookie('cartDetail')) : [];
const cartTotals = getCookie('cartTotal') ? JSON.parse(getCookie('cartTotal')) : [];

function renderLoginScreen() {
    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('recaptcha-container');
    recaptchaVerifier.render();
}

function sendSmsForVerify() {
    var number = $("#phone").val();
    number = "+91" + number;

    $.ajax({
        type : "POST",
        dataType: "json",
        url : "/validate-number",
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data : $("#login-form").serialize(),
        success : function(response) {
            if (response.success) {
                firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function (confirmationResult) {
                    window.confirmationResult = confirmationResult;
                    coderesult = confirmationResult;
                    $(".login-screen").hide();
                    $(".login-screen-otp").show();
                    $("#dialogue-box").html("<div class='alert alert-success'>We've sent you a 6 digit OTP on " + $("#phone").val() +  "</div>");
                    $("#dialogue-box").show();
                    $("#digit-1").focus();

                    //Starting Timer
                    setLoginOtpTimeExpiry();
                }).catch(function (error) {
                    $("#dialogue-box").html("<div class='alert alert-danger'>Please enter valid mobile number !</div>");
                    $("#dialogue-box").show();
                });
            } else {
                $(".login-screen-otp").hide();
                $("#dialogue-box").html("<div class='alert alert-danger'>" + response.msg + "</div>");
                $("#dialogue-box").show();
            }
        }
    });
}

function resendSmsForVerify() {
    $("#dialogue-box").html("<div class='alert alert-info'>Please Wait !</div>");

    $(".login-time-expiry").hide();
    $(".no-otp-recieved").html("");
    var number = $("#phone").val();
    number = "+91" + number;

    firebase.auth().signInWithPhoneNumber(number, window.recaptchaVerifier).then(function (confirmationResult) {
        window.confirmationResult = confirmationResult;
        coderesult = confirmationResult;
        $(".login-screen").hide();
        $(".login-screen-otp").show();
        $("#dialogue-box").html("<div class='alert alert-success'>We've sent you a 6 digit OTP on " + $("#phone").val() +  "</div>");
        $("#dialogue-box").show();
        $("#digit-1").focus();

        //Starting Timer
        setLoginOtpTimeExpiry();
    }).catch(function (error) {
        $("#dialogue-box").html("<div class='alert alert-danger'>Whoops ! Something Went wrong.<br>Please try after sometime.</div>");
        $("#dialogue-box").show();
    });
}

function VerfySmsForAuth() {
    var code1 = $("#digit-1").val().trim();
    var code2 = $("#digit-2").val().trim();
    var code3 = $("#digit-3").val().trim();
    var code4 = $("#digit-4").val().trim();
    var code5 = $("#digit-5").val().trim();
    var code6 = $("#digit-6").val().trim();
    var code = code1 + code2 + code3 + code4 + code5 + code6;

    coderesult.confirm(code).then(function (result) {
        var user = result.user;
        if (user) {
            $.ajax({
                type : "POST",
                dataType: "json",
                url : "/login",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data : {
                    'phone' : $("#phone").val()
                },
                success : function(response) {
                    if (response && response.success) {
                        window.location.href = response.loginLink;
                    } else {
                        $(".login-screen-otp").hide();
                        $("#dialogue-box").html("<div class='alert alert-danger'>We're really Sorry !<br>But an unexpected error occurred. Please try after sometime.</div>");
                        $("#dialogue-box").show();
                    }
                }
            });
        }
    }).catch(function (error) {
        $("#dialogue-box").html("<div class='alert alert-danger'>Please Enter OTP.</div>");
        $("#dialogue-box").show();
    });
}

function setLoginOtpTimeExpiry() {
    var timer2 = "01:00";
    var otpResent = setInterval(function() {
        var timer = timer2.split(':');
        //by parsing integer, I avoid all extra string processing
        var minutes = parseInt(timer[0], 10);
        var seconds = parseInt(timer[1], 10);
        --seconds;
        minutes = (seconds < 0) ? --minutes : minutes;
        if (minutes < 0) clearInterval(interval);
        seconds = (seconds < 0) ? 59 : seconds;
        seconds = (seconds < 10) ? '0' + seconds : seconds;
        $('span.expiry-time-block').html(minutes + ':' + seconds);
        if (minutes == "0" && seconds == "00") {
            $(".login-time-expiry").hide();
            $(".no-otp-recieved").html('<a onclick="resendSmsForVerify()">Resend OTP</a>');
            clearInterval(otpResent);
        }
        timer2 = minutes + ':' + seconds;
    }, 1000);

    $(".login-time-expiry").show();
}

function setCookie(key, value, expiry) {
    var expires = new Date();
    expires.setTime(expires.getTime() + (expiry * 24 * 60 * 60 * 1000));
    document.cookie = key + '=' + value + ';expires=' + expires.toUTCString();
}

function getCookie(key) {
    var keyValue = document.cookie.match('(^|;) ?' + key + '=([^;]*)(;|$)');
    return keyValue ? keyValue[2] : null;
}

function eraseCookie(key) {
    var keyValue = getCookie(key);
    setCookie(key, keyValue, '-1');
}

function incrementCartBtnValue(e) {
    e.preventDefault();
    var fieldName = $(e.target).data('field');
    var parent = $(e.target).closest('div');
    var parentElement = parent.find('input[name=' + fieldName + ']');
    var currentVal = parseInt(parentElement.val(), 10);

    if (currentVal >= 10) {
        alert("You cannot add more than 10 items !");
        return;
    }

    if (! isNaN(currentVal)) {
        parentElement.val(currentVal + 1);
        updateCartItem(
            'plus',
            parentElement.attr("data-price"),
            parentElement.attr("data-strikeprice"),
            parentElement.attr("data-subCategoryId"),
            parentElement.attr("data-productId"),
            parentElement.val()
        );
    } else {
        parent.find('input[name=' + fieldName + ']').val(0);
    }
}
function decrementCartBtnValue(e) {
    e.preventDefault();
    var fieldName = $(e.target).data('field');
    var parent = $(e.target).closest('div');
    var parentElement = parent.find('input[name=' + fieldName + ']');
    var currentVal = parseInt(parentElement.val(), 10);

    if (! isNaN(currentVal) && currentVal > 0) {
        parentElement.val(currentVal - 1);
        updateCartItem(
            'minus',
            parentElement.attr("data-price"),
            parentElement.attr("data-strikeprice"),
            parentElement.attr("data-subCategoryId"),
            parentElement.attr("data-productId"),
            parentElement.val()
        );
    } else {
        parentElement.val(0);
    }
}

function updateCartItem(type, sellingPrice, currentPrice, subCategoryId, productId, qty) {
    if (cartTotals[subCategoryId] !== undefined) {
        if (type == "plus") {
            if (cartTotals[subCategoryId]) {
                sellingPrice = parseInt(cartTotals[subCategoryId]['cartSellingTotal']) + parseInt(sellingPrice);
                currentPrice = parseInt(cartTotals[subCategoryId]['cartCurrentTotal']) + parseInt(currentPrice);
            } else {
                sellingPrice = parseInt(sellingPrice);
                currentPrice = parseInt(currentPrice);
            }
        } else {
            if (cartTotals[subCategoryId]) {
                sellingPrice = parseInt(cartTotals[subCategoryId]['cartSellingTotal']) - parseInt(sellingPrice);
                currentPrice = parseInt(cartTotals[subCategoryId]['cartCurrentTotal']) - parseInt(currentPrice);
            } else {
                sellingPrice = parseInt(sellingPrice);
                currentPrice = parseInt(currentPrice);
            }
        }
    }

    cartItems[productId] = {
        "productId" : productId,
        "qty" : qty
    };
    cartTotals[subCategoryId] = {
        "cartSellingTotal" : sellingPrice,
        "cartCurrentTotal" : currentPrice
    };

    setCookie('cartDetail', JSON.stringify(cartItems), 1);
    setCookie('cartTotal', JSON.stringify(cartTotals), 1);

    if (sellingPrice != 0 && currentPrice != 0) {
        $(".cart-total").html("₹ " + sellingPrice + " &nbsp;<small><strike>₹ " + currentPrice + "</strike></small>");
        $(".cart-widget").slideDown();
        return;
    }

    $(".cart-widget").slideUp();
}

function loadCartItems(subCategoryId) {
    if (cartTotals.length > 0 && cartTotals[subCategoryId]) {
        var sellingPrice = cartTotals[subCategoryId]['cartSellingTotal'];
        var currentPrice = cartTotals[subCategoryId]['cartCurrentTotal'];
    }

    if (sellingPrice !== undefined && sellingPrice !== undefined && sellingPrice != 0) {
        $(".cart-total").html("₹ " + sellingPrice + " &nbsp;<small><strike>₹ " + currentPrice + "</strike></small>");
        $(".cart-widget").slideDown();
        return;
    }

    $(".cart-widget").slideUp();
}

function finishTcLoading() {
    $(".main-wrapper").removeAttr('style');
    jQuery('.tc-loading-screen').fadeOut(500, function () {
        // document.getElementById("tc-loader").style.display = "none";
    });
}

function confirmOrder() {
    $("#submit-tc-payment").submit();
}

$(document).ready(function () {

    $('.input-group').on('click', '.button-plus', function(e) {
        incrementCartBtnValue(e);
    });

    $('.input-group').on('click', '.button-minus', function(e) {
        decrementCartBtnValue(e);
    });

    if(! navigator.cookieEnabled) {
        $(".mt-0").html("<h1 align='center'>Please Enable Cookies !</h1>");
    }

    $("#book-tc-service").click(function() {
        $.ajax({
            type : "POST",
            dataType: "json",
            url : "/cart/fetchAddress",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : $("#submit-tc-address").serialize(),
            success : function(response) {
                if (response.success) {
                    $("#tc-select-address").show();
                    $("#tc-existing-address-text").html(response.address);
                    $("#tc-existing-address").val(response.address);
                    $("#tc-existing-house_no").val(response.house_no);
                    $("#tc-existing-landmark").val(response.landmark);
                }

                $("#tc-address-modal").modal("show");
            },
        });
    });

    $("#login-from-cart").click(function() {
        window.location.href = "/login";
    });

    $("#submit-address").click(function() {
        $("form#submit-tc-address :input").each(function(){
            var input = $(this);
            var inputId = input.attr("id")
            input.removeClass("is-invalid");
            $("#" + inputId + "-error").html("");
        });

        $.ajax({
            type : "POST",
            dataType: "json",
            url : "/cart/addAddress",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data : $("#submit-tc-address").serialize(),
            success : function(response) {
                if (response.success) {
                    $("#tc-address-modal").modal("hide");
                    $("#tc-payment-modal").modal("show");
                }
            },
            error: function (data) {
                var errors = $.parseJSON(data.responseText);
                $.each(errors.errors, function (key, value) {
                    var errorInputId = "tc-" + key;
                    var errorInpuErrtId = "tc-" + key + "-error";
                    $("#" + errorInputId).addClass("is-invalid");
                    $("#" + errorInpuErrtId).html(value);
                });
            }
        });
    });

    $(".contact-data").click(function() {
        $("#tc-house_no").val($("#tc-existing-house_no").val());
        $("#tc-landmark").val($("#tc-existing-landmark").val());
        $("#tc-address").val($("#tc-existing-address").val());
        $("#tc-select-address").slideUp();
    });

    $("#tc-cash-payment").click(function() {
        $("#payment_method").val("cash");
        $(this).removeClass("btn-secondary").addClass("btn-success").html("Selected");
        $('.paymentBtn').not('#tc-cash-payment').hide();
        $(".payment-error").hide();
    });

    $("#tc-upi-payment").click(function() {
        alert("Coming Soon");
    });

    $("#submit-payment").click(function() {
        var payment_method = $("#payment_method").val();
        $(".payment-error").hide();
        if (payment_method == "cash") {
            Swal.fire({
                icon: 'info',
                title: 'Confirm to Place Order ?',
                showDenyButton: false,
                showCancelButton: true,
                confirmButtonText: 'Confirm',
                denyButtonText: 'Cancel',
              }).then((result) => {
                if (result.isConfirmed) {
                  confirmOrder();
                }
              })
        } else {
            $(".payment-error").show();
        }
    });
});
