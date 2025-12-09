<?php

namespace Dao\Usuarios;

use Dao\Table;

class Usuarios extends Table
{
    public static function obtenerUsuarios(): array
    {
        $sqlstr = "SELECT * FROM usuario;";
        return self::obtenerRegistros($sqlstr, []);
    }

    public static function obtenerUsuarioPorCodigo(int $usercod): array
    {
        $sqlstr = "SELECT * FROM usuario WHERE usercod = :usercod;";
        return self::obtenerUnRegistro($sqlstr, ["usercod" => $usercod]);
    }

    public static function crearUsuario(
        string $useremail,
        string $username,
        string $userpswd,
        string $userfching,
        string $userpswdest,
        string $userpswdexp,
        string $userest,
        string $useractcod,
        string $userpswdchg,
        string $usertipo
    ) {
        $sql = "INSERT INTO usuario 
            (useremail, username, userpswd, userfching, userpswdest, 
             userpswdexp, userest, useractcod, userpswdchg, usertipo)
        VALUES
            (:useremail, :username, :userpswd, :userfching, :userpswdest,
             :userpswdexp, :userest, :useractcod, :userpswdchg, :usertipo);";

        return self::executeNonQuery($sql, [
            "useremail" => $useremail,
            "username" => $username,
            "userpswd" => $userpswd,
            "userfching" => $userfching,
            "userpswdest" => $userpswdest,
            "userpswdexp" => $userpswdexp,
            "userest" => $userest,
            "useractcod" => $useractcod,
            "userpswdchg" => $userpswdchg,
            "usertipo" => $usertipo
        ]);
    }

    public static function actualizarUsuario(
        int $usercod,
        string $useremail,
        string $username,
        string $userpswd,
        string $userpswdest,
        string $userpswdexp,
        string $userest,
        string $useractcod,
        string $userpswdchg,
        string $usertipo
    ) {
        $sql = "UPDATE usuario SET
            useremail = :useremail,
            username = :username,
            userpswd = :userpswd,
            userpswdest = :userpswdest,
            userpswdexp = :userpswdexp,
            userest = :userest,
            useractcod = :useractcod,
            userpswdchg = :userpswdchg,
            usertipo = :usertipo
        WHERE usercod = :usercod;";

        return self::executeNonQuery($sql, [
            "usercod" => $usercod,
            "useremail" => $useremail,
            "username" => $username,
            "userpswd" => $userpswd,
            "userpswdest" => $userpswdest,
            "userpswdexp" => $userpswdexp,
            "userest" => $userest,
            "useractcod" => $useractcod,
            "userpswdchg" => $userpswdchg,
            "usertipo" => $usertipo
        ]);
    }

    public static function eliminarUsuario(int $usercod)
    {
        $sql = "DELETE FROM usuario WHERE usercod = :usercod;";
        return self::executeNonQuery($sql, ["usercod" => $usercod]);
    }
}
