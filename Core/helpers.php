<?php

namespace Gladiator\Aficadev\Core\Helpers;

use Gladiator\Aficadev\Core\GladTemplateEngine;

if (!function_exists('view')) {
    // Définissez la fonction helper view
    function view(string $template, array $data = [])
    {
        // Instanciez la classe GladTemplateEngine en passant les données
        $templateEngine = new GladTemplateEngine($data);

        // Rendez le template et retournez le résultat
        echo $templateEngine->render($template,[]);
    }
}
