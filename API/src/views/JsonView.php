<?php

namespace Programmieruebungen\Webshop\views;

class JsonView implements ViewInterface
{

    public function display($output)
    {
        header('Content-type: application/json');
        echo json_encode($output);
        //hiermit sagen wir der Oberfläche, dass das, was vom Backend kommt, als JSON dargestellt werden soll
    }
}