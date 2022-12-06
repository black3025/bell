<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
       'client_id',
       'rel_date',
       'beg_date',
       'end_date',
       'principle_amount',
       'balance',
       'cycle',
       'category',
       'approvals',
       'aproval_date',
       'approval_notes',
       'area',
       'acctname',
       'is_active',


   ];

    public function client(){
       return $this->belongsTo('App\Model\Client','client_id','id');
   }

   public function payments(){
       return $this->hasMany('App\Model\Payment');
   }

   public function client_sort(){
       return $this->belongsTo('App\Model\Client','client_id','id')->orderBy('account_name','asc');   
   }

   public function area_sort(){
    return $this->belongsTo('App\Model\Client','client_id','id')->orderBy('area_id','asc');   
}
}
