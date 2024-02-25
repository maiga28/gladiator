<?php
namespace Gladiator\Aficadev\App\Controllers;
use Gladiator\Aficadev\App\Controllers\Controller;
use Gladiator\Aficadev\App\Models\Test;

// use Gladiator\Aficadev\Core\helpers;

class HomeController extends Controller
{
    
    public function index()
    {
        $tests = Test::all();
        // var_dump($tests);
        return $this->view('index', compact('tests'));
    }
}
