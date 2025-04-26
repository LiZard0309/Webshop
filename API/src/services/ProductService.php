<?php

namespace Programmieruebungen\Webshop\services;

use Programmieruebungen\Webshop\gateways\ProductReadDBGateway;

class ProductService
{
    public $productReadDBGateway;
    public function __construct($productReadGateway)
    {
        $this->productReadDBGateway = $productReadGateway;
        //productReadGateway wird vom Controller durchgegeben, dort wird Gateway angelegt und die Parameter für das pdo übergeben
    }

    public function getProductTypes() {
        return $this->productReadDBGateway->getProductTypes();
        //hier kommt ein ProductTypeModel rein

    }

    public function getProducts($filterType) {
        return $this->productReadDBGateway->getProductsByType($filterType);
    }


}