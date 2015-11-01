<?php require __DIR__.'/../Fetching/Fetcher.php';

$fetcher = new Gera2ld\Fetching\Fetcher();
$data = [
  'access_token' => 'blablabla',
  'status' => 'You basterd! You killed Kenny!',
  'pic' => new CURLFile('foobar.png', 'image/png', 'kenny'),
];
$res = $fetcher->fetch('http://place/to/post', $data);

var_dump($res->status);
var_dump($res->json(true));
var_dump($res->error);
