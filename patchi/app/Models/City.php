<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable=[
        'name',
        'primary_email',
        'cc_emails'
    ];

    //Relationships
    public function orders()
    {
        return $this->hasMany(Orders::class, 'city_id');
    }
}
