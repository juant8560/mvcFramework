<?php

namespace Controllers\Usuarios;

use Controllers\PublicController;
use Views\Renderer;
use Utilities\Validators;
use Utilities\Site;
use Dao\Usuarios\Usuarios as UsuariosDAO;
use Exception;

const UsuariosList = "index.php?page=Usuarios-Usuarios";
const UsuarioView = "usuarios/formUsr";

class Usuario extends PublicController
{
    private $modes = [
        "INS" => "Nuevo Usuario",
        "UPD" => "Actualizando usuario de %s",
        "DEL" => "Eliminando usuario de %s",
        "DSP" => "Mostrando detalles de usuario %s"
    ];

    private int $usercod = 0;
    private string $useremail = "";
    private string $username = "";
    private string $userpswd = "";
    private string $userfching = "";
    private string $userpswdest = "";
    private string $userpswdexp = "";
    private string $userest = "";
    private string $useractcod = "";
    private string $userpswdchg = "";
    private string $usertipo = "";

    private string $validationToken = "";
    private string $mode = "";
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
                                $affectedRows = UsuariosDAO::crearUsuario(
                                    $this->useremail,
                                    $this->username,
                                    $this->userpswd,
                                    $this->userfching,
                                    $this->userpswdest,
                                    $this->userpswdexp,
                                    $this->userest,
                                    $this->useractcod,
                                    $this->userpswdchg,
                                    $this->usertipo
                                );
                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(UsuariosList, "Nuevo Usuario registrado satisfactoriamente");
                                }
                                break;

                            case "UPD":
                                $affectedRows = UsuariosDAO::actualizarUsuario(
                                    $this->usercod,
                                    $this->useremail,
                                    $this->username,
                                    $this->userpswd,
                                    $this->userfching,
                                    $this->userpswdest,
                                    $this->userpswdexp,
                                    $this->userest,
                                    $this->useractcod,
                                    $this->userpswdchg,
                                    $this->usertipo
                                );
                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(UsuariosList, "Usuario actualizado satisfactoriamente");
                                }
                                break;

                            case "DEL":
                                $affectedRows = UsuariosDAO::eliminarUsuario($this->usercod);
                                if ($affectedRows > 0) {
                                    Site::redirectToWithMsg(UsuariosList, "Usuario eliminado satisfactoriamente");
                                }
                                break;
                        }
                    } catch (Exception $err) {
                        $this->errores[] = $err->getMessage();
                    }
                }
            }

            Renderer::render(UsuarioView, $this->preparar_datos_vista());
        } catch (Exception $ex) {
            Site::redirectToWithMsg(UsuariosList, "Sucedio un problema al cargar. Reintente nuevamente.");
        }
    }

    private function page_init()
    {
        if (!isset($_GET["mode"]) || !isset($this->modes[$_GET["mode"]])) {
            throw new Exception("Modo inválido");
        }

        $this->mode = $_GET["mode"];

        if ($this->mode !== "INS") {
            if (!isset($_GET["usercod"])) {
                throw new Exception("Código de usuario no proporcionado");
            }

            $tmpUsuario = UsuariosDAO::obtenerUsuarioPorCodigo(intval($_GET["usercod"]));
            if (count($tmpUsuario) === 0) {
                throw new Exception("Usuario no encontrado");
            }

            $this->usercod = intval($tmpUsuario["usercod"]);
            $this->useremail = $tmpUsuario["useremail"];
            $this->username = $tmpUsuario["username"];
            $this->userpswd = $tmpUsuario["userpswd"];
            $this->userfching = $tmpUsuario["userfching"];
            $this->userpswdest = $tmpUsuario["userpswdest"];
            $this->userpswdexp = $tmpUsuario["userpswdexp"];
            $this->userest = $tmpUsuario["userest"];
            $this->useractcod = $tmpUsuario["useractcod"];
            $this->userpswdchg = $tmpUsuario["userpswdchg"];
            $this->usertipo = $tmpUsuario["usertipo"];
        }
    }

    private function generarTokenDeValidacion()
    {
        $this->validationToken = md5(gettimeofday(true) . $this->name . rand(1000, 9999));
        $_SESSION[$this->name . "_token"] = $this->validationToken;
    }

    private function validarPostData(): array
    {
        $errors = [];

        $this->validationToken = $_POST["vlt"] ?? '';
        if (!isset($_SESSION[$this->name . "_token"]) || $_SESSION[$this->name . "_token"] !== $this->validationToken) {
            throw new Exception('Error de Token');
        }

        $this->usercod = intval($_POST["usercod"] ?? 0);
        $this->useremail = $_POST["useremail"] ?? '';
        $this->username = $_POST["username"] ?? '';
        $this->userpswd = $_POST["userpswd"] ?? '';
        $this->userfching = $_POST["userfching"] ?? '';
        $this->userpswdest = $_POST["userpswdest"] ?? '';
        $this->userpswdexp = $_POST["userpswdexp"] ?? '';
        $this->userest = $_POST["userest"] ?? '';
        $this->useractcod = $_POST["useractcod"] ?? '';
        $this->userpswdchg = $_POST["userpswdchg"] ?? '';
        $this->usertipo = $_POST["usertipo"] ?? '';

        if ($this->mode !== "DEL") {
            if (Validators::IsEmpty($this->useremail)) $errors[] = "El email no puede ir vacío";
            if (Validators::IsEmpty($this->username)) $errors[] = "Nombre de usuario no puede ir vacío";
            if (Validators::IsEmpty($this->userpswd)) $errors[] = "Password no puede ir vacío";
            if (Validators::IsEmpty($this->userfching)) $errors[] = "Fecha de ingreso no puede ir vacía";
            if (!in_array($this->userpswdest, ["ACT", "INA"])) $errors[] = "Estado de password inválido";
            if (!in_array($this->userest, ["ACT", "INA"])) $errors[] = "Estado de usuario inválido";
            if (Validators::IsEmpty($this->usertipo)) $errors[] = "Tipo de usuario no puede ir vacío";
        }

        return $errors;
    }

    private function preparar_datos_vista()
    {
        $viewData = [];

        $viewData["mode"] = $this->mode;
        $viewData["modeDsc"] = $this->modes[$this->mode];
        if ($this->mode !== "INS") {
            $viewData["modeDsc"] = sprintf($viewData["modeDsc"], $this->username);
        }

        $viewData["usercod"] = $this->usercod;
        $viewData["useremail"] = $this->useremail;
        $viewData["username"] = $this->username;
        $viewData["userpswd"] = $this->userpswd;
        $viewData["userfching"] = substr($this->userfching, 0, 10);
        $viewData["userpswdest"] = $this->userpswdest;
        $viewData["userpswdexp"] = substr($this->userpswdexp, 0, 10);
        $viewData["userest"] = $this->userest;
        $viewData["useractcod"] = $this->useractcod;
        $viewData["userpswdchg"] = $this->userpswdchg;
        $viewData["usertipo"] = $this->usertipo;

        $viewData["errores"] = $this->errores;
        $viewData["hasErrores"] = count($this->errores) > 0;
        $viewData["codigoReadonly"] = $this->mode !== "INS" ? "readonly" : "";
        $viewData["readonly"] = in_array($this->mode, ["DSP", "DEL"]) ? "readonly" : "";
        $viewData["isDisplay"] = $this->mode === "DSP";

        $viewData["selected_pswdest_" . $this->userpswdest] = "selected";
        $viewData["selected_est_" . $this->userest] = "selected";
        $viewData["selected_tipo_" . $this->usertipo] = "selected";

        $this->generarTokenDeValidacion();
        $viewData["token"] = $this->validationToken;

        return $viewData;
    }
}
