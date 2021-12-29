<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkoutDate extends Model {
    protected $table      = 'workout_date';
    protected $primaryKey = 'WorkoutDateId';

    protected $fillable = [
        'WorkoutDateId',
        'UserId',
        'WorkoutDate',
        'IsRemoved',
        'created_at',
        'updated_at',
    ];

    public function Workout() {
        return $this->hasMany('App\Models\Workout', 'WorkoutDateId', 'WorkoutDateId');
    }
}
