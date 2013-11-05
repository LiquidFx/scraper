<?php

namespace Scraper;

class HttpRequest {

	const USERAGENT_CHROME	= 'Mozilla/5.0 (Windows NT 6.2; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/32.0.1667.0 Safari/537.36';
	const USERAGENT_FIREFOX	= 'Mozilla/5.0 (Windows NT 6.1; Win64; x64; rv:25.0) Gecko/20100101 Firefox/25.0';
	const USERAGENT_IE		= 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; WOW64; Trident/6.0)';

	protected $content;
	protected $curl;
	protected $headers = array();
	protected $method = 'get';
	protected $params = array();
	protected $status = 0;
	protected $url;
	protected $user_agent = 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0';

	public function __construct($url = null) {
		$this->url = $url;
	}

	protected function post() {
		curl_setopt($this->curl, CURLOPT_POST, true);
		curl_setopt($this->curl, CURLOPT_POSTFIELDS, $this->params);
	}

	public function addParam($name, $value) {
		$this->params[$name] = $value;
		return $this;
	}

	public function getContent() {
		return $this->content;
	}

	public function getStatus() {
		return $this->status;
	}

	public function send() {
		$this->curl = curl_init($this->url);
		curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($this->curl, CURLOPT_USERAGENT, $this->user_agent);
		curl_setopt($this->curl, CURLOPT_HTTPHEADER, $this->headers);

		if(method_exists($this, $this->method)) {
			$this->{$this->method}();
		}

		$this->content = curl_exec($this->curl);
		$this->status = curl_getinfo($this->curl, CURLINFO_HTTP_CODE);

		return $this;
	}

	public function setContentType($type) {
		$headers[] = 'Content-Type: ' . $type;
		return $this;
	}

	public function setMethod($method) {
		$this->method = $method;
		return $this;
	}

	public function setParams($params) {
		$this->params = $params;
		return $this;
	}

	public function setUrl($url) {
		$this->url = $url;
		return $this;
	}

	public function setUserAgent($user_aagent) {
		$this->user_agent = $user_aagent;
		return $this;
	}
}