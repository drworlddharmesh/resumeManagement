<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Caller extends Model {
    protected $table      = 'callers';
    protected $primaryKey = 'CallerId';

    protected $fillable = [
        'CallerId',
        'FranchiseeId',
        'FranchiseeName',
        'CallerName',
        'IsRemoved',
        'created_at',
        'updated_at',
    ];
    public function User() {
        return $this->hasMany('App\Models\User', 'CallerId', 'CallerId');
    }
    public function Franchisee()
    {
        return $this->hasOne('App\Models\Franchisee', 'FranchiseeId', 'FranchiseeId');
    }
}
