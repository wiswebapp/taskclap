<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'order',
        'order_id',
        'product_id',
        'category_id',
        'sub_category_id',
        'service_category_id',
        'product_title',
        'product_description',
        'product_strike_price',
        'material_charge',
        'material_charge_actual',
        'material_description',
        'additional_charge',
        'additional_charge_description',
        'product_price',
        'product_commission',
        'warranty',
        'product_approx_duration',
        'order_status',
        'order_note',
    ];

    public function orderData(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
