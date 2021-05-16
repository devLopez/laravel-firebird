<?php

namespace Tests;

use Faker\Factory;
use Firebird\Connection as FirebirdConnection;
use Firebird\ConnectionFactory as FirebirdConnectionFactory;
use Firebird\FirebirdConnector;
use Igrejanet\Firebird\Database\FirebirdDatabaseManager;
use Illuminate\Config\Repository as Config;
use Illuminate\Container\Container;
use Illuminate\Database\Connection;
use Illuminate\Database\Connectors\ConnectionFactory;
use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;
use PHPUnit\Framework\TestCase;

class Application extends TestCase
{
    protected $app;

    protected function setUp() : void
    {
        parent::setUp();

        $this->startContainer();
    }

    public static function setUpBeforeClass() : void
    {
        parent::setUpBeforeClass();

        $static = new static();
        $static->startContainer();
        $static->dropData();
    }

    protected function startContainer()
    {
        $this->app = new Container();

        $this->app->singleton('config', function()
        {
            return new Config([
                'database' => require __DIR__ . '/config/database.php'
            ]);
        });

        $this->app->bind('db.connector.firebird', FirebirdConnector::class);

        Connection::resolverFor('firebird', function ($connection, $database, $tablePrefix, $config) {
            return new FirebirdConnection($connection, $database, $tablePrefix, $config);
        });

        $this->app->singleton('db.factory', function ($app) {
            return new ConnectionFactory($app);
        });

        $this->app->singleton('db', function ($app) {
            return new DatabaseManager($app, $app['db.factory']);
        });

        $this->app->bind('db.connection', function ($app) {
            return $app['db']->connection();
        });

        /*$this->app->singleton('db.factory', function($app)
        {
            return new FirebirdConnectionFactory($app);
        });*/

        /*$this->app->singleton('db', function ($app)
        {
            return new FirebirdDatabaseManager($app, $app['db.factory']);
        });*/

        $this->app->singleton('events', function($app)
        {
            return new Dispatcher($app);
        });

        $this->app->singleton('request', function() {
            return new Request();
        });

        Container::setInstance($this->app);

        Model::setConnectionResolver($this->app['db']);
        Model::setEventDispatcher($this->app['events']);
    }

    public function dropData()
    {
        /** @var FirebirdDatabaseManager $db */
        $db = $this->app['db'];

        $db->table('USERS')->delete();
        $db->table('PRODUCTS')->delete();
    }

    public function recriateTables()
    {
        /** @var FirebirdDatabaseManager $db */
        $db = $this->app['db'];

        $schema = $db->getSchemaBuilder();
        $pdo = $db->getPdo();

        $products = "
            create table products(
                id int not null,
                product_name varchar(60),
                price decimal(10, 2),
                constraint PK_PRODUCTS PRIMARY KEY (id)
            )
        ";

        $users = "
            create table users(
                id int not null,
                name varchar(45) not null,
                email varchar(60),
                constraint USERS_EMAIL_UNIQUE unique(email),
                constraint PK_USERS PRIMARY KEY (id)
            )
        ";

        try {
            $db->unprepared('DROP TABLE users');
            $db->unprepared('DROP TABLE products');
        } catch (\Exception $e){}

        try {
            $db->unprepared($users);
            $db->unprepared($products);
        } catch (\Exception $e) {}

//        $db->getSchemaBuilder()->dropIfExists('USERS');
//        $db->getSchemaBuilder()->dropIfExists('PRODUCTS');

        /*try {
            $schema->drop('users');
            $schema->drop('products');
        } catch (\Exception $e) {}*/

            /*$schema->create('PRODUCTS', function(Blueprint $table)
            {
                $table->integer('id')->primary();
                $table->string('product_name', 45)->nullable();
                $table->double('price', 10, 2)->nullable();
            });

            $schema->create('USERS', function(Blueprint $table)
            {
                $table->integer('id')->primary()->nullable();
                $table->string('name', 45)->nullable();
                $table->string('email', 60)->unique()->nullable();
            });*/

        /*$db->unprepared('drop generator GEN_USERS');
        $db->unprepared('create generator GEN_USERS');
        $db->unprepared('set generator GEN_USERS to 0');*/
    }
}