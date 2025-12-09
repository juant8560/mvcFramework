<?php

namespace Controllers\Roles;

use Controllers\PublicController;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;
use Exception;
use Dao\Roles\Roles as DAORoles;

const RolesList = 'index.php?page=Roles-Roles';
const RoleView = "roles/formRol";

class Rol extends PublicController
{
    private $modes = [
        "INS" => "Nuevo Rol",
        "UPD" => "Editando Rol %s",
        "DSP" => "Detalle Rol %s",
        "DEL" => "Eliminando Rol %s"
    ];
    private string $mode = '';

    private string $rolescod = '';
    private string $rolesdsc = '';
    private string $rolesest = '';

    private string $validationToken = '';

    private array $errores = [];

    public function run(): void
    {
        try {
            $this->page_init();

            if ($this->isPostBack()) {
                $this->errores = $this->validarPostData();

                if (count($this->errores) === 0) {
                    try {
                        switch ($this->mode) {
                            case "INS":
                                $affected = DAORoles::crearRol(
                                    $this->rolescod,
                                    $this->rolesdsc,
                                    $this->rolesest
                                );
                                if ($affected > 0) {
                                    Site::redirectToWithMsg(RolesList, "Rol creado correctamente");
                                }
                                break;

                            case "UPD":
                                $affected = DAORoles::actualizarRol(
                                    $this->rolescod,
                                    $this->rolesdsc,
                                    $this->rolesest
                                );
                                if ($affected > 0) {
                                    Site::redirectToWithMsg(RolesList, "Rol actualizado");
                                }
                                break;

                            case "DEL":
                                $affected = DAORoles::eliminarRol(
                                    $this->rolescod
                                );
                                if ($affected > 0) {
                                    Site::redirectToWithMsg(RolesList, "Rol eliminado");
                                }
                                break;
                        }
                    } catch (Exception $err) {
                        $this->errores[] = $err->getMessage();
                    }
                }
            }

            Renderer::render(RoleView, $this->preparar_datos_vista());
        } catch (Exception $ex) {
            Site::redirectToWithMsg(RolesList, "Error inesperado, intente de nuevo.");
        }
    }

    private function page_init()
    {
        if (!isset($_GET["mode"]) || !isset($this->modes[$_GET["mode"]])) {
            throw new Exception("Modo inválido");
        }

        $this->mode = $_GET["mode"];

        if ($this->mode !== "INS") {
            if (!isset($_GET["id"])) {
                throw new Exception("Código de rol no proporcionado");
            }

            $tmp = DAORoles::obtenerRolPorCodigo($_GET["id"]);

            if (count($tmp) === 0) {
                throw new Exception("Rol no encontrado");
            }

            $this->rolescod = $tmp["rolescod"];
            $this->rolesdsc = $tmp["rolesdsc"];
            $this->rolesest = $tmp["rolesest"];
        }
    }

    private function validarPostData(): array
    {
        $errors = [];

        $this->validationToken = $_POST["vlt"] ?? '';
        if ($_SESSION[$this->name . "_token"] !== $this->validationToken) {
            throw new Exception("Error de Token");
        }

        $this->rolescod = $_POST["rolescod"] ?? '';
        $this->rolesdsc = $_POST["rolesdsc"] ?? '';
        $this->rolesest = $_POST["rolesest"] ?? '';

        if (Validators::IsEmpty($this->rolescod)) {
            $errors[] = "El código no puede ir vacío.";
        }

        if (Validators::IsEmpty($this->rolesdsc)) {
            $errors[] = "La descripción no puede ir vacía.";
        }

        if (!in_array($this->rolesest, ["ACT", "INA"])) {
            $errors[] = "Estado inválido.";
        }

        return $errors;
    }

    private function generarTokenDeValidacion()
    {
        $this->validationToken = md5(gettimeofday(true) . rand(1000, 9999));
        $_SESSION[$this->name . "_token"] = $this->validationToken;
    }

    private function preparar_datos_vista()
    {
        $viewData = [];

        $viewData["mode"] = $this->mode;
        $viewData["modeDsc"] = $this->modes[$this->mode];

        if ($this->mode !== "INS") {
            $viewData["modeDsc"] = sprintf($viewData["modeDsc"], $this->rolescod);
        }

        $viewData["rolescod"] = $this->rolescod;
        $viewData["rolesdsc"] = $this->rolesdsc;
        $viewData["rolesest"] = $this->rolesest;

        $this->generarTokenDeValidacion();
        $viewData["token"] = $this->validationToken;

        $viewData["errores"] = $this->errores;
        $viewData["hasErrores"] = count($this->errores) > 0;

        $viewData["readonly"] = in_array($this->mode, ["DSP", "DEL"]) ? "readonly" : "";
        $viewData["codigoReadonly"] = $this->mode !== "INS" ? "readonly" : "";

        $viewData["isDisplay"] = $this->mode === "DSP";

        $viewData["selected" . $this->rolesest] = "selected";

        return $viewData;
    }
}
