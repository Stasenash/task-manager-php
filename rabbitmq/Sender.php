<?php
namespace app\rabbitmq;

require_once '..\vendor\autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Sender
{
    public function sendMessage($message) {
            $config = require "config.php";

            $connection = new AMQPStreamConnection($config['rabbitmq']['host'], $config['rabbitmq']['port'],
                $config['rabbitmq']['login'], $config['rabbitmq']['password'], $config['rabbitmq']['vhost']);
            $channel = $connection->channel();

            //The sender does not need to set up a queue, but for persistence, it is recommended to execute the queue.
            $channel->queue_declare('hello', false, false, false, false);

            $msg = new AMQPMessage($message);
            $channel->basic_publish($msg, '', 'hello');

            $channel->close();
            $connection->close();
    }
}
?>