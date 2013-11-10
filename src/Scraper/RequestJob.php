<?php

namespace Scraper;

use Multitask\Job;
use Net_Http_Client;

class RequestJob extends Job {

	protected $url;

	public function __construct($url) {
		$this->url = $url;
	}

	public function run() {
		$client = new Net_Http_Client();
		$client->get($this->url);

		if($client->getStatus() == 200) {
			return str_get_html($client->getBody());
		}

		return false;
	}
} 