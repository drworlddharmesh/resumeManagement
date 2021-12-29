<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workout extends Model {
    protected $table      = 'workout';
    protected $primaryKey = 'WorkoutId';

    protected $fillable = [
        'WorkoutId',
        'WorkoutDateId',
        'ExerciseId',
        'Sets',
        'Weight',
        'Target',
        'Achieved',
        'IsRemoved',
        'created_at',
        'updated_at',
    ];

    public function Exercise() {
        return $this->hasOne('App\Models\Exercise', 'ExerciseId', 'ExerciseId');
    }
}
