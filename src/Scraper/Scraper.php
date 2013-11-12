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

	public function scrap($url, $callback) {
		if(!isset($this->urls[$url])) {
			$this->urls[$url] = 1;

			$job = new RequestJob($url);
			$job->once('success', $callback);

			$this->worker->add($job, $this->delay);
		}
	}

	public function wait() {
		$this->worker->wait();
	}
}