<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerHelpline extends Model {
    protected $table      = 'customer_helpline';
    protected $primaryKey = 'CustomerHelplineId';

    protected $fillable = [
        'CustomerHelplineId',
        'UserId',
        'ResumeId',
        'ResumeFieldId',
        'ResumeFieldQuestion',
        'ResumeFieldAnswer',
        'IsRemoved',
        'created_at',
        'updated_at',
    ];

    public function User() {
        return $this->hasOne('App\Models\User', 'UserId', 'UserId');
    }

    public function Resume() {
        return $this->hasOne('App\Models\Resume', 'ResumeId', 'ResumeId');
    }
}
