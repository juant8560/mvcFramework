<?php

namespace Controllers\Carretilla;

use Controllers\PublicController; // Dejamos público
use Dao\Carretilla\Carretilla as CarretillaDAO;
use Views\Renderer;
use Utilities\Site;

class Carretilla extends PublicController
{
    public function run(): void
    {
        // Para pruebas: usuario con código fijo
        $usercod = 9; // usuario cliente

        // Agregar producto si viene por POST
        if (isset($_POST["productId"], $_POST["quantity"])) {
            CarretillaDAO::addItem(
                $usercod,
                (int)$_POST["productId"],
                (int)$_POST["quantity"],
                0 // dejamos 0, solo se usa para precio calculado desde products
            );
            Site::redirectTo("index.php?page=Carretilla-Carretilla");
        }

        // Obtener productos del carrito
        $items = CarretillaDAO::getItemsByUser($usercod);
        var_dump($items); // <--- para depuración


        // Calcular subtotal y total
        $total = 0;
        foreach ($items as &$item) {
            $item['subtotal'] = $item['cantidad'] * $item['precio'];
            $total += $item['subtotal'];
        }

        $viewData["carretilla"] = $items;
        $viewData["total"] = $total;

        Renderer::render("carretilla/lista", $viewData);
    }
}
