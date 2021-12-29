<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plan extends Model {
    protected $table      = 'plans';
    protected $primaryKey = 'PlanId';

    protected $fillable = [
        'PlanId',
        'PlanNo',
        'PlanName',
        'PlanDays',
        'PlanForms',
        'PlanQcCutoff',
        'AgreementText',
        'PlanFees',
        'IsRemoved',
        'created_at',
        'updated_at',
    ];
}
