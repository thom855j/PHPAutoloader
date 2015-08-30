<?php
require_once '../Autoload.php';
use thom855j\PHPAutoloader\Autoload;
$app = new Autoload(array('root/path/to/classes'));
$app->namespaces();