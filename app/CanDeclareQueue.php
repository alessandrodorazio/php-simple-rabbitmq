<?php

namespace App;

trait CanDeclareQueue {
	protected function declareQueue(): void {
		$this->connectionAdapter->getChannel()->queue_declare($this->queueName, false, false, false, false);
	}
}