<?php

namespace Gladiator\Aficadev\Core\Databases;

use Illuminate\Database\Capsule\Manager as Capsule;

class Connection
{
    private $capsule;
    private $connection;
    
    public function __construct()
    {
        $this->capsule = new Capsule;
        $this->initialize();
    }

    private function initialize()
    {
        $this->capsule->addConnection([
            'driver'    => 'mysql',
            'host'      => 'localhost',
            'database'  => 'test',
            'username'  => 'root',
            'password'  => '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);

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
