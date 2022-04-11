<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract_history extends Model
{
    use HasFactory;
    protected $table='contracts_history';
    protected $guarded=['id'];

    public function contract()
    {
    	return $this->belongsTo('App\Models\Contract','cont_id');
    }

    public function blanket_history()
    {
    	return $this->hasMany('App\Models\Blanket_history');
    }

    public function client()
    {
    	return $this->belongsTo('App\Models\Client');
    }

}
