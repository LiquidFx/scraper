<?php

namespace Scraper;

use Multitask\Job;

class RequestJob extends Job {

	protected $url;

	public function __construct($url) {
		$this->url = $url;
	}

	public function run() {
		$request = new HttpRequest($this->url);
		$request->send();

		if($request->getStatus() == 200) {
			return str_get_html($request->getContent());
		}

		return false;
	}
} 