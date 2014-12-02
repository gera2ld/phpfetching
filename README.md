Fetcher for PHP
===

This is a simple web resource fetcher written in PHP,
with cookies support.

Usage
---
``` php
<?php
include 'fetcher.php';
$fetcher=new Fetcher();	// do not use a cookie file
$fetcher=new Fetcher('');	// use a temporary file as cookie file
$fetcher=new Fetcher('cookiefile');	// use 'cookiefile' as cookie file

// GET
$g=$fetcher->load('http://www.google.com');

// POST
$g=$fetcher->load('http://www.google.com','data');

// specify charset
$kw=array('charset'=>'utf-8');
$g=$fetcher->load('http://www.google.com',null,$kw);

// output
echo $g;
?>
```
