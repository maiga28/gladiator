<?php
require("../vendor/autoload.php");

use Gladiator\Aficadev\Core\Router;
// use Gladiator\Aficadev\Core\Databases\Connection;
use Gladiator\Aficadev\App\Controllers\HomeController;

// Connection::initialize();

use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'test',
    'username'  => 'root',
    'password'  => '',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

// Set the event dispatcher used by Eloquent models... (optional)
use Illuminate\Events\Dispatcher;
use Illuminate\Container\Container;
$capsule->setEventDispatcher(new Dispatcher(new Container));

// Make this Capsule instance available globally via static methods... (optional)
$capsule->setAsGlobal();

// Setup the Eloquent ORM... (optional; unless you've used setEventDispatcher())
$capsule->bootEloquent();

$users = Capsule::select('select * from test', []);
var_dump($users);
$router = new Router();

$router->get('/', HomeController::class, 'index', 'home');

$router->run();
