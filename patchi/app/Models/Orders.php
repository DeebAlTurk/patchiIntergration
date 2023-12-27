<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;

    protected $fillable = [
        "policy_number",
        "receiver_name",
        "order_category_id",
        "phone_number",
        "city_id",
        "address",
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
}
