<?php

namespace Dao\Roles;

use Dao\Table;

class Roles extends Table
{
    public static function obtenerRoles(): array
    {
        $sqlstr = "SELECT * FROM roles;";
        return self::obtenerRegistros($sqlstr, []);
    }

    public static function obtenerRolPorCodigo(string $rolescod): array
    {
        $sqlstr = "SELECT * FROM roles WHERE rolescod = :rolescod;";
        return self::obtenerUnRegistro($sqlstr, ["rolescod" => $rolescod]);
    }

    public static function crearRol(
        string $rolescod,
        string $rolesdsc,
        string $rolesest
    ) {
        $insSql = "INSERT INTO roles (rolescod, rolesdsc, rolesest)
                   VALUES (:rolescod, :rolesdsc, :rolesest);";

        $params = [
            "rolescod" => $rolescod,
            "rolesdsc" => $rolesdsc,
            "rolesest" => $rolesest
        ];

        return self::executeNonQuery($insSql, $params);
    }

    public static function actualizarRol(
        string $rolescod,
        string $rolesdsc,
        string $rolesest
    ) {
        $updSql = "UPDATE roles 
                   SET rolesdsc = :rolesdsc, rolesest = :rolesest
                   WHERE rolescod = :rolescod;";

        $params = [
            "rolescod" => $rolescod,
            "rolesdsc" => $rolesdsc,
            "rolesest" => $rolesest
        ];

        return self::executeNonQuery($updSql, $params);
    }

    public static function eliminarRol(string $rolescod)
    {
        $delSql = "DELETE FROM roles WHERE rolescod = :rolescod;";
        return self::executeNonQuery($delSql, ["rolescod" => $rolescod]);
    }
}
