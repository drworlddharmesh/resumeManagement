<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agreement extends Model {
    protected $table      = 'agreements';
    protected $primaryKey = 'AgreementId';

    protected $fillable = [
        'AgreementId',
        'AgreementNo',
        'AgreementPDF',
        'IsRemoved',
        'created_at',
        'updated_at',
    ];
}
