<?php

namespace App;

readonly class MessageReceiver {
	use CanDeclareQueue;

	public function __construct(
		protected string            $queueName = 'default',
		protected ConnectionAdapter $connectionAdapter = new ConnectionAdapter()
	) {
		$this->declareQueue();
	}

	/**
	 * @throws \Exception
	 */
	public function receiveMessages(\Closure $callback): void {
		echo " [*] Waiting for messages. To exit press CTRL+C\n";
		$this->consumeQueueMessages($callback);
		$this->connectionAdapter->close();
	}

	protected function consumeQueueMessages(\Closure $callback): void {
		$this->connectionAdapter->getChannel()
			->basic_consume($this->queueName, '', false, true, false, false, $callback);
		$this->waitForMessages();
	}

	protected function waitForMessages(): void {
		while ($this->connectionAdapter->getChannel()->is_open()) {
			$this->connectionAdapter->getChannel()->wait();
		}
	}
}