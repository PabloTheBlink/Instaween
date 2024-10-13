<?php

namespace App\Utils;

use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Class DB
 * This class is an extension of the Illuminate\Database\Capsule\Manager class.
 * It is used to connect to the database and perform queries.
 *
 * @package App\Utils
 */
class DB extends Capsule {}

/*
 * Create a new instance of the Capsule class and add the connection to the database.
 */
$capsule = new DB();
$capsule->addConnection([
    'driver' => 'mysql',
    'host' => $_ENV["MYSQL_HOST"],
    'database' => $_ENV["MYSQL_DATABASE"],
    'username' => $_ENV["MYSQL_USER"],
    'password' => $_ENV["MYSQL_PASSWORD"],
    'charset' => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix' => '',
]);

/*
 * Set the instance as the global instance of the Capsule class.
 */
$capsule->setAsGlobal();

/*
 * Boot the Eloquent ORM.
 */
$capsule->bootEloquent();
