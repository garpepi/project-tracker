<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tax_project_cost extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded=['id'];
    protected $table='tax_project_cost';

    public function project_cost()
    {
    	return $this->belongsTo('App\Models\Project_cost');
    }
    public function project()
    {
    	return $this->belongsTo('App\Models\Project');
    }
    public function tax()
    {
    	return $this->belongsTo('App\Models\Tax');
    }
}
