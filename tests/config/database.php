<?php

return [
    'default' => 'firebird',
    'connections' => [
        'firebird' => [
            'driver'    => 'firebird',
            'host'      => getenv('DB_HOST'),
            'database'  => getenv('DB_DATABASE'),
            'username'  => getenv('DB_USERNAME'),
            'password'  => getenv('DB_PASSWORD'),
            'charset'   => 'ISO8859_1',
            'collation' => 'ISO8859_general_ci'
        ]
    ]
];