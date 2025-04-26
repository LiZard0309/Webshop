<?php

namespace Programmieruebungen\Webshop\DTOs;

class ProductTypeDTO
{
    public $productType;

    public $url;

    //das sind die Daten, wie wir sie weiterreichen wollen
    //hier mappen wir nun die Daten aus dem Model auf das DTO

    public static function map($productTypeModel, $url) {
        $productTypeDTO = new ProductTypeDTO();
        $productTypeDTO->productType = $productTypeModel->productTypeName;
        $productTypeDTO->url = $url .'?resource=products&filter-type='. $productTypeModel->typeId;
        return $productTypeDTO;
    }

}