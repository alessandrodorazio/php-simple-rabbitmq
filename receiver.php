<?php

use App\MessageReceiver;
use Dotenv\Dotenv;
use PhpAmqpLib\Message\AMQPMessage;

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/helpers.php';

$dotenv = Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

$callback = function (AMQPMessage $msg) {
	echo ' [x] Received ', $msg->body, "\n";
};

$receiver = new MessageReceiver('default', new \App\ConnectionAdapter());
$receiver->receiveMessages($callback);
