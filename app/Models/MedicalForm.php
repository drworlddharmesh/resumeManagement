<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicalForm extends Model {
    protected $table      = 'medical_form';
    protected $primaryKey = 'MedicalFormId';

    protected $fillable = [
        'MedicalFormId',
        'UserId',
        'Date',
        'DateOfBirth',
        'IsInjury',
        'InjuryDetail',
        'IsTakingMedicine',
        'IsPregnant',
        'IsPhysicianKnow',
        'IsRecentHealthCheckup',
        'Others',
        'IsRemoved',
        'created_at',
        'updated_at',
    ];

    public function User() {
        return $this->hasOne('App\Models\User', 'UserId', 'UserId');
    }

    public function MedicalHealthCondition() {
        return $this->hasMany('App\Models\MedicalHealthCondition', 'MedicalFormId', 'MedicalFormId');
    }
}
