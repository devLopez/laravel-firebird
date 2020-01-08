<?php

namespace Igrejanet\Firebird\Providers;

use Igrejanet\Firebird\Database\FirebirdDatabaseManager;
use Illuminate\Support\ServiceProvider;

/**
 * FirebirdServiceProvider
 *
 * @author Matheus Lopes Santos <fale_com_lopez@hotmail.com>
 * @version 1.0.0
 * @package Igrejanet\Firebird\Providers
 */
class FirebirdServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->registerFirebirdProvider();
        $this->registerDatabaseManager();
    }

    public function registerFirebirdProvider()
    {
        $this->app->register(\Firebird\FirebirdServiceProvider::class);
    }


    public function registerDatabaseManager()
    {
        $this->app->singleton('db', function ($app)
        {
            return new FirebirdDatabaseManager($app, $app['db.factory']);
        });
    }
}