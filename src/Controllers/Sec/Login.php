<?php

namespace Controllers\Sec;

use Dao\Carretilla\Carretilla;
use Utilities\Cart\CartFns;

class Login extends \Controllers\PublicController
{
    private $txtEmail = "";
    private $txtPswd = "";
    private $errorEmail = "";
    private $errorPswd = "";
    private $generalError = "";
    private $hasError = false;

    public function run(): void
    {
        if ($this->isPostBack()) {

            // Capturar valores
            $this->txtEmail = $_POST["txtEmail"] ?? "";
            $this->txtPswd = $_POST["txtPswd"] ?? "";

            // Validar Email
            if (!\Utilities\Validators::IsValidEmail($this->txtEmail)) {
                $this->errorEmail = "¡Correo no tiene el formato adecuado!";
                $this->hasError = true;
            }

            // Validar Password
            if (\Utilities\Validators::IsEmpty($this->txtPswd)) {
                $this->errorPswd = "¡Debe ingresar una contraseña!";
                $this->hasError = true;
            }

            // Si NO hay errores
            if (!$this->hasError) {

                // Buscar usuario por email
                if ($dbUser = \Dao\Security\Security::getUsuarioByEmail($this->txtEmail)) {

                    // Usuario inactivo
                    if ($dbUser["userest"] != \Dao\Security\Estados::ACTIVO) {
                        $this->generalError = "¡Credenciales son incorrectas!";
                        $this->hasError = true;
                        error_log("Usuario con estado inválido: {$dbUser['useremail']}");
                    }

                    // Validar contraseña
                    if (!\Dao\Security\Security::verifyPassword($this->txtPswd, $dbUser["userpswd"])) {
                        $this->generalError = "¡Credenciales son incorrectas!";
                        $this->hasError = true;
                        error_log("Contraseña incorrecta para: {$dbUser['useremail']}");
                    }

                    // Si todo es correcto
                    if (!$this->hasError) {

                        // 🔥 LOGIN CON ROL INCLUIDO 🔥
                        \Utilities\Security::login(
                            $dbUser["usercod"],
                            $dbUser["username"],
                            $dbUser["useremail"],
                            $dbUser["usertipo"] // NECESARIO PARA ROLES
                        );

                        // Pasar carrito anon a usuario autenticado
                        $anoncod = CartFns::getAnnonCartCode();
                        Carretilla::moveAnonToAuth($anoncod, $dbUser["usercod"]);

                        // ▶ Redirección por tipo de usuario
                        switch ($dbUser["usertipo"]) {
                            case "ADM":
                            case "AUD":
                                \Utilities\Site::redirectTo("index.php?page=Transactions_Transactions");
                                break;

                            case "PBL":
                            default:
                                \Utilities\Site::redirectTo("index.php?page=Products_Catalogo");
                                break;
                        }
                    }
                } else {
                    // Usuario no encontrado
                    $this->generalError = "¡Credenciales son incorrectas!";
                    error_log("Correo no encontrado: {$this->txtEmail}");
                }
            }
        }

        // Renderizar vista
        $dataView = get_object_vars($this);
        \Views\Renderer::render("security/login", $dataView);
    }
}
