<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// ["glad.php","blade.php", "php", "css", "html"]

require("../vendor/autoload.php");
include('../Core/helpers.php');

use Gladiator\Aficadev\Core\Router;
use Gladiator\Aficadev\Core\Databases\Connection;
use Gladiator\Aficadev\App\Controllers\HomeController;

// Initialiser la connexion à la base de données
$connection = new Connection();


$router = new Router();

$router->get('/', HomeController::class, 'index', 'home');

$router->run();
