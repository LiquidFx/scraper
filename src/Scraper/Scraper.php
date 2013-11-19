<?php

namespace Scraper;

use Multitask\Worker\PoolWorker;

class Scraper {

	protected $delay;
	protected $urls = array();
	protected $worker;

	public function __construct($scrapers = 1, $delay = 0) {
		$this->worker = new PoolWorker($scrapers);
		$this->delay = $delay;
	}

	public function add($url, $callback) {
		$this->worker->add(new RequestJob($url, $callback), $this->delay);
	}

	public function wait() {
		$this->worker->wait();
	}
}