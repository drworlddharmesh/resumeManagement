<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manu extends Model {
    protected $table      = 'manus';
    protected $primaryKey = 'ManuId';

    protected $fillable = [
        'ManuId',
        'ManuName',
        'IsRemoved',
        'created_at',
        'updated_at',
    ];

    public function ManuRelation() {
        return $this->hasMany('App\Models\ManuRelation', 'ManuId', 'ManuId');
    }
}
