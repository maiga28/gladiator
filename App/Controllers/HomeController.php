<?php
namespace Gladiator\Aficadev\App\Controllers;
use Gladiator\Aficadev\App\Controllers\Controller;
use Gladiator\Aficadev\App\Models\Test;

class HomeController extends Controller
{
    public function index()
    {
        $tests = Test::all();
        foreach ($tests as $key => $test) {
            var_dump($test->name);
        }
    }
}
