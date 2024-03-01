<?php

namespace Config;

use CodeIgniter\Database\Config;

class Database extends Config
{
    public $activeGroup = 'default';

    public $defaultGroup = 'default';

    public $queryBuilder = 'CodeIgniter\Database\Query';

    public $default = [
        'DSN'      => '',
        'hostname' => '',
        'username' => '',
        'password' => '',
        'database' => 'C:\Users\gothi\databases\sqlite\gestione_prodotti.db',
        'DBDriver' => 'SQLite3',
        'DBPrefix' => '',
        'pConnect' => false,
        'DBDebug'  => (ENVIRONMENT !== 'production'),
        'cacheOn'  => false,
        'cacheDir' => '',
        'charset'  => 'utf8',
        'DBCollat' => 'utf8_general_ci',
        'swapPre'  => '',
        'encrypt'  => false,
        'compress' => false,
        'strictOn' => false,
        'failover' => [],
        'port'     => 3306,
    ];
}
