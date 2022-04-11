<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Progress_status extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table='progress_status';
    protected $guarded=['id'];
}