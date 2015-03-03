<?php include 'fetcher.php';
$fetcher=new Fetcher();
$g=$fetcher->load('http://www.baidu.com');
echo $fetcher->status;
$fetcher->save('1.tmp',$g);
