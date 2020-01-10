<?php

namespace Tests\Models;

use Igrejanet\Firebird\FirebirdModel;

class Product extends FirebirdModel
{
    protected $table = 'PRODUCTS';

    protected $primaryKey = 'ID';

    public $timestamps = false;

    protected $fillable = [
        'PRODUCT_NAME',
        'PRICE'
    ];
}