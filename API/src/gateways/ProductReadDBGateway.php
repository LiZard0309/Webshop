<?php

namespace Programmieruebungen\Webshop\gateways;

use Programmieruebungen\Webshop\models\ProductModel;
use Programmieruebungen\Webshop\models\ProductTypeModel;

class ProductReadDBGateway implements ProductReadDBGatewayInterface
{
    private $pdo;
    public function __construct(
        $host,
        $dbname,
        $user,
        $password
    )
    {
        $this->pdo = new \PDO('mysql:host='.$host.';dbname='.$dbname.'; charset=utf8', $user, $password);

        //wir initialisieren die Gateway-Klasse im Controller (im Konstruktor des Controllers) und dort übergeben wir dann die Parameter
        //host, dbname, user, password als DB_HOST, DB_NAME, DB_USER, DB_PASS (kommt aus config.php)
    }

    public function getProductTypes()
    {
        $query = "SELECT id, name FROM product_types ORDER BY name";
        $stmt = $this->pdo->prepare($query);

        $stmt->execute();

        $productTypesList = $stmt->fetchAll(\PDO::FETCH_ASSOC); //das hier ist ein productTypes-Model

        //wir bekommen hier aus der Datenbank ein CategoryModel zurück
        //dieses Model müssen wir auf ein DTO "ummappen"
        //das passiert mit der Funktion mapProductTypes(), die wir im ProductTypeDTO definiert haben

        return $this->mapProductTypes($productTypesList); //die Funktion getProductTypes returned nun ein ProductTypeModel in die Service-Klasse
    }

    public function mapProductTypes($productTypesList)
    {
        $mappedProductTypesList = array();
        foreach ($productTypesList as $productType) {
            $productTypeModel = new ProductTypeModel();

            $productTypeModel->typeId = $productType['id'];
            $productTypeModel->productTypeName = $productType['name'];
            //productType->name und ->id sind das, was aus der DB so zurückkommt
            //wir mappen das auf unser productTypeModel
            $mappedProductTypesList[] = $productTypeModel;
            //mappedProductTypesList ist ein Array aus den ProductTypes und ihrer zugehörigen ID
        }
        return $mappedProductTypesList;

    }

    public function getProductsByType($filterType)
    {
        $query = "SELECT t.name AS productTypeName, p.name AS productName 
                    FROM product_types t JOIN products p ON t.id = p.id_product_types 
                    WHERE t.id = :productTypeId";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(':productTypeId', $filterType);

        $stmt->execute();

        $productList = $stmt->fetchAll(\PDO::FETCH_ASSOC);



        return $this->mapProducts($productList);

    }

    public function mapProducts($productList){

        $mappedProductsList = array();



        foreach ($productList as $product) {
            $productModel = new ProductModel();
            $productModel->typeOfProduct = $product['productTypeName'];
            $productModel->productName = $product['productName'];
            $mappedProductsList[] = $productModel;
            //hier fügen wir das gemappte productModel dem Ende des Arrays hinzu
        }
        return $mappedProductsList;
    }
}