<?php

namespace Controllers\Roles;

use Controllers\PublicController;
use Views\Renderer;
use Utilities\Site;
use Dao\RolesUsuarios\RolesUsuarios as RolesUsuariosDAO;
use Dao\Usuarios\Usuarios as UsuariosDAO;
use Dao\Roles\Roles as RolesDAO;
use Exception;

const VistaUsuariosRoles = "rolesusuarios/usuariosRoles";
const VistaRolesFunciones = "rolesusuarios/rolesFunciones";

class RolesUsuariosController extends PublicController
{
    public function run(): void
    {
        try {
            $action = $_GET["action"] ?? "usuariosRoles";

            switch ($action) {
                case "usuariosRoles":
                    $this->usuariosRoles();
                    break;

                case "rolesFunciones":
                    $this->rolesFunciones();
                    break;

                default:
                    throw new Exception("Acción inválida");
            }
        } catch (Exception $ex) {
            Site::redirectToWithMsg("index.php", "Ocurrió un error: " . $ex->getMessage());
        }
    }


    private function usuariosRoles()
    {
        $usercod = $_GET["usercod"] ?? 0;

        $usuarios = UsuariosDAO::obtenerUsuarios();
        $rolesAsignados = $usercod ? RolesUsuariosDAO::getRolesByUsuario($usercod) : [];
        $rolesNoAsignados = $usercod ? RolesUsuariosDAO::getRolesNoAsignadosAUsuario($usercod) : [];

        Renderer::render("rolesusuarios/usuarios_roles", [
            "usuarios" => $usuarios,
            "rolesAsignados" => $rolesAsignados,
            "rolesNoAsignados" => $rolesNoAsignados,
            "selectedUser" => $usercod ?? null
        ]);
    }



    private function rolesFunciones()
    {
        $rolescod = $_GET["rolescod"] ?? "";

        $roles = RolesDAO::obtenerRoles();
        $funcionesAsignadas = $rolescod ? RolesUsuariosDAO::getFuncionesByRol($rolescod) : [];
        $funcionesNoAsignadas = $rolescod ? RolesUsuariosDAO::getFuncionesNoAsignadasARol($rolescod) : [];

        Renderer::render(VistaRolesFunciones, [
            "roles" => $roles,
            "funcionesAsignadas" => $funcionesAsignadas,
            "funcionesNoAsignadas" => $funcionesNoAsignadas,
            "selectedRol" => $rolescod
        ]);
    }
}
