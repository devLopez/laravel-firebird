<?php

namespace Igrejanet\Firebird\Database;

use Firebird\ConnectionFactory as FirebirdConnectionFactory;
use Illuminate\Database\DatabaseManager;

/**
 * FirebirdDatabaseManager
 *
 * @author Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package Igrejanet\Firebird\Database
 */
class FirebirdDatabaseManager extends DatabaseManager
{
    public function __construct($app, FirebirdConnectionFactory $factory)
    {
        parent::__construct($app, $factory);
    }
}