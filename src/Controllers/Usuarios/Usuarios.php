<?php

namespace Controllers\Usuarios;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Usuarios\Usuarios as UsuariosDAO;

class Usuarios extends PublicController
{
    public function run(): void
    {
        $viewData = [];
        $tmpUsuarios = UsuariosDAO::obtenerUsuarios();
        $viewData["usuarios"] = $tmpUsuarios;
        $viewData["total"] = count($tmpUsuarios);

        Renderer::render("usuarios/listaUsr", $viewData);
    }
}
