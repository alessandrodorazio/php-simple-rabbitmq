<?php

namespace App;

use Dotenv\Dotenv;
use PhpAmqpLib\Channel\AMQPChannel;
use PhpAmqpLib\Connection\AMQPStreamConnection;

class ConnectionAdapter {
	private AMQPStreamConnection $connection;
	private AMQPChannel $channel;

	/**
	 * @param  string  $host
	 * @throws \Exception
	 */
	public function __construct(
		private string $host = '',
		private string $port = '',
		private string $user = '',
		private string $pass = ''
	) {
		$this->host = $host ?: getenv('RABBITMQ_HOST');
		$this->port = $port ?: getenv('RABBITMQ_PORT');
		$this->user = $user ?: getenv('RABBITMQ_USER');
		$this->pass = $pass ?: getenv('RABBITMQ_PASS');
		$this->connection = new AMQPStreamConnection(
			$this->host, $this->port, $this->user, $this->pass
		);
		$this->channel = $this->connection->channel();
	}

	public function getChannel(): AMQPChannel {
		return $this->channel;
	}

	/**
	 * @throws \Exception
	 */
	public function close(): void {
		$this->channel->close();
		$this->connection->close();
	}
}