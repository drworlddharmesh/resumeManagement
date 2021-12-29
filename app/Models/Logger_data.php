<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logger_data extends Model {
    protected $table      = 'logger_data';
    protected $primaryKey = 'Id';

    protected $fillable = [
        'Id',
        'LoggerStatus',
        'LoggerBrower',
        'LoggerIpAddress',
        'LoggerResumeNo',
        'IsRemoved',
        'created_at',
        'updated_at',
    ];

}
