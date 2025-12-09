<?php

namespace Controllers;

use Controllers\PublicController;
use Views\Renderer;

class ControladorReto extends PublicController
{
    public function run(): void
    {
        $arrReto = [
            "nombre"  => "Juan",
            "numero"  => "95034231",
            "correo"  => "juan@gmail.com",
            "colores" => [
                ["label" => "Rojo"],
                ["label" => "Azul"],
                ["label" => "Verde"],
                ["label" => "Amarillo"],
                ["label" => "Morado"]
            ]
        ];

        Renderer::render("reto", $arrReto);
    }
}
