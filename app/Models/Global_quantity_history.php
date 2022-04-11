<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Global_quantity_history extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    protected $table='global_quantity_history';

    public function global_quantity()
    {
    	return $this->belongsTo('App\Models\Global_quantity');
    }
}
