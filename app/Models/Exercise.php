<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exercise extends Model {
    protected $table      = 'exercise';
    protected $primaryKey = 'ExerciseId';

    protected $fillable = [
        'ExerciseId',
        'Exercise',
        'IsRemoved',
        'created_at',
        'updated_at',
    ];

    public function AssignWorkout() {
        return $this->hasMany('App\Models\AssignWorkout', 'ExerciseId', 'ExerciseId');
    }
}
