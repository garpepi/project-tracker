<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress_doc extends Model
{
    use HasFactory;
    protected $table='progress_docs';
    protected $guarded=['id'];
    public function progress_item()
    {
    	return $this->belongsTo('App\Models\Progress_item');
    }
}
