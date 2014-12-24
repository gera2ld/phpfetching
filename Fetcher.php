<?php
/*
 * Author: Gerald <gera2ld@163.com>
 */
class Fetcher {
	protected $encoding='utf-8';	// encoding used in the module
	private $cookiefile=null;
	function __construct($cookiefile=null) {
		if($cookiefile)
			$this->cookiefile=$cookiefile;
		else if($cookiefile==='')
			$this->cookiefile=tempnam('.','COOKIE');
	}
	public function save($fd, $data, $charset=null) {
		if($charset)
			$data=iconv($this->encoding,$charset.'//ignore',$data);
		$f=fopen($fd,'w') or die('Error opening file: '.$fd);
		fwrite($f,$data);
		fclose($f);
	}
	public function load_binary($url,$data=null,$kw=null) {
		// $data can be array or string
		// headers can be customized using $kw['headers']
		$ch=curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_HEADER,false);	// do not return header
		if($this->cookiefile) {
			curl_setopt($ch,CURLOPT_COOKIEJAR,$this->cookiefile);
			curl_setopt($ch,CURLOPT_COOKIEFILE,$this->cookiefile);
		}
		curl_setopt($ch,CURLOPT_POST,$data?1:0);
		if($data)
			curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
		curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.101 Safari/537.36 OPR/25.0.1614.50');
		if(isset($kw['headers']))
			curl_setopt($ch,CURLOPT_HTTPHEADER,$kw['headers']);
		$g=curl_exec($ch);
		return $g;
	}
	public function load($url,$data=null,$kw=null) {
		// if $kw['charset'] is set, $g is decoded using $kw['charset']
		$g=$this->load_binary($url,$data,$kw);
		if($kw&&isset($kw['charset']))
			$g=iconv($kw['charset'],$this->encoding.'//ignore',$g);
		return $g;
	}
	public function load_json($url,$data=null,$kw=null) {
		$g=$this->load($url,$data,$kw);
		return json_decode($g);
	}
}
?>
