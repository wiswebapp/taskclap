<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'provider_id',
        'category_id',
        'sub_category_id',
        'name',
        'phone',
        'email',
        'address',
        'house_no',
        'landmark',
        'address_local',
        'pincode',
        'country_id',
        'state_id',
        'city_id',
        'area_id',
        'address_lat',
        'address_long',
        'product_count',
        'isPromoApplied',
        'promocode',
        'discount',
        'tax',
        'material_charge_amount_total',
        'additional_charge_amount_total',
        'provider_pay_amount_total',
        'system_earn_amount_total',
        'subtotal',
        'total',
        'cancellation_charge',
        'is_warranty_order',
        'payment_type',
        'payment_json',
        'payment_status',
        'order_status',
        'order_notes',
        'is_paid_to_provide',
    ];

    const PAYMENT_STATUS = [
        'Started',
        'Pending',
        'Completed',
        'Failed'
    ];
    const ORDER_STATUS = [
        'Placed',
        'Completed',
        'Pending',
        'Cancelled',
        'Failed',
        'Rejected'
    ];

    public function provider(): BelongsTo
    {
        return $this->belongsTo(Provider::class);
    }

    public function orderDetail(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function area(): BelongsTo
    {
        return $this->belongsTo(Area::class);
    }
}
