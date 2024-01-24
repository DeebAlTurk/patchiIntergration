<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class orderStatus extends Model
{
    use AsSource, Filterable, Attachable;

    protected $fillable = [
        'orders_id',
        'status',
        'supervisor',
    ];

    //Relationships
    public function orders()
    {
        return $this->belongsTo(Orders::class);
    }
}
