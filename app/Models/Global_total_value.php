<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Global_total_value extends Model
{
    use HasFactory;
    protected $table='global_total_value';
    protected $guarded=['id'];

    public function blanket()
    {
    	return $this->hasMany('App\Models\Blanket');
    }
}
