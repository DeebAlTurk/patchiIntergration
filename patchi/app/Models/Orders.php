<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
        "delivery_providers_id",
        "status",
        "preferred_delivery_date",
        "supervisor",

    ];
    protected $casts=
        ['preferred_delivery_date'=>"datetime"];

    //relationships

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

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
