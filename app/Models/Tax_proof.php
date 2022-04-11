<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tax_proof extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded=['id'];
    protected $table='tax_proof';

    public function project()
    {
    	return $this->belongsTo('App\Models\Project');
    }

    public function invoice()
    {
    	return $this->belongsTo('App\Models\Invoice');
    }

    public function progress_item()
    {
    	return $this->belongsTo('App\Models\Progress_item', 'progress_id', 'id');
    }

    public function tax()
    {
    	return $this->belongsTo('App\Models\Tax', 'tax_id', 'id');
    }


}
