<?php require '../fetching/autoload.php';

use fetching\Fetcher;

$fetcher=new Fetcher();
$res=$fetcher->fetch('http://www.baidu.com');

$res->dump('1.tmp',$res->raw());
