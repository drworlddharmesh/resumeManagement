<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BodyState extends Model {
    protected $table      = 'body_state';
    protected $primaryKey = 'BodyStateId';

    protected $fillable = [
        'BodyStateId',
        'UserId',
        'Date',
        'Height',
        'BodyTop',
        'Weight',
        'Neck',
        'Chest',
        'Waist',
        'Hips',
        'BicepsL',
        'BicepsR',
        'ThighsL',
        'ThighsR',
        'CalvesL',
        'CalvesR',
        'IsRemoved',
        'created_at',
        'updated_at',
    ];
}
