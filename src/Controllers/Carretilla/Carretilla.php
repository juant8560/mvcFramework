<?php

namespace Controllers\Carretilla;

use Controllers\PublicController;
use Dao\Carretilla\Carretilla as CarretillaDAO;
use Views\Renderer;
use Utilities\Site;

class Carretilla extends PublicController
{
    public function run(): void
    {
        // toma de usuario - en prod tomalo de la sesión
        $usercod = $_SESSION["usercod"] ?? 9; // -> ajustar según tu sesión

        // Si vienen por POST: agregar item
        if ($this->isPostBack() && isset($_POST["productId"], $_POST["quantity"], $_POST["price"])) {
            $productId = intval($_POST["productId"]);
            $quantity  = max(1, intval($_POST["quantity"]));
            $price     = floatval($_POST["price"]); // precio unitario enviado por el form

            CarretillaDAO::addItem($usercod, $productId, $quantity, $price);
            Site::redirectTo("index.php?page=Carretilla-Carretilla");
            return;
        }

        // Si se pide eliminar (GET param remove)
        if (isset($_GET["remove"])) {
            $productId = intval($_GET["remove"]);
            if ($productId > 0) {
                CarretillaDAO::removeItem($usercod, $productId);
            }
            Site::redirectTo("index.php?page=Carretilla-Carretilla");
            return;
        }

        // Obtener items y calcular subtotales
        $items = CarretillaDAO::getItemsByUser($usercod);
        $total = 0.0;
        foreach ($items as &$item) {
            // asegúrate que las claves en $item coincidan con la vista: cantidad, precio, productName etc.
            $item['subtotal'] = floatval($item['cantidad']) * floatval($item['precio']);
            $total += $item['subtotal'];
        }
        unset($item);

        $viewData = [];
        $viewData["carretilla"] = $items;
        $viewData["total"] = $total;

        Renderer::render("carretilla/lista", $viewData);
    }
}
