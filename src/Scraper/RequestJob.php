<?php

namespace Scraper;

use Multitask\Job;
use Symfony\Component\DomCrawler\Crawler;

class RequestJob extends Job {

	protected $url;

	public function __construct($url) {
		$this->url = $url;
	}

	public function run() {
		$request = new HttpRequest($this->url);
		$request->send();

		if($request->getStatus() == 200) {
			$crawler = new Crawler(null, $this->url);
			$crawler->addContent($request->getContent());

			return $crawler;
		}

		return false;
	}
} 