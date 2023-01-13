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
        'area_id',
        'address',
        'contact_number',
        'business',
        'income',
        'is_active',
        'area',
        'pic',
    ];

    public function loans(){
        return $this->hasMany(Loan::class);
    }

    public function area(){
        return $this->belongsTo(Area::class);
    }
}
