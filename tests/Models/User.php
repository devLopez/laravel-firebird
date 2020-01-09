<?php

namespace Tests\Models;

use Igrejanet\Firebird\FirebirdModel;

class User extends FirebirdModel
{
    protected $table = 'USERS';

    protected $primaryKey = 'ID';

    protected $generator = 'GEN_USERS';

    public $timestamps = false;

    protected $fillable = [
        'NAME',
        'EMAIL'
    ];
}