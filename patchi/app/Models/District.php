<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Screen\AsSource;

class District extends Model
{

    use HasFactory, AsSource, Filterable, Attachable;

    protected $fillable = ['city_id', 'name'];


    public function city(): BelongsTo
    {

        return $this->belongsTo(City::class);
    }
}
