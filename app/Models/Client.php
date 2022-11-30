<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'account_name',
        'first_name',
        'middle_name',
        'last_name',
        'address',
        'contact_number',
        'work',
        'monthly_income',
        'is_active',
        'area',
    ];
    
    // 'id','client_id'
    public function loans(){
        return $this->hasMany('App\Loan');
    }

    public function areas(){
        return $this->belongsTo('App\Area');
    }

    public function payments(){
        return $this->belongsTo('App\Payment');
    }
}
