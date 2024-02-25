<?php
namespace Gladiator\Aficadev\App\Controllers;
use function Gladiator\Aficadev\Core\Helpers\view as ViewHelper;
class Controller
{
    public function view(string $template, array $data = [])
    {
        return ViewHelper($template, $data);
    }
}