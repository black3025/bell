<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    protected $fillable = [
        'area_name',
        'is_active',
        'category'

    ];

    public function clients(){
        return $this->hasMany('App\Client');
    }
}
