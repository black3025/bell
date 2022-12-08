<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
       'loan_id',
       'amount',
       'date',
       'or_number',
       'p_nlid',
       'user_id',
       'client_id',
   ];


   public function loan(){
       return $this->belongsTo(Loan::class);
   }

   public function users(){
      return $this->belongsTo(User::class);
   }
}
