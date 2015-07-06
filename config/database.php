<?php

return [

    'default'     => getEnv('DB_CONNECTION') ? getEnv('DB_CONNECTION') : 'mysql',

    'migration'   => getEnv('DB_MIGRATION') ? getEnv('DB_MIGRATION') : 'databases/migration',

    'connections' => [
        'sqlite' => [
            'driver'   => 'sqlite',
            'database' => getEnv('DB_SQLITE') ? getEnv('DB_SQLITE') : 'database.sqlite',
            'prefix'   => '',
        ],
        'mysql'  => [
            'driver'    => 'mysql',
            'host'      => getEnv('DB_HOST') ? getEnv('DB_HOST') : 'localhost',
            'database'  => getEnv('DB_DATABASE') ? getEnv('DB_DATABASE') : 'forge',
            'username'  => getEnv('DB_USERNAME') ? getEnv('DB_USERNAME') : 'forge',
            'password'  => getEnv('DB_PASSWORD') ? getEnv('DB_PASSWORD') : '',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
            'strict'    => false,
        ],
        'redis'  => [
            'cluster' => false,
            'default' => [
                'host'   => '127.0.0.1',
                'port'   => 6379,
                'scheme' => 'tcp'
            ],
        ],
    ]
];