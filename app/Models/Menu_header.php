<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu_header extends Model
{
    use HasFactory;
    protected $table='menu_header';
    protected $guarded=['id'];

    public function menu()
    {
        return $this->hasMany('App\Models\Menu');
    }
}
