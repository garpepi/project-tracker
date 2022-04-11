<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Menu extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded=['id'];

    public function menu_header()
    {
    	return $this->belongsTo('App\Models\Menu_header');
    }
    public function access_menu()
    {
    	return $this->hasMany('App\Models\Access_menu');
    }
}
