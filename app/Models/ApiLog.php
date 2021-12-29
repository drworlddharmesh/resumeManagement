<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiLog extends Model {
    protected $table      = 'api_log';
    protected $primaryKey = 'ApiLogId';

    protected $fillable = [
        'ApiLogId',
        'UserId',
        'ApiName',
        'Request',
        'Response',
        'created_at',
        'updated_at',
    ];
}
