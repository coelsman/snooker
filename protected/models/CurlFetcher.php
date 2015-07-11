<?php
class CurlFetcher {
	public $url;
	public $query;
	private $_method = '';
	public function fetchData() {
		$url = $this->url.$this->query;

	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

	    $return = curl_exec($ch);
	    curl_close($ch);

	    return $return;
	}
}