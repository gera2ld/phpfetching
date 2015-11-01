Fetcher for PHP
===

This is a simple web resource fetcher written in PHP,
with cookies support.

Requires PHP 5.3+. File uploading requires PHP 5.5+.

Also works with lower versions of PHP if namespace lines are removed.

Usage
---
``` php
<?php
require 'Fetching/Fetcher.php';
use Gera2ld\Fetching\Fetcher;

$fetcher=new Fetcher();	// do not use a cookie file
$fetcher=new Fetcher('');	// use a temporary file as cookie file
$fetcher=new Fetcher('cookiefile');	// use 'cookiefile' as cookie file

// GET
$res=$fetcher->fetch('http://www.google.com');

// POST
$res=$fetcher->fetch('http://www.google.com','data');

// **Output**
// * status code
echo $res->status;

// * final url
echo $res->url;

// * binary
echo $res->content;

// * text
// default encoding is 'utf-8'
echo $res->text;

// * text: change encoding
$res->encoding='gbk';
echo $res->text;

// * json
echo $res->json();	// returns an object
echo $res->json(true);	// returns an array
```
