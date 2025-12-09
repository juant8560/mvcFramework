<?php

namespace Utilities;

use Dao\Security\Security as DaoSecurity;

class Security
{
    private function __construct() {}
    private function __clone() {}

    /**
     * Cerrar sesión correctamente
     */
    public static function logout()
    {
        unset($_SESSION["login"]);
        unset($_SESSION["usertipo"]);
    }

    /**
     * Login con tipo de usuario
     */
    public static function login($userId, $userName, $userEmail, $usertipo = "PBL")
    {
        $_SESSION["login"] = [
            "isLogged" => true,
            "userId" => $userId,
            "userName" => $userName,
            "userEmail" => $userEmail
        ];
        $_SESSION["usertipo"] = $usertipo;
    }

    /**
     * ¿Hay usuario logueado?
     */
    public static function isLogged(): bool
    {
        return isset($_SESSION["login"]) && $_SESSION["login"]["isLogged"] === true;
    }

    /**
     * Obtener usuario actual
     */
    public static function getUser()
    {
        return $_SESSION["login"] ?? false;
    }

    /**
     * 🔥 Obtener tipo de usuario para roles
     */
    public static function getUsertipo()
    {
        return $_SESSION["usertipo"] ?? "PBL";
    }

    /**
     * Obtener ID del usuario
     */
    public static function getUserId()
    {
        return $_SESSION["login"]["userId"] ?? 0;
    }

    /**
     * Validar permisos por función
     */
    public static function isAuthorized($userId, $function, $type = 'FNC'): bool
    {
        if (\Utilities\Context::getContextByKey("DEVELOPMENT") == "1") {
            $functionInDb = DaoSecurity::getFeature($function);
            if (!$functionInDb) {
                DaoSecurity::addNewFeature($function, $function, "ACT", $type);
            }
        }
        return DaoSecurity::getFeatureByUsuario($userId, $function);
    }

    /**
     * Validar rol
     */
    public static function isInRol($userId, $rol): bool
    {
        if (\Utilities\Context::getContextByKey("DEVELOPMENT") == "1") {
            $rolInDb = DaoSecurity::getRol($rol);
            if (!$rolInDb) {
                DaoSecurity::addNewRol($rol, $rol, "ACT");
            }
        }
        return DaoSecurity::isUsuarioInRol($userId, $rol);
    }
}
