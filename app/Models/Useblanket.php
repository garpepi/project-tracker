<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Useblanket extends Model
{
    // use HasFactory;
    use HasFactory;
    use SoftDeletes;
    protected $guarded=['id'];
    protected $table='useblanket';

    public function contract()
    {
    	return $this->belongsTo('App\Models\Contract');
    }
    public function project()
    {
    	return $this->belongsTo('App\Models\Project');
    }
    public function blanket()
    {
    	return $this->belongsTo('App\Models\Blanket');
    }

}
