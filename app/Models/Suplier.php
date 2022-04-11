<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Suplier extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    protected $table='suplier';

    public function project_cost()
    {
    	return $this->hasMany('App\Models\Project_cost');
    }
}
