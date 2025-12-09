<?php

namespace Controllers\Funciones;

use Controllers\PublicController;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;
use Exception;
use Dao\Funciones\Funciones as DAOFunciones;

const FuncionesList = 'index.php?page=Funciones-Funciones';
const FuncionesView = "funciones/formFn";

class Funcion extends PublicController
{
    private $modes = [
        "INS" => "Nueva Función",
        "UPD" => "Editando Función %s",
        "DSP" => "Detalle Función %s",
        "DEL" => "Eliminando Función %s"
    ];

    private string $mode = '';

    private string $fncod = '';
    private string $fndsc = '';
    private string $fnest = '';
    private string $fntyp = '';

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
                                $affected = DAOFunciones::crearFuncion(
                                    $this->fncod,
                                    $this->fndsc,
                                    $this->fnest,
                                    $this->fntyp
                                );
                                if ($affected > 0) {
                                    Site::redirectToWithMsg(FuncionesList, "Función creada correctamente");
                                }
                                break;

                            case "UPD":
                                $affected = DAOFunciones::actualizarFuncion(
                                    $this->fncod,
                                    $this->fndsc,
                                    $this->fnest,
                                    $this->fntyp
                                );
                                if ($affected > 0) {
                                    Site::redirectToWithMsg(FuncionesList, "Función actualizada correctamente");
                                }
                                break;

                            case "DEL":
                                $affected = DAOFunciones::eliminarFuncion($this->fncod);
                                if ($affected > 0) {
                                    Site::redirectToWithMsg(FuncionesList, "Función eliminada correctamente");
                                }
                                break;
                        }
                    } catch (Exception $err) {
                        $this->errores[] = $err->getMessage();
                    }
                }
            }

            Renderer::render(FuncionesView, $this->preparar_datos_vista());
        } catch (Exception $ex) {
            Site::redirectToWithMsg(FuncionesList, "Error inesperado, intente de nuevo.");
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
                throw new Exception("Código de función no proporcionado");
            }

            $tmp = DAOFunciones::obtenerFuncionPorCodigo($_GET["id"]);

            if (!$tmp) {
                throw new Exception("Función no encontrada");
            }

            $this->fncod = $tmp["fncod"];
            $this->fndsc = $tmp["fndsc"];
            $this->fnest = $tmp["fnest"];
            $this->fntyp = $tmp["fntyp"];
        }
    }

    private function validarPostData(): array
    {
        $errors = [];

        $this->validationToken = $_POST["vlt"] ?? '';
        if ($_SESSION[$this->name . "_token"] !== $this->validationToken) {
            throw new Exception("Error de Token");
        }
        $this->fncod  = $_POST["fncod"] ?? '';
        $this->fndsc  = $_POST["fndsc"] ?? '';
        $this->fnest  = $_POST["fnest"] ?? '';
        $this->fntyp  = $_POST["fntyp"] ?? '';
        if ($this->mode !== "DEL") {
            if (Validators::IsEmpty($this->fndsc)) {
                $errors[] = "Descripción no puede ir vacía.";
            }

            if (!in_array($this->fnest, ["ACT", "INA"])) {
                $errors[] = "Estado inválido.";
            }
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
            $viewData["modeDsc"] = sprintf($viewData["modeDsc"], $this->fncod);
        }

        $viewData["fncod"] = $this->fncod;
        $viewData["fndsc"] = $this->fndsc;
        $viewData["fnest"] = $this->fnest;
        $viewData["fntyp"] = $this->fntyp;

        $this->generarTokenDeValidacion();
        $viewData["token"] = $this->validationToken;

        $viewData["errores"] = $this->errores;
        $viewData["hasErrors"] = count($this->errores) > 0;

        $viewData["readonly"] = in_array($this->mode, ["DSP", "DEL"]) ? "readonly" : "";
        $viewData["codigoReadonly"] = $this->mode !== "INS" ? "readonly" : "";

        $viewData["isDisplay"] = $this->mode === "DSP";

        $viewData["selected" . $this->fnest] = "selected";

        return $viewData;
    }
}
