<?php
/*
 * Author: Gerald <gera2ld@163.com>
 */
namespace fetching;

class Response {
	protected $encoding='utf-8';	// encoding used in the module
	private $headers,$status,$binary,$first_line;
	function __construct($ch,$bin){
		$this->status=curl_getinfo($ch,CURLINFO_HTTP_CODE);
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
	public function getStatus() {
		return $this->status;
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
	public function raw() {
		return $this->binary;
	}
	public function text($charset=null) {
		$g=$this->raw();
		if($charset)
			$g=iconv($charset,$this->encoding.'//ignore',$g);
		return $g;
	}
	public function json($charset=null) {
		$g=$this->text($charset);
		return json_decode($g,true);
	}
}
