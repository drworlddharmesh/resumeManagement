<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logger_user extends Model {
    protected $table      = 'logger_users';
    protected $primaryKey = 'Id';

    protected $fillable = [
        'Id',
        'UserId',
        'IsRemoved',
        'created_at',
        'updated_at',
    ];

    public function User() {
        return $this->hasOne('App\Models\User', 'UserId', 'UserId');

    }

}
