<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Type extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded=['id'];
    protected $fillable=[
        'name',
        'display',
        'required',
        'updated_by',
        'created_by',
    ];

    public function contract(){
        $this->hasMany('App\Models\Contract');
    }

    //     protected static function boot() {
    //     parent::boot();

    //     static::deleted(function ($project) {
    //       $project->project()->delete();
    //     });
    //   }
}
