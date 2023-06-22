@extends('layouts.app')

@section('section')
    <!-- Banner image -->
    <section style="background-image:url(https://res.cloudinary.com/urbanclap/image/upload/images/growth/home-screen/1615375782838-f890f8.jpeg);background-position: center center;background-size: cover;background-repeat: no-repeat;height: 552px;">
    </section>

    <div class="container">
        <home-category-list />
    </div>
@endsection

@section('js')
<script>
    function incrementValue(e) {
        e.preventDefault();
        var fieldName = $(e.target).data('field');
        var parent = $(e.target).closest('div');
        var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

        if (!isNaN(currentVal)) {
            parent.find('input[name=' + fieldName + ']').val(currentVal + 1);
        } else {
            parent.find('input[name=' + fieldName + ']').val(0);
        }
    }

    function decrementValue(e) {
        e.preventDefault();
        var fieldName = $(e.target).data('field');
        var parent = $(e.target).closest('div');
        var currentVal = parseInt(parent.find('input[name=' + fieldName + ']').val(), 10);

        if (!isNaN(currentVal) && currentVal > 0) {
            parent.find('input[name=' + fieldName + ']').val(currentVal - 1);
        } else {
            parent.find('input[name=' + fieldName + ']').val(0);
        }
    }

    $(document).on('click', '.button-plus', function(e) {
        var qtyVal = $(this).closest('div.quantity-cart').find("input[name='quantity']").val();
        if (qtyVal <= 9) {
            incrementValue(e);
        } else {
            alert("Reached Maximum Limit !");
        }
    });

    $(document).on('click', '.button-minus', function(e) {
        var qtyVal = $(this).closest('div.quantity-cart').find("input[name='quantity']").val();
        console.log(qtyVal);
        decrementValue(e);
    });
</script>
@endsection
