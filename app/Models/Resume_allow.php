<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resume_allow extends Model {
    protected $table      = 'resume_allows';
    protected $primaryKey = 'ResumeAllowId';

    protected $fillable = [
        'ResumeAllowId',
        'ResumeAllowUserId',
        'ResumeAllowResumeId',
        'IsRemoved',
        'created_at',
        'updated_at',
    ];
    public function User() {
        return $this->hasOne('App\Models\User', 'UserId', 'ResumeAllowUserId');
    }
    public function Resume() {
        return $this->hasOne('App\Models\Resume', 'ResumeId', 'ResumeAllowResumeId');
    }
     public function self() {
        return $this->hasMany('App\Models\Resume_allow', 'ResumeAllowUserId', 'ResumeAllowUserId');
    }
    public function excelData() {
        return $this->hasOne('App\Models\Resume_detail', 'ResumeAllowId', 'ResumeAllowId');
    }
    public function Resume_detail() {
        return $this->hasOne('App\Models\Resume_detail', 'ResumeAllowId', 'ResumeAllowId');
    }
}
