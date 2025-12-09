<?php

namespace Dao\RolesUsuarios;

use Dao\Table;

class RolesUsuarios extends Table
{
    public static function getRolesByUsuario(int $usercod): array
    {
        $sql = "SELECT r.rolescod, r.rolesdsc, ru.roleuserest
                FROM roles_usuarios ru
                JOIN roles r ON ru.rolescod = r.rolescod
                WHERE ru.usercod = :usercod";
        return self::obtenerRegistros($sql, ["usercod" => $usercod]);
    }

    public static function getRolesNoAsignadosAUsuario(int $usercod): array
    {
        $sql = "SELECT rolescod, rolesdsc
                FROM roles
                WHERE rolescod NOT IN (
                    SELECT rolescod FROM roles_usuarios WHERE usercod = :usercod
                )";
        return self::obtenerRegistros($sql, ["usercod" => $usercod]);
    }

    public static function addRoleToUser(int $usercod, string $rolescod): bool
    {
        $sql = "INSERT INTO roles_usuarios (usercod, rolescod, roleuserest, roleuserfch)
                VALUES (:usercod, :rolescod, 'ACT', NOW())";
        return self::executeNonQuery($sql, ["usercod" => $usercod, "rolescod" => $rolescod]);
    }

    public static function toggleEstadoRolUsuario(int $usercod, string $rolescod, string $estado): bool
    {
        $sql = "UPDATE roles_usuarios
                SET roleuserest = :estado
                WHERE usercod = :usercod AND rolescod = :rolescod";
        return self::executeNonQuery($sql, ["usercod" => $usercod, "rolescod" => $rolescod, "estado" => $estado]);
    }

    public static function getFuncionesByRol(string $rolescod): array
    {
        $sql = "SELECT f.fncod, f.fndsc, fr.fnrolest
                FROM funciones_roles fr
                JOIN funciones f ON fr.fncod = f.fncod
                WHERE fr.rolescod = :rolescod";
        return self::obtenerRegistros($sql, ["rolescod" => $rolescod]);
    }

    public static function getFuncionesNoAsignadasARol(string $rolescod): array
    {
        $sql = "SELECT fncod, fndsc
                FROM funciones
                WHERE fncod NOT IN (
                    SELECT fncod FROM funciones_roles WHERE rolescod = :rolescod
                )";
        return self::obtenerRegistros($sql, ["rolescod" => $rolescod]);
    }

    public static function addFuncionToRol(string $rolescod, string $fncod): bool
    {
        $sql = "INSERT INTO funciones_roles (rolescod, fncod, fnrolest, fnexp)
                VALUES (:rolescod, :fncod, 'ACT', NULL)";
        return self::executeNonQuery($sql, ["rolescod" => $rolescod, "fncod" => $fncod]);
    }

    public static function toggleEstadoFuncionRol(string $rolescod, string $fncod, string $estado): bool
    {
        $sql = "UPDATE funciones_roles
                SET fnrolest = :estado
                WHERE rolescod = :rolescod AND fncod = :fncod";
        return self::executeNonQuery($sql, ["rolescod" => $rolescod, "fncod" => $fncod, "estado" => $estado]);
    }
}
