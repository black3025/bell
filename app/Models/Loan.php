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
       'is_active',
       'user_id'


   ];

   public function client(){
       return $this->belongsTo(Client::class)->orderby('account_name','asc');
   }

   public function user(){
    return $this->belongsTo(user::class);
}

   public function payments(){
       return $this->hasMany(Payment::class);
   }

   public function client_sort(){
       return $this->belongsTo(Client::class)->orderBy('account_name','asc');   
   }

   public function area_sort(){
         return $this->belongsTo(Client::class)->orderBy('area_id','asc');   
   }
}
