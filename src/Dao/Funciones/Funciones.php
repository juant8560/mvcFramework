<?php

namespace Dao\Funciones;

use Dao\Table;

class Funciones extends Table
{
    public static function obtenerFunciones(): array
    {
        $sqlstr = "SELECT * FROM funciones;";
        return self::obtenerRegistros($sqlstr, []);
    }

    public static function obtenerFuncionPorCodigo(string $fncod): array
    {
        $sqlstr = "SELECT * FROM funciones WHERE fncod = :fncod;";
        return self::obtenerUnRegistro($sqlstr, ["fncod" => $fncod]);
    }

    public static function crearFuncion(
        string $fncod,
        string $fndsc,
        string $fnest,
        string $fntyp
    ) {
        $insSql = "INSERT INTO funciones (fncod, fndsc, fnest, fntyp)
                   VALUES (:fncod, :fndsc, :fnest, :fntyp);";

        $params = [
            "fncod" => $fncod,
            "fndsc" => $fndsc,
            "fnest" => $fnest,
            "fntyp" => $fntyp
        ];

        return self::executeNonQuery($insSql, $params);
    }

    public static function actualizarFuncion(
        string $fncod,
        string $fndsc,
        string $fnest,
        string $fntyp
    ) {
        $updSql = "UPDATE funciones 
                   SET fndsc = :fndsc, fnest = :fnest, fntyp = :fntyp
                   WHERE fncod = :fncod;";

        $params = [
            "fncod" => $fncod,
            "fndsc" => $fndsc,
            "fnest" => $fnest,
            "fntyp" => $fntyp
        ];

        return self::executeNonQuery($updSql, $params);
    }

    public static function eliminarFuncion(string $fncod)
    {
        $delSql = "DELETE FROM funciones WHERE fncod = :fncod;";
        return self::executeNonQuery($delSql, ["fncod" => $fncod]);
    }
}
