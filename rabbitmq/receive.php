<?php
    $config = require "config.php";

    require_once '..\vendor\autoload.php';

    use PhpAmqpLib\Connection\AMQPStreamConnection;
    use PhpAmqpLib\Message\AMQPMessage;

    $connection = new AMQPStreamConnection($config['rabbitmq']['host'], $config['rabbitmq']['port'],
        $config['rabbitmq']['login'], $config['rabbitmq']['password'], $config['rabbitmq']['vhost']);
    $channel = $connection->channel();

    $channel->queue_declare('hello', false, false, false, false);

    echo 'Waiting for messages.', "\n";

    $callback = function($msg) {
        echo "Сообщение '", $msg->body, "' поступило в обработку", "\n";
    };

    $channel->basic_consume('hello', '', false, true, false, false, $callback);

    while(count($channel->callbacks)) {
        $channel->wait();
    }

    $channel->close();
    $connection->close();
?>