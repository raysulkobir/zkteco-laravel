<?php

namespace Raysulkobir\ZktecoLaravel\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FingerDevices extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['name', 'ip', 'serial_number', 'tcp_port'];
}
