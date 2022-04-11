<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proof_of_invoice_payment extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    public function actual_payment()
    {
    	return $this->belongsTo('App\Models\Actual_payment');
    }
}
