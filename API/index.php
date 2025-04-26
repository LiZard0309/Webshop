<?php

require_once "vendor/autoload.php";
include 'API/src/config/config.php';

use Programmieruebungen\Webshop\controller\ProductController;

$app = new ProductController();

$app->route();
