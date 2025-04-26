<?php

namespace Programmieruebungen\Webshop\DTOs;

class ProductsDTO
{
    public $name;

    public static function map($productModel) {
        $productDTO = new ProductsDTO();
        $productDTO->name = $productModel->productName;
        return $productDTO;
}

}