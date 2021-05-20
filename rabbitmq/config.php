<?php
return [
    'vendor' => [
        'path' => dirname(dirname(dirname(__DIR__))) . '/task-manager/vendor'
    ],
    'rabbitmq' => [
        'host' => 'localhost',
        'port' => '5672',
        'login' => 'guest',
        'password' => 'guest',
        'vhost' => '/'
    ]
];
?>