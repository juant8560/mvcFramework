<?php

namespace Controllers\Products;

use Controllers\PublicController;
use Dao\Products\Products as ProductsDAO;
use Views\Renderer;

class Catalogo extends PublicController
{
    public function run(): void
    {
        $viewData = [];
        $viewData["products"] = ProductsDAO::getAllProducts(); // Método que retorna todos los productos
        Renderer::render("products/catalogo", $viewData);
    }
}
