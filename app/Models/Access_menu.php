<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Access_menu extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded=['id'];

    public function menu()
    {
    	return $this->belongsTo('App\Models\Menu');
    }
    public function role()
    {
    	return $this->belongsTo('App\Models\Role');
    }
}
