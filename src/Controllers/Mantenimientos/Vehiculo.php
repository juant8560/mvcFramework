<?php

namespace Controllers\Mantenimientos;

use Controllers\PublicController;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;
use Exception;
use Dao\Vehiculos\Vehiculos as DAOVehiculos;

const VehiculosList = 'index.php?page=Mantenimientos-Vehiculos';
const VehiculosView = "mantenimientos/vehiculos/formVehic";

class Vehiculo extends PublicController
{
    private $modes = [
        "INS" => "Nuevo Vehiculo",
        "UPD" => "Editando %s",
        "DSP" => "Detalle de %s",
        "DEL" => "Eliminado %s"
    ];

    private string $mode = '';

    private string $id_vehiculo = '';
    private string $marca = '';
    private string $modelo = '';
    private int $ano_fabricacion = 0;
    private string $tipo_combustible = '';
    private int $kilometraje = 0;

    private string $Token = '';

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
                                $filas = DAOVehiculos::crearRegistroVehiculo(
                                    $this->id_vehiculo,
                                    $this->marca,
                                    $this->modelo,
                                    $this->ano_fabricacion,
                                    $this->tipo_combustible,
                                    $this->kilometraje
                                );
                                if ($filas > 0) {
                                    Site::redirectToWithMsg(VehiculosList, "Nuevo Incidente creado satisfactoriamente");
                                }
                                break;

                            case "UPD":
                                $filas = DAOVehiculos::actualizarVehiculo(
                                    $this->id_vehiculo,
                                    $this->marca,
                                    $this->modelo,
                                    $this->ano_fabricacion,
                                    $this->tipo_combustible,
                                    $this->kilometraje
                                );
                                if ($filas > 0) {
                                    Site::redirectToWithMsg(VehiculosList, "Vehiculo actualizado exitosamente.");
                                }
                                break;

                            case "DEL":
                                $filas = DAOVehiculos::eliminarVehiculo(
                                    $this->id_vehiculo,
                                );
                                if ($filas > 0) {
                                    Site::redirectToWithMsg(VehiculosList, "Vehiculo eliminado satisfactoriamente");
                                }
                                break;
                        }
                    } catch (Exception $err) {
                        error_log($err, 0);
                        $this->errores[] = $err;
                    }
                }
            }
            Renderer::render(VehiculosView, $this->preparar_datos_vista());
        } catch (Exception $ex) {
            error_log($ex->getMessage());
            Site::redirectToWithMsg(VehiculosList, "Sucedió un problema. Reintente nuevamente.");
        }
    }

    private function page_init()
    {
        if (isset($_GET["mode"]) && isset($this->modes[$_GET["mode"]])) {
            $this->mode = $_GET["mode"];
            if ($this->mode !== "INS") {
                $tmpId = '';
                if (isset($_GET["id_vehiculo"])) {
                    $tmpId = $_GET["id_vehiculo"];
                } else {
                    throw new Exception("Valor de Mode no es válido");
                }
                $tmpVehiculo = DAOVehiculos::obtenerVehiculosPorCodigo($tmpId);
                if (count($tmpVehiculo) === 0) {
                    throw new Exception("No se encontró Registro");
                }
                $this->id_vehiculo = $tmpVehiculo["id_vehiculo"];
                $this->marca = $tmpVehiculo["marca"];
                $this->modelo = $tmpVehiculo["modelo"];
                $this->ano_fabricacion = $tmpVehiculo["ano_fabricacion"];
                $this->tipo_combustible = $tmpVehiculo["tipo_combustible"];
                $this->kilometraje = $tmpVehiculo["kilometraje"];
            }
        } else {
            throw new Exception("Valor de Modo invalido");
        }
    }

    private function validarPostData(): array
    {
        $errors = [];

        $this->Token = $_POST["vlt"] ?? '';
        if (isset($_SESSION[$this->name . "_token"]) && $_SESSION[$this->name . "_token"] !== $this->Token) {
            throw new Exception("Error de validación de Token");
        }

        $this->id_vehiculo = $_POST["id_vehiculo"] ?? '';
        $this->marca = $_POST["marca"] ?? '';
        $this->modelo = $_POST["modelo"] ?? '';
        $this->ano_fabricacion = intval($_POST["ano_fabricacion"] ?? '');
        $this->tipo_combustible = $_POST["tipo_combustible"] ?? '';
        $this->kilometraje = intval($_POST["kilometraje"] ?? '');

        if (Validators::IsEmpty($this->marca)) {
            $errors[] = "La marca no puede ir vacío.";
        }

        if (Validators::IsEmpty($this->modelo)) {
            $errors[] = "La modelo no puede ir vacío.";
        }
        return $errors;
    }

    private function TokenValidacion()
    {
        $this->Token = md5(gettimeofday(true) . $this->name . rand(1000, 9999));
        $_SESSION[$this->name . "_token"] = $this->Token;
    }

    private function preparar_datos_vista()
    {
        $DataVehiculos = [];
        $DataVehiculos["mode"] = $this->mode;

        $DataVehiculos["modeDsc"] = $this->modes[$this->mode];

        if ($this->mode !== "INS") {
            $DataVehiculos["modeDsc"] = sprintf($DataVehiculos["modeDsc"], $this->marca);
        }
        $DataVehiculos["id_vehiculo"] = $this->id_vehiculo;
        $DataVehiculos["marca"] = $this->marca;
        $DataVehiculos["modelo"] = $this->modelo;
        $DataVehiculos["ano_fabricacion"] = $this->ano_fabricacion;
        $DataVehiculos["tipo_combustible"] = $this->tipo_combustible;
        $DataVehiculos["kilometraje"] = $this->kilometraje;

        $this->TokenValidacion();
        $DataVehiculos["token"] = $this->Token;

        $DataVehiculos["errores"] = $this->errores;
        $DataVehiculos["hasErrores"] = count($this->errores) > 0;

        $DataVehiculos["codigoReadonly"] = $this->mode !== "INS" ? "readonly" : "";

        $vieDataVehiculoswData["readonly"] = in_array($this->mode, ["DSP", "DEL"]) ? "readonly" : "";

        $DataVehiculos["isDisplay"] = $this->mode === "DSP";

        return $DataVehiculos;
    }
}
