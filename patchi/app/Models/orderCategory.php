<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class orderCategory extends Model
{
    use HasFactory,AsSource,Filterable,Attachable;

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
