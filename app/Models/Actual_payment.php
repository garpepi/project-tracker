<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actual_payment extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    protected $table='actual_payments';

    public function invoice()
    {
    	return $this->belongsTo('App\Models\Invoice');
    }
    public function project()
    {
    	return $this->belongsTo('App\Models\Project');
    }
}
