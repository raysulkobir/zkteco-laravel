<?php

namespace Raysulkobir\ZktecoLaravel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'position', 'email', 'schedule_id', 'pin_code', 'permissions', 'email_verified_at', 'remember_token'];

    public function schedules()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }
}
