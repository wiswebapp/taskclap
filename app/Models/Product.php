<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    const UPLOAD_PATH = "uploads/products";

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'parent_id',
        'category_id',
        'sub_category_id',
        'service_category_id',
        'title',
        'description',
        'long_description',
        'image',
        'strike_price',
        'price',
        'commission',
        'warranty',
        'approx_duration',
        'status',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function serviceCategory(): HasOne
    {
        return $this->hasOne(ServiceCategory::class, 'id', 'service_category_id')->select(['id', 'name']);
    }

    public function subCategory(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function children(): HasMany
    {
        return $this->hasMany(Product::class , 'parent_id');
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(Product::class , 'parent_id');
    }
}
