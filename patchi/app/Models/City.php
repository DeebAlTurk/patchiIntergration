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

    function getCCEmails(){
        return explode(';',$this->cc_emails);
    }
    function getAllEmails(){
        $emails=$this->getCCEmails();
        return array_push($emails,$this->primary_email);
    }

    //Relationships
    public function orders()
    {
        return $this->hasMany(Orders::class, 'city_id');
    }
}
