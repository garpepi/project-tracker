<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email_configuration extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded=['id'];

    public function frequency()
    {
    	return $this->belongsTo('App\Models\Frequency', 'frequency_id', 'id');
    }
    public function email()
    {
        return $this->hasMany('App\Models\Email', 'email_config_id', 'id');
    }

    protected static function boot() {
        parent::boot();

        static::deleted(function ($email) {
          $email->email()->delete();
        });
    }
}
