<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Global_total_value_history extends Model
{
    use HasFactory;
    protected $table='global_total_value_history';
    protected $guarded=['id'];

    public function global_total_value()
    {
    	return $this->belongsTo('App\Models\Global_total_value');
    }
}
