<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tax extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded=['id'];
    protected $table='tax';

     public function tax_proof()
    {
    	return $this->hasMany('App\Models\Tax_proof');
    }
     public function tax_project_cost()
    {
    	return $this->hasMany('App\Models\Tax_project_cost');
    }
}
