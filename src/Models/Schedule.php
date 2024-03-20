<?php

namespace Raysulkobir\ZktecoLaravel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'time_in', 'time_out'];
}
