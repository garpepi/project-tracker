<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded=['id'];
    public $timestamps = true;
    // protected $fillable=['email'];

    public function email_configuration(){
        $this->belongsTo('App\Models\Email_configuration', 'email_config_id', 'id');
    }
}
