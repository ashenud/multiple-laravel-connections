<?php

return [
    'oracle' => [
        'driver'         => 'oracle',
        'tns'            => env('DB_ORACLE_TNS', sprintf(
            '(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = %s)(PORT = %s)))(CONNECT_DATA=(SERVICE_NAME=%s)))',
            env('DB_ORACLE_HOST', 'oracle_server'),
            env('DB_ORACLE_PORT', '1521'),
            env('DB_ORACLE_SERVICE_NAME', 'freepdb1')
        )),
        'host'           => env('DB_ORACLE_HOST', ''),
        'port'           => env('DB_ORACLE_PORT', '1521'),
        'database'       => env('DB_ORACLE_DATABASE', ''),
        'username'       => env('DB_ORACLE_USERNAME', ''),
        'password'       => env('DB_ORACLE_PASSWORD', ''),
        'charset'        => env('DB_ORACLE_CHARSET', 'AL32UTF8'),
        'prefix'         => env('DB_ORACLE_PREFIX', ''),
        'prefix_schema'  => env('DB_ORACLE_SCHEMA_PREFIX', ''),
        // 'edition'        => env('DB_ORACLE_EDITION', 'ora$base'),
        'server_version' => env('DB_ORACLE_SERVER_VERSION', '11g'),
    ],
];
