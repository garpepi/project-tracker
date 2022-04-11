<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blanket extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded=['id'];
    protected $table='blanket';

    public function contract()
    {
    	return $this->belongsTo('App\Models\Contract');
    }
    public function g_quantity()
    {
    	return $this->belongsTo('App\Models\Global_quantity','global_quantity_id', 'id');
    }
    public function g_total_value()
    {
    	return $this->belongsTo('App\Models\Global_total_value','global_total_value_id', 'id');
    }
    public function useblanket()
    {
    	return $this->hasMany('App\Models\Useblanket');
    }
}
