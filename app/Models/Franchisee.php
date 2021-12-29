<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Franchisee extends Model {
    protected $table      = 'franchisees';
    protected $primaryKey = 'FranchiseeId';

    protected $fillable = [
        'FranchiseeId',
        'FranchiseeName',
        'IsRemoved',
        'created_at',
        'updated_at',
    ];
    public function Caller() {
        return $this->hasMany('App\Models\Caller', 'FranchiseeId', 'FranchiseeId');

    }
   
}
