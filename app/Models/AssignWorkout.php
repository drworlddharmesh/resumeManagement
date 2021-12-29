<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignWorkout extends Model {
    protected $table      = 'assign_workout';
    protected $primaryKey = 'AssignWorkoutId';

    protected $fillable = [
        'AssignWorkoutId',
        'CoachId',
        'UserId',
        'ExerciseId',
        'Sets',
        'Target',
        'IsRemoved',
        'created_at',
        'updated_at',
    ];


    public function User() {
        return $this->hasOne('App\Models\User', 'UserId', 'UserId');
    }
}
