<?php

namespace Controllers\Funciones;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Funciones\Funciones as FuncionesDAO;

class Funciones extends PublicController
{
    public function run(): void
    {
        $viewData = [];
        $tmpFunciones = FuncionesDAO::obtenerFunciones();
        $viewData["funciones"] = $tmpFunciones;
        $viewData["total"] = count($tmpFunciones);

        Renderer::render("funciones/listaFnc", $viewData);
    }
}
