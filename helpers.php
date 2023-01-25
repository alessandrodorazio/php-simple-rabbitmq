<?php

require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;

function loadEnv() {
	$dotenv = Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
	$dotenv->load();
}
/**
 * @throws \Exception
 */
function createConnection() {
	loadEnv();
	return new AMQPStreamConnection(
		getenv('RABBITMQ_HOST'),
		getenv('RABBITMQ_PORT'),
		getenv('RABBITMQ_USER'),
		getenv('RABBITMQ_PASS')
	);
}
