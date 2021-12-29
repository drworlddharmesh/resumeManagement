<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resume extends Model {
    protected $table      = 'resumes';
    protected $primaryKey = 'ResumeId';

    protected $fillable = [
        'ResumeId',
        'ResumeName',
        'ResumeStatus',
        'UserId',
        'IsRemoved',
        'created_at',
        'updated_at',
    ];

    public function User() {
        return $this->hasOne('App\Models\User', 'UserId', 'UserId');
    }
}
