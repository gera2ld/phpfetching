<?php
/*
 * Author: Gerald <gera2ld@163.com>
 */
namespace fetching;

class Fetcher {
	private $cookiefile=null;
	function __construct($cookiefile=null) {
		if($cookiefile)
			$this->cookiefile=$cookiefile;
		else if($cookiefile==='')
			$this->cookiefile=tempnam('.','COOKIE');
	}

	public function fetch($url,$data=null,$kw=null) {
		// $data can be array or string
		// headers can be customized using $kw['headers']
		$ch=curl_init();
		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_HEADER,1);
		curl_setopt($ch,CURLOPT_NOBODY,0);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		$a=isset($kw['followlocation'])?$kw['followlocation']:1;
		curl_setopt($ch,CURLOPT_FOLLOWLOCATION,$a);
		if($this->cookiefile) {
			curl_setopt($ch,CURLOPT_COOKIEJAR,$this->cookiefile);
			curl_setopt($ch,CURLOPT_COOKIEFILE,$this->cookiefile);
		}
		// do not verify HTTPS
		curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
		curl_setopt($ch,CURLOPT_POST,$data?1:0);
		if($data)
			curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
		if(isset($kw['useragent']))
			curl_setopt($ch,CURLOPT_USERAGENT,$kw['useragent']);
		else
			curl_setopt($ch,CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 6.3; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/40.0.2214.115 Safari/537.36 OPR/27.0.1689.76');
		if(isset($kw['timeout']))
			curl_setopt($ch,CURLOPT_TIMEOUT,$kw['timeout']);
		elseif(isset($kw['timeout_ms']))
			curl_setopt($ch,CURLOPT_TIMEOUT_MS,$kw['timeout_ms']);
		if(isset($kw['headers']))
			curl_setopt($ch,CURLOPT_HTTPHEADER,$kw['headers']);
		$g=curl_exec($ch);
		return new Response($ch,$g);
	}
}
