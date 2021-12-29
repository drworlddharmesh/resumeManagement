<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalHealthCondition extends Model {
    protected $table      = 'medical_health_condition';
    protected $primaryKey = 'MedicalHealthConditionId';

    protected $fillable = [
        'MedicalHealthConditionId',
        'MedicalFormId',
        'HealthConditionId',
        'IsRemoved',
        'created_at',
        'updated_at',
    ];

    public function HealthCondition() {
        return $this->hasOne('App\Models\HealthCondition', 'HealthConditionId', 'HealthConditionId');
    }
}
