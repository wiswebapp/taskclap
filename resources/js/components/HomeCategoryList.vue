<script setup>
const categories = [
            'Salon For Men',
            'Salon For Women',
            'Home Painting',
            'Cleaning & pesting',
            'Home Repairs',
            'Appliances',
        ];
</script>

<template>
    <div class="row">
        <div class="col-3 col-sm-4 col-md-4 category-box-home" v-for="(category, index) in categories">
            <img src="https://res.cloudinary.com/urbanclap/image/upload/q_auto,f_auto,fl_progressive:steep,w_64/t_high_res_template/images/growth/home-screen/1609757635235-1a139e.png" alt="{{ category }}">
            <p class="catText">{{ category }}</p>
            <hr>
            <div class="row mb-8 justify-content-center">
                <div class="col-md-6 col-12">
                    <div class="row">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <div class="quantity-cart input-group w-auto justify-content-end align-items-center">
                                    <input type="button" value="-" class="button-minus border rounded-circle  icon-shape icon-sm mx-1 " data-field="quantity">
                                    <input readonly type="text" step="1" max="10" value="0" name="quantity" class="quantity-field border-0 text-center w-25">
                                    <input type="button" value="+" class="button-plus border rounded-circle icon-shape icon-sm " data-field="quantity">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.row {
    margin-top: 10px;
}
.category-box-home {
    display: flex;
    padding:5px;
    align-items: center;
    height: 112px;
    cursor: pointer;
    overflow: hidden;
}
.catText {
    display: inline-block;
    margin-top: 16px;
    font-size: 13px;
    line-height: 16px;
    color: #212121;
    text-align: center;
    text-transform: capitalize;
 }
</style>
