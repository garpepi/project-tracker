<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract_doc extends Model
{
    use HasFactory;
    protected $table='contract_doc';
    protected $guarded=['id'];
    public function contract()
    {
    	return $this->belongsTo('App\Models\Contract');
    }
}
