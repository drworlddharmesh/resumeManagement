<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerCare extends Model {
    protected $table      = 'customer_cares';
    protected $primaryKey = 'CustomerCareId';

    protected $fillable = [
        'CustomerCareId',
        'CustomerCareNo',
        'IsRemoved',
        'created_at',
        'updated_at',
    ];
}
