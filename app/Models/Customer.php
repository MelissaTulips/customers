<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';
    protected $primaryKey = 'customer_id';
    public $timestamps=false;


         protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'city',
        'state',
        'points'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }


    public function isGoldenMember(){
        return $this->points > 2000;


    }


}

