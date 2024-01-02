<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "policy_number",
        "receiver_name",
        "order_category_id",
        "phone_number",
        "city_id",
        "address",
        "comment",

    ];

    //relationships
    public function order_category()
    {
        return $this->belongsTo(orderCategory::class);
    }
    public function city()
    {
        return $this->belongsTo(City::class);
    }
    public function orderStatuses(): HasMany
    {
        return $this->hasMany(orderStatus::class, 'orders_id');
    }
}
