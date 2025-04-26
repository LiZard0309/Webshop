<?php

namespace Programmieruebungen\Webshop\gateways;

interface ProductReadDBGatewayInterface
{

    public function getProductTypes();

    public function getProductsByType($filterType);

}