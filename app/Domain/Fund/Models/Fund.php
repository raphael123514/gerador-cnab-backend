<?php

namespace App\Domain\Fund\Models;

use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    protected $table = 'funds';

    protected $fillable = [
        'name',
        'cnpj',
        'corporate_name',
        'address_street',
        'address_number',
    ];
}
