<?php
require("../vendor/autoload.php");

use Gladiator\Aficadev\Core\Router;
use Gladiator\Aficadev\App\Controllers\HomeController;

$router = new Router();

$router->get('/', HomeController::class, 'index', 'home');

$router->run();
