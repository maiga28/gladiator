<?php 

namespace Gladiator\Aficadev\Core;

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\FileViewFinder;
use Illuminate\View\Factory;

class Blade {

    /**
     * Array containing paths where to look for blade files
     * @var array
     */
    public $viewPaths;

    /**
     * Location where to store cached views
     * @var string
     */
    public $cachePath;

    protected Container $container;

    /**
     * @var Illuminate\View\Factory
     */
    protected $instance;

    /**
     * Initialize class
     * @param array  $viewPaths
     * @param string $cachePath
     * @param Illuminate\Events\Dispatcher|null $events
     */
    function __construct($viewPaths, $cachePath, Dispatcher $events = null) {

        $this->container = new Container;

        $this->viewPaths = (array) $viewPaths;

        $this->cachePath = $cachePath;

        $this->registerFilesystem();

        $this->registerEvents($events ?: new Dispatcher);

        $this->registerEngineResolver();

        $this->registerViewFinder();

        $this->instance = $this->registerFactory();
    }

    public function view()
    {
        return $this->instance;
    }

    /**
     * Undocumented function
     *
     * @return Filesystem
     */
    public function registerFilesystem()
    {
        $this->container->singleton('files', function(){
            return new Filesystem;
        });
    }
    public function registerEvents(Dispatcher $events)
    {
        $this->container->singleton('events', function() use ($events)
        {
            return $events;
        });
    }
    /**
     * Register the engine resolver instance.
     *
     * @return void
     */
    public function registerEngineResolver()
    {
        $me = $this;

        $this->container->singleton('view.engine.resolver', function($app) use ($me)
        {
            $resolver = new EngineResolver;

            foreach (array('php', 'blade') as $engine)
            {
                // die($engine);
                $me->{'register'.ucfirst($engine).'Engine'}($resolver);
            }

            return $resolver;
        });
    }

    /**
     * Register the PHP engine implementation.
     *
     * @param  \Illuminate\View\Engines\EngineResolver  $resolver
     * @return void|PhpEngine
     */
    public function registerPhpEngine($resolver)
    {
        $resolver->register('php', function() { return new PhpEngine($this->registerFilesystem()); });
    }

    /**
     * Register the Blade engine implementation.
     *
     * @param  \Illuminate\View\Engines\EngineResolver  $resolver
     * @return void
     */
    public function registerBladeEngine($resolver)
    {
        $me = $this;
        $app = $this->container;

        $this->container->singleton('blade.compiler', function($app) use ($me)
        {
            $cache = $me->cachePath;

            return new BladeCompiler($app['files'], $cache);
        });

        $resolver->register('blade', function() use ($app)
        {
            return new CompilerEngine($app['blade.compiler'], $app['files']);
        });
    }

    /**
     * Register the view finder implementation.
     *
     * @return void
     */
    public function registerViewFinder()
    {
        $me = $this;
        $this->container->singleton('view.finder', function($app) use ($me)
        {
            $paths = $me->viewPaths;

            return new FileViewFinder($app['files'], $paths);
        });
    }

    /**
     * Register the view environment.
     *
     * @return void
     */
    public function registerFactory()
    {
        $resolver = $this->container['view.engine.resolver'];
        $finder = $this->container['view.finder'];
        $env = new Factory($resolver, $finder, $this->container['events']);
        $env->setContainer($this->container);
        return $env;
    }

    public function getCompiler()
    {
        return $this->container['blade.compiler'];
    }
}
