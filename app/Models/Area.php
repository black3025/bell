<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'is_active',
        'category'

    ];

    public function clients(){
        return $this->hasMany('App\Models\Client');
    }

    public function loans(){
        return $this->hasMany('App\Models\Loan');
    }
}
