<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tax_proof_history extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded=['id'];
    protected $table='tax_proof_history';

    public function tax_proof()
    {
    	return $this->belongsTo('App\Models\Tax_proof', 'tax_proof_id', 'id');
    }
}
