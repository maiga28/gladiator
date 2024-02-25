<?php
namespace Gladiator\Aficadev\Core\Helpers;

use Illuminate\View\Factory;
use Illuminate\View\FileViewFinder;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Events\Dispatcher;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\View\Compilers\BladeCompiler;

// Initialiser une instance unique de l'objet Blade
$blade = null;

if (!function_exists('view')) {
    // Définissez la fonction helper view
    function view(string $template, array $data = [])
    {
        global $blade;

        // Créer une instance de Filesystem pour gérer les fichiers
        $filesystem = new Filesystem();

        // Définir les chemins vers vos répertoires de vues
        $viewPaths = [dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views' . DIRECTORY_SEPARATOR];

        // Créer une instance de FileViewFinder pour trouver les fichiers de vues
        $viewFinder = new FileViewFinder($filesystem, $viewPaths,["glad.php","blade.php", "php", "css", "html"]);

        // Créer une instance de EngineResolver pour résoudre les moteurs de vue
        $resolver = new EngineResolver;
        $resolver->register('blade', function () use ($filesystem, $viewFinder) {
            $compiler = new BladeCompiler($filesystem,dirname(__DIR__) . DIRECTORY_SEPARATOR . 'views'); // Utilisation de BladeCompiler
            die("Error registering blade");
            return new CompilerEngine($compiler);
        });

        $resolver->register('php', function () use ($filesystem) {
            return new PhpEngine($filesystem);
        });

        // Créer une instance de Factory pour charger et rendre les vues
        $blade = new Factory($resolver, $viewFinder, new Dispatcher());

        // Rendez le template avec Blade et retournez le résultat
        return $blade->make($template, $data)->render();
    }
}
