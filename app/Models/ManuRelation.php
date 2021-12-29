<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManuRelation extends Model {
    protected $table      = 'manu_relation';
    protected $primaryKey = 'ManuRelationId';

    protected $fillable = [
        'ManuRelationId',
        'ManuId',
        'UserId',
        'Status',
        'IsRemoved',
        'created_at',
        'updated_at',
    ];

    public function Manus()
    {
        return $this->hasMany('App\Models\Manu', 'ManuId', 'ManuId');
    }
}
