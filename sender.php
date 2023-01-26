<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\ConnectionAdapter;
use App\MessageProducer;
use Dotenv\Dotenv;

$dotenv = Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

$sender = new MessageProducer('default', new ConnectionAdapter());
$sender->sendMessage( json_encode(['name' => 'Message!']));