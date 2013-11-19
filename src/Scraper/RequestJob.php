<?php

namespace Scraper;

use Net_Http_Client;
use Multitask\Job;

class RequestJob extends Job {

	protected $url;
	protected $callback;

	public function __construct($url, $callback) {
		$this->url = $url;
		$this->callback = $callback;
	}

	public function run() {
		$client = new Net_Http_Client();
		$client->get($this->url);

		if($client->getStatus() == 200) {
			call_user_func($this->callback, str_get_html($client->getBody()));
		}
	}
} 