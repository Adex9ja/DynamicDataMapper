<?php

$local = ($_SERVER['REMOTE_ADDR'] == '127.0.0.1' || $_SERVER['REMOTE_ADDR'] == '::1' ) ? true : false;
$hostname = $local ? 'localhost' : '';
$db_name = $local ? 'dynamic_data_map' : '';
$db_user_name = $local ? 'root' : '';
$db_password = $local ? '' : '';
$settings = [
    'settings' => [
        'db' => [
            // Eloquent configuration
            'driver'    => 'mysql',
            'host'      => $hostname,
            'database'  => $db_name,
            'username'  => $db_user_name,
            'password'  => $db_password,
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ],
        ]
];