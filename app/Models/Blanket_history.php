<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blanket_history extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded=['id'];
    protected $table='blanket_history';

    public function contract_history()
    {
    	return $this->belongsTo('App\Models\Contract_history');
    }
}
