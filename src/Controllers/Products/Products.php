<?php

namespace Controllers\Products;

use Controllers\PrivateController;
use Views\Renderer;
use Dao\Products\Products as ProductsDAO;

class Products extends PrivateController
{
    public function run(): void
    {
        $viewData = [];
        $viewData["products"] = ProductsDAO::getAllProducts(); // <--- Aquí se obtienen los productos
        Renderer::render("products/list", $viewData); // <--- Y se pasa a la vista
    }
}
