<?php

namespace Controllers\Roles;

use Controllers\PublicController;
use Views\Renderer;
use Dao\Roles\Roles as RolesDAO;

class Roles extends PublicController
{
    public function run(): void
    {
        $viewData = [];
        $tmpRoles = RolesDAO::obtenerRoles();
        $viewData["roles"] = $tmpRoles;
        $viewData["total"] = count($tmpRoles);

        Renderer::render("roles/listaRol", $viewData);
    }
}
