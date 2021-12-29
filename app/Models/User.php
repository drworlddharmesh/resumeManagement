<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model {
    protected $table      = 'users';
    protected $primaryKey = 'UserId';

    protected $fillable = [
        'UserId',
        'UserName',
        'UserLoginId',
        'UserMoblieNumber',
        'UserEmail',
        'UserPassword',
        'ResendPassword',
        'UserAddress',
        'PlanId',
        'CallerId',
        'UserStatus',
        'AgreementId',
        'UserType',
        'UserSignature',
        'UserSignatureDate',
        'UserIpAddress',
        'UserRegistrationId',
        'UserStartDate',
        'UserEndDate',
        'IsRemoved',
        'created_at',
        'updated_at',
    ];

    public function User() {
        return $this->belongsTo('App\Models\User', 'CoachId', 'UserId');
    }
    public function Caller() {
        return $this->hasOne('App\Models\Caller', 'CallerId', 'CallerId');

    }
    public function Agreement() {
        return $this->hasOne('App\Models\Agreement', 'AgreementId', 'AgreementId');

    }
    public function Plan() {
        return $this->hasOne('App\Models\Plan', 'PlanId', 'PlanId');

    }
    public function Resume_allow() {
        return $this->hasMany('App\Models\Resume_allow', 'ResumeAllowUserId', 'UserId');
    }

    public function Resume_allow_total() {
        return $this->hasMany('App\Models\Resume_allow', 'ResumeAllowUserId', 'UserId');
    }
    public function excel() {
        return $this->hasMany('App\Models\Resume_allow', 'ResumeAllowUserId', 'UserId');
    }
}
