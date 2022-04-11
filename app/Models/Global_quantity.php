<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Global_quantity extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    protected $table='global_quantity';

    public function blanket()
    {
    	return $this->hasMany('App\Models\Blanket');
    }
}
