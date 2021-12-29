<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FitnessTest extends Model {
    protected $table      = 'fitness_test';
    protected $primaryKey = 'FitnessTestId';

    protected $fillable = [
        'FitnessTestId',
        'UserId',
        'Date',
        'HrRest',
        'THRZ',
        'BP',
        'PredHrMax',
        'Vo2MaxFromTable',
        'TimeAchieved',
        'HrMaxAchieved',
        'Rating',
        'AChestPressMidRow',
        'AWtLifted',
        'AReps',
        'A1Rm',
        'BLegPressLegExt',
        'BWtLifted',
        'BReps',
        'B1Rm',
        'PushUps',
        'CurlUps',
        'Pank',
        'WallSit',
        'SitAndReach',
        'ShoulderL',
        'ShoulderR',
        'IsRemoved',
        'created_at',
        'updated_at',
    ];
}
