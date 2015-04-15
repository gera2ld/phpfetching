<?php require '../fetching/Fetcher.php';

use fetching\Fetcher;

$fetcher=new Fetcher();
$res=$fetcher->fetch('http://www.baidu.com');

$res->dumpSelf('1.tmp');
