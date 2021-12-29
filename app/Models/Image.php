<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model {
    protected $table      = 'images';
    protected $primaryKey = 'ImageId';

    protected $fillable = [
        'ImageId',
        'ImageName',
        'IsRemoved',
        'created_at',
        'updated_at',
    ];
}
