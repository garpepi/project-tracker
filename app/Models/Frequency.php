<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Frequency extends Model
{
    use HasFactory;
    protected $guarded=['id'];
    protected $fillable=['name'];

    public function email_configuration(){
        $this->hasMany('App\Models\Email_configuration');
    }
}
