<?php
/*
 * Author: Gerald <gera2ld@163.com>
 */
namespace fetching;

class Response {
	public $encoding='utf-8';
	private $headers,$status,$binary,$first_line,$final_url;

	public function __construct($ch,$bin){
		$this->status=curl_getinfo($ch,CURLINFO_HTTP_CODE);
		$this->final_url=curl_getinfo($ch,CURLINFO_EFFECTIVE_URL);
		$hs=curl_getinfo($ch,CURLINFO_HEADER_SIZE);
		$this->binary=substr($bin,$hs);
		$this->parseHeaders(substr($bin,0,$hs));
	}

	private function parseHeaders($h){
		$h=explode("\r\n\r\n",$h);
		$h=$h[count($h)-2];
		$this->headers=array();
		$this->first_line=strtok($h,"\r\n");
		while(1){
			$line=strtok("\r\n");
			if($line===false) break;
			$parts=explode(':',$line,2);
			$key=strtolower(trim($parts[0]));
			$val=trim($parts[1]);
			if(isset($this->headers[$key]))
				$this->headers[$key][]=$val;
			else
				$this->headers[$key]=array($val);
		}
	}

	public static function dump($fd, $data) {
		$f=fopen($fd,'w');
		if(!$f) throw new Exception('Error opening file: '.$fd);
		fwrite($f,$data);
		fclose($f);
	}

	public function dumpSelf($fd) {
		self::dump($fd,$this->binary);
	}

	public function getFirstLine() {
		return $this->first_line;
	}

	public function getHeaders($key){
		$key=strtolower($key);
		if(isset($this->headers[$key])) return $this->headers[$key];
		else return array();
	}

	public function getHeader($key){
		$val=$this->getHeaders($key);
		if(count($val)) return $val[0];
	}

	public function __get($key) {
		switch($key) {
		case 'status':
			return $this->status;
		case 'content':
			return $this->binary;
		case 'text':
			$g=$this->binary;
			$g=iconv($this->encoding,'utf-8//ignore',$g);
			return $g;
		case 'url':
			return $this->final_url;
		}
	}

	public function json($toArray=false) {
		return json_decode($this->text,$toArray);
	}
}
