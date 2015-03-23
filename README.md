Fetcher for PHP
===

This is a simple web resource fetcher written in PHP,
with cookies support.

Requires PHP 5.3+.

Also works with lower versions of PHP if namespace lines are removed.

Usage
---
``` php
<?php
require 'fetching.php';
use fetching\Fetcher;

$fetcher=new Fetcher();	// do not use a cookie file
$fetcher=new Fetcher('');	// use a temporary file as cookie file
$fetcher=new Fetcher('cookiefile');	// use 'cookiefile' as cookie file

// GET
$res=$fetcher->fetch('http://www.google.com');

// POST
$res=$fetcher->fetch('http://www.google.com','data');

// Output
// * binary
echo $res->raw();
// * text
echo $res->text();
echo $res->text(charset='utf-8');
// * json
echo $res->json();
echo $res->json(charset='utf-8');
```
