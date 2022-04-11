<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress_item extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    public function project()
    {
    	return $this->belongsTo('App\Models\Project');
    }
    public function doc()
    {
    	return $this->hasMany('App\Models\Progress_doc');
    }
    public function invoice()
    {
    	return $this->hasMany('App\Models\Invoice');
    }
    public function tax_proof()
    {
    	return $this->hasMany('App\Models\Tax_proof');
    }
    public function project_cost()
    {
    	return $this->hasMany('App\Models\Project_cost');
    }

    protected static function boot() {
        parent::boot();

        static::deleted(function ($tax_proof) {
        $tax_proof->tax_proof()->delete();
      });
    }

}
