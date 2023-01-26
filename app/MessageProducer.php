<?php

namespace App;

use PhpAmqpLib\Message\AMQPMessage;

readonly class MessageProducer {
	use CanDeclareQueue;

	public function __construct(
		protected string            $queueName = 'default',
		protected ConnectionAdapter $connectionAdapter = new ConnectionAdapter()
	) {
		$this->declareQueue();
	}

	protected function publish($messageBody): void {
		$message = new AMQPMessage($messageBody);
		$this->connectionAdapter->getChannel()->basic_publish($message, '', $this->queueName);
	}

	/**
	 * @throws \Exception
	 */
	public function sendMessage($messageBody): void {
		$this->publish($messageBody);
		$this->connectionAdapter->close();
	}
}