<?php

namespace Dao\Estudiantes;

use Dao\Table;

class Estudiantes extends Table
{
    public static function obtenerEstudiantes(): array
    {
        $sqlstr = "SELECT * FROM incidentes_estudiantiles;";
        return self::obtenerRegistros($sqlstr, []);
    }
    public static function obtenerEstudiantesPorCodigo(string $id): array
    {
        $sqlstr = "SELECT * from incidentes_estudiantiles where id=:id;";
        return self::obtenerUnRegistro($sqlstr, ["id" => $id]);
    }
    public static function crearIncidente(
        string $id,
        string $estudiante_nombre,
        string $fecha_incidente,
        string $tipo_incidente,
        string $descripcion,
        string $accion_tomada,
        string $estado,
    ) {
        $insSql = "INSERT INTO incidentes_estudiantiles (id, estudiante_nombre, fecha_incidente, tipo_incidente, descripcion, accion_tomada, estado)
        values (:id, :estudiante_nombre, :fecha_incidente, :tipo_incidente, :descripcion, :accion_tomada, :estado);";

        $newInsertData = [
            "id" => $id,
            "estudiante_nombre" => $estudiante_nombre,
            "fecha_incidente" => $fecha_incidente,
            "tipo_incidente" => $tipo_incidente,
            "descripcion" => $descripcion,
            "accion_tomada" => $accion_tomada,
            "estado" => $estado
        ];

        return self::executeNonQuery($insSql, $newInsertData);
    }
    public static function actualizarEstudiante(
        string $id,
        string $estudiante_nombre,
        string $fecha_incidente,
        string $tipo_incidente,
        string $descripcion,
        string $accion_tomada,
        string $estado,
    ) {
        $updSql = "UPDATE incidentes_estudiantiles set estudiante_nombre=:estudiante_nombre, fecha_incidente=:fecha_incidente, 
            tipo_incidente=:tipo_incidente, descripcion=:descripcion, accion_tomada=:accion_tomada, estado=:estado
            where id=:id;";

        $newUpdateData = [
            "id" => $id,
            "estudiante_nombre" => $estudiante_nombre,
            "fecha_incidente" => $fecha_incidente,
            "tipo_incidente" => $tipo_incidente,
            "descripcion" => $descripcion,
            "accion_tomada" => $accion_tomada,
            "estado" => $estado
        ];

        return self::executeNonQuery($updSql, $newUpdateData);
    }
    public static function eliminarEstudiante(string $id)
    {
        $delSql = "DELETE from incidentes_estudiantiles where id=:id;";
        $delParams = [
            "id" => $id
        ];
        return self::executeNonQuery($delSql, $delParams);
    }
}
