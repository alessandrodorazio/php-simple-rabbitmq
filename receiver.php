<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

function receiveMessages() {
	try {
		$connection = new AMQPStreamConnection(
			getenv('RABBITMQ_HOST'),
			getenv('RABBITMQ_PORT'),
			getenv('RABBITMQ_USER'),
			getenv('RABBITMQ_PASS')
		);
		$channel = $connection->channel();
		$channel->queue_declare('hello', false, false, false, false);
		echo " [*] Waiting for messages. To exit press CTRL+C\n";
		$callback = function ($msg) {
			echo ' [x] Received ', $msg->body, "\n";
		};
		$channel->basic_consume('hello', '', false, true, false, false, $callback);

		while ($channel->is_open()) {
			$channel->wait();
		}
	} catch (Exception $e) {
		echo 'Error: ' . $e->getMessage();
	}
	return true;
}
$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

receiveMessages();
