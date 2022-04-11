<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project_cost_history extends Model
{
    use HasFactory;
    protected $table='project_costs_history';
    protected $guarded=['id'];
}