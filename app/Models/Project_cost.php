<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project_cost extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded=['id'];
    protected $table='project_costs';

    public function project()
    {
    	return $this->belongsTo('App\Models\Project');
    }
    public function suplier()
    {
    	return $this->belongsTo('App\Models\Suplier');
    }
    public function progress_item()
    {
    	return $this->belongsTo('App\Models\Progress_item');
    }
    public function tax_project_cost()
    {
    	return $this->hasMany('App\Models\Tax_project_cost');
    }
    public function actual_payable_payed()
    {
    	return $this->hasMany('App\Models\Actual_payable_payed');
    }


}
