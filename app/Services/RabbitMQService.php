<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class RabbitMQService
{
    public function publish($data)
    {
        $connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST'),
            env('RABBITMQ_PORT'),
            env('RABBITMQ_USER'),
            env('RABBITMQ_PASSWORD')
        );
        $channel = $connection->channel();

        $channel->queue_declare(env('RABBITMQ_QUEUE_NAME'), false, false, false, false);

        $msg = new AMQPMessage(json_encode($data));
        $channel->basic_publish($msg, '', env('RABBITMQ_QUEUE_NAME'));

        $channel->close();
        $connection->close();

        Log::info("In RabbitMQService");
    }
}
