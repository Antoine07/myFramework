<?php namespace Controllers;

use PhpAmqpLib\Connection\AMQPConnection;
use PhpAmqpLib\Message\AMQPMessage;


class RabbitMQController
{

    const HOST = 'localhost';
    const PORT = 5672;
    const USERNAME = 'guest';
    const PASSWORD = 'guest';
    const VHOST = '/';

    /**
     * producer send message
     */
    public function index()
    {
        $connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->queue_declare('hello', false, false, false, false);
        $msg = new AMQPMessage('Hello World!');
        $channel->basic_publish($msg, '', 'hello');
        echo " [x] Sent 'Hello World!'\n";
        $channel->close();
        $connection->close();
    }

    /**
     * consumer
     */
    public function edit()
    {
        $connection = new AMQPConnection('localhost', 5672, 'guest', 'guest');
        $channel = $connection->channel();
        $channel->queue_declare('hello', false, false, false, false);
        echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";
        $callback = function($msg) {
            echo " [x] Received ", $msg->body, "\n";
        };
        $channel->basic_consume('hello', '', false, true, false, false, $callback);
        while(count($channel->callbacks)) {
            $channel->wait();
        }
        $channel->close();
        $connection->close();
    }
}