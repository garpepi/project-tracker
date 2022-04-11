<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project_history extends Model
{
    use HasFactory;
    protected $table='projects_history';
    protected $guarded=['id'];

    public function client()
    {
    	return $this->belongsTo('App\Models\Client');
    }
    public function contract()
    {
    	return $this->belongsTo('App\Models\Contract');
    }
    public function project()
    {
    	return $this->belongsTo('App\Models\Project');
    }
}
