<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Orchid\Attachment\Attachable;
use Orchid\Filters\Filterable;
use Orchid\Filters\Types\Like;
use Orchid\Screen\AsSource;

class City extends Model
{
    use HasFactory,AsSource, Filterable, Attachable;
    protected $fillable=[
        'name',
        'primary_email',
        'cc_emails'
    ];


    function getCCEmails(){
        return explode(';',$this->cc_emails);
    }
    function getAllEmails(){
        $emails=$this->getCCEmails();
        return array_push($emails,$this->primary_email);
    }

    protected $allowedFilters = [
        'name'=>Like::class,
        'primary_email'=>Like::class,
        'cc_emails'=>Like::class,
    ];

    //Relationships
    public function orders()
    {
        return $this->hasMany(Orders::class, 'city_id');
    }
    public function districts(): HasMany
    {
        return $this->hasMany(District::class, 'city_id');
    }
}
