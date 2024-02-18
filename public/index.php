<?php
require("../vendor/autoload.php");

use Gladiator\Aficadev\Core\Router;
use Gladiator\Aficadev\Core\Databases\Connection;
use Gladiator\Aficadev\App\Controllers\HomeController;

// Initialiser la connexion à la base de données
$connection = new Connection();


$router = new Router();

$router->get('/', HomeController::class, 'index', 'home');

$router->run();
