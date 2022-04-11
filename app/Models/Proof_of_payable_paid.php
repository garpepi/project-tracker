<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proof_of_payable_paid extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    protected $table='proof_of_payable_paid';
    public function actual_payable_payed()
    {
    	return $this->belongsTo('App\Models\Actual_payable_payed');
    }
}
