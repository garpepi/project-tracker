<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Viewable extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded=['id'];
    protected $table='viewable';

    public function contract()
    {
    	return $this->belongsTo('App\Models\Contract');
    }
    public function project()
    {
    	return $this->belongsTo('App\Models\Project');
    }
}
