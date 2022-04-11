<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Progress_item_history extends Model
{
    use HasFactory;
    protected $table='progress_items_history';
    protected $guarded=['id'];
}