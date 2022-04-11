<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actual_payable_payed extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    protected $table='actual_payable_payed';

    public function project_cost()
    {
    	return $this->belongsTo('App\Models\Project_cost');
    }
    public function project()
    {
    	return $this->belongsTo('App\Models\Project');
    }
}
