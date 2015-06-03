<?php require __DIR__.'/../fetching/Fetcher.php';

$fetcher=new fetching\Fetcher();
$res=$fetcher->fetch('http://www.baidu.com');

var_dump($res->status);
var_dump($res->encoding);
var_dump($res->url);
var_dump(strlen($res->content));
var_dump(strlen($res->text));
//$res->dumpSelf('1.tmp');
