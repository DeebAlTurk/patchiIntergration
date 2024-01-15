<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class orderCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description'
    ];


    //Relationships
    public function orders()
    {
        return $this->hasMany(Orders::class, 'order_category_id');
    }

}