<?php

namespace app\rabbitmq;
use yii\base\BaseObject;
use yii\queue\JobInterface;

class MessagingJob extends BaseObject implements JobInterface
{
    public $message;

    public function execute($queue)
    {
        echo 'Сообщение "' . $this->message . '" принято в обработку' . "\n";
    }
}