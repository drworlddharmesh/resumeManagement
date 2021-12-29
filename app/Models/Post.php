<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model {
    protected $table      = 'post';
    protected $primaryKey = 'PostId';

    protected $fillable = [
        'PostId',
        'UserId',
        'Description',
        'Media',
        'MediaType',
        'VideoThumbnail',
        'IsRemoved',
        'created_at',
        'updated_at',
    ];

    public function User() {
        return $this->hasOne('App\Models\User', 'UserId', 'UserId');
    }
}
