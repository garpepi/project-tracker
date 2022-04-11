<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded=['id'];

    public function contract()
    {
    	return $this->belongsTo('App\Models\Contract');
    }
    public function progress_item()
    {
    	return $this->hasMany('App\Models\Progress_item');
    }
    public function project_cost()
    {
    	return $this->hasMany('App\Models\Project_cost');
    }
    public function his()
    {
    	return $this->hasMany('App\Models\Project_history', 'project_id', 'id');
    }
    public function invoice()
    {
    	return $this->hasMany('App\Models\Invoice');
    }
    public function actual_payment()
    {
    	return $this->hasMany('App\Models\Actual_payment');
    }
    public function useblanket()
    {
    	return $this->hasMany('App\Models\Useblanket');
    }
    public function tax_proof()
    {
    	return $this->hasMany('App\Models\Tax_proof');
    }
    public function viewable()
    {
    	return $this->hasMany('App\Models\Viewable');
    }

    // public function getall()
    // {
    //   $data = Project::with(['contract.client'])->get();
    // 	return $data;
    // }
    protected static function boot() {
        parent::boot();

        static::deleted(function ($useblanket) {
        $useblanket->useblanket()->delete();
      });
        static::deleted(function ($invoice) {
        $invoice->invoice()->delete();
      });
        static::deleted(function ($project_cost) {
        $project_cost->project_cost()->delete();
      });
      static::deleted(function ($tax_proof) {
        $tax_proof->tax_proof()->delete();
      });
      static::deleted(function ($viewable) {
        $viewable->viewable()->delete();
      });
    }
}
