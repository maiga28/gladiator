<?php
namespace Gladiator\Aficadev\Core\Helpers;


use Gladiator\Aficadev\Core\Blade;

// Initialiser une instance unique de l'objet Blade
$blade = null;

if (!function_exists('view')) {
    // Définissez la fonction helper view
    function view(string $template, array $data = [])
    {
        $views = dirname(__DIR__) .  DIRECTORY_SEPARATOR . 'views';
        $cache = dirname(__DIR__) .  DIRECTORY_SEPARATOR . 'public'.  DIRECTORY_SEPARATOR . 'cache';

        $blade = new Blade($views, $cache);
        echo $blade->view()->make($template, $data)->render();
    }
}
