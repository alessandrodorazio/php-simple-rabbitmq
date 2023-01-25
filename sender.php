<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\MessageSender;
use Dotenv\Dotenv;

$dotenv = Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

$sender = new MessageSender('default', new \App\ConnectionAdapter());
$sender->sendMessage( json_encode(['name' => 'Message!']));