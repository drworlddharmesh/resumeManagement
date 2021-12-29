<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Remark extends Model {
    protected $table      = 'remarks';
    protected $primaryKey = 'RemarkId';

    protected $fillable = [
        'RemarkId',
        'RemarkUserId',
        'RemarkText',
        'IsRemoved',
        'created_at',
        'updated_at',
    ];

    public function remark() {
        return $this->hasOne('App\Models\User', 'UserId', 'RemarkUserId');

    }
}
