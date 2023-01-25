<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

$queueName = 'hello';
$messageBody = 'Hello World!';

$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

try {
	echo time();
	$connection = new AMQPStreamConnection(
		getenv('RABBITMQ_HOST'),
		getenv('RABBITMQ_PORT'),
		getenv('RABBITMQ_USER'),
		getenv('RABBITMQ_PASS')
	);
	$channel = $connection->channel();
	$channel->queue_declare($queueName, false, false ,false ,false);
	$message = new AMQPMessage($messageBody);
	$channel->basic_publish($message, '', $queueName);
	echo ' [x] Sent ' . $message->body ;
	$channel->close();
	$connection->close();
} catch (Exception $e) {
	echo 'Error: ' . $e->getMessage();
}
