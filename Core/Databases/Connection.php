<?php

namespace Gladiator\Aficadev\Core\Databases;

use Illuminate\Database\Capsule\Manager as Capsule;

use Gladiator\Aficadev\Core\Config;

class Connection
{
    private $capsule;
    private $connection;

    public function __construct()
    {
        $this->capsule = new Capsule;
        $this->initialize();
    }

    /**
     * Undocumented function
     *
     * @param String $type
     * @return array
     */
    private function getConfig(String $type)
    {
        switch ($type) {
            case 'mysql':
                return [
                    'driver'    => Config::gladEnv("DB_CONNECTION", 'mysql'),
                    'host'      => Config::gladEnv("DB_HOST", '127.0.0.1'),
                    'database'  => Config::gladEnv("DB_DATABASE", 'gladiator'),
                    'username'  => Config::gladEnv("DB_USERNAME", 'gladiator'),
                    'password'  => Config::gladEnv("DB_PASSWORD", ''),
                    'charset'   => 'utf8',
                    'collation' => 'utf8_unicode_ci',
                    'prefix'    => '',
                ];
                break;

            case 'sqlite':
                return [
                    'driver'                  => 'sqlite',
                    'url'                     => Config::gladEnv("DB_HOST", ''),
                    'database'                => Config::gladEnv("DB_DATABASE", __DIR__ . DIRECTORY_SEPARATOR . 'database.sqlite'),
                    'prefix'                  => '',
                    'foreign_key_constraints' => true,
                ];
                break;

            default:
                return [
                    'driver'    => Config::gladEnv("DB_CONNECTION", 'mysql'),
                    'host'      => Config::gladEnv("DB_HOST", '127.0.0.1'),
                    'database'  => Config::gladEnv("DB_DATABASE", 'gladiator'),
                    'username'  => Config::gladEnv("DB_USERNAME", 'gladiator'),
                    'password'  => Config::gladEnv("DB_PASSWORD", ''),
                    'charset'   => 'utf8',
                    'collation' => 'utf8_unicode_ci',
                    'prefix'    => '',
                ];
                break;
        }
    }

    private function initialize()
    {
        // var_dump(Config::get("default"));die();
        $this->capsule->addConnection($this->getConfig(Config::gladEnv("DB_CONNECTION", 'mysql')));

        $this->capsule->setAsGlobal();
        $this->capsule->bootEloquent();
    }

    public function getConnection()
    {
        if (!$this->connection) {
            $this->connection = $this->capsule->getConnection();
        }
        return $this->connection;
    }

    public function getQueryBuilder()
    {
        return $this->getConnection()->getQueryBuilder();
    }
}
