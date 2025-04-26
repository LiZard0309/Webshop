<?php

namespace Programmieruebungen\Webshop\controller;

use Programmieruebungen\Webshop\DTOs\ProductListDTO;
use Programmieruebungen\Webshop\DTOs\ProductsDTO;
use Programmieruebungen\Webshop\DTOs\ProductTypeDTO;
use Programmieruebungen\Webshop\gateways\ProductReadDBGateway;
use Programmieruebungen\Webshop\services\ProductService;
use Programmieruebungen\Webshop\views\JsonView;

class ProductController
{

    private $productService;
    private $jsonView;

    private $url = API_URL;

    public function __construct()
    {
        $productReadGateway = new ProductReadDBGateway(
            DB_HOST,
            DB_NAME,
            DB_USER,
            DB_PASS
        );
        $this->productService = new ProductService($productReadGateway);
        $this->jsonView = new JsonView();

    }

    public function route(){

        $resource = filter_input(INPUT_GET, 'resource', FILTER_SANITIZE_STRING);

        $output = array();

        try {
            switch(strtolower($resource)){
                case "types":
                    $productTypesModel = $this->productService->getProductTypes();
                    $output = $this->mapProductTypes($productTypesModel);
                    break;
                case "products":
                    $filterType = filter_input(INPUT_GET, 'filter-type', FILTER_SANITIZE_NUMBER_INT);

                    if(!$filterType){
                        return $this->getErrorMessage("Invalid filter type");
                    }

                    $productsModel = $this->productService->getProducts($filterType);
                    $output = $this->mapProducts($productsModel);
                    break;
                default:
                    $this->getErrorMessage("Unknown action");
                    break;

            }
            $this->jsonView->display($output);

        } catch (\Exception $e) {
            http_response_code(404);
        }

    }

    public function mapProductTypes($productTypesModel){

        $productTypesDTO = array();

        foreach($productTypesModel as $productType){
            $productTypesDTO[] = ProductTypeDTO::map($productType, $this->url);
        }
        return $productTypesDTO;

    }

    public function mapProducts($productsModel){

        $productsDTO = array();

        foreach($productsModel as $product){
            $productsDTO[] = ProductsDTO::map($product);

        }

        $outputData = new ProductListDTO();

        $outputData->productType = $productsModel[0]->typeOfProduct;
        $outputData->products = $productsDTO;
        $outputData->url = $this->url . "?resource=types";


        return $outputData;

    }

    public function getErrorMessage($errorMessage){
        print($errorMessage);
    }

}