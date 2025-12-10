<?php

namespace Dao\Carretilla;

use Dao\Table;

class Carretilla extends Table
{
    // Añade item. crrprc guarda el precio unitario (no acumulado).
    public static function addItem(int $usercod, int $productId, int $quantity, float $unitPrice): bool
    {
        return self::executeNonQuery(
            "INSERT INTO carretilla1(usercod, productId, crrctd, crrprc, crrfching)
             VALUES(:usercod, :productId, :quantity, :unitPrice, NOW())
             ON DUPLICATE KEY UPDATE crrctd = crrctd + :quantity, crrprc = :unitPrice, crrfching = NOW()",
            ["usercod" => $usercod, "productId" => $productId, "quantity" => $quantity, "unitPrice" => $unitPrice]
        );
    }

    // Obtener items (precio viene del producto o desde carretilla; aquí usamos productPrice como unidad)
    public static function getItemsByUser(int $usercod): array
    {
        return self::obtenerRegistros(
            "SELECT 
                c.productId,
                c.usercod,
                c.crrctd AS cantidad,
                -- preferimos precio del producto como unitario, fallback a c.crrprc si fuese necesario
                COALESCE(p.productPrice, c.crrprc) AS precio,
                p.productName,
                p.productImgUrl
             FROM carretilla1 c
             LEFT JOIN products p ON c.productId = p.productId
             WHERE c.usercod = :usercod",
            ["usercod" => $usercod]
        );
    }

    // Eliminar un item del carrito
    public static function removeItem(int $usercod, int $productId): bool
    {
        return self::executeNonQuery(
            "DELETE FROM carretilla1 WHERE usercod=:usercod AND productId=:productId",
            ["usercod" => $usercod, "productId" => $productId]
        );
    }

    public static function clearCart(int $usercod): bool
    {
        return self::executeNonQuery("DELETE FROM carretilla1 WHERE usercod=:usercod", ["usercod" => $usercod]);
    }

    public static function moveAnonToAuth(string $anonCartCode, int $usercod): bool
    {
        // Obtener items del carrito anónimo
        $items = self::obtenerRegistros(
            "SELECT * FROM carretilla1 WHERE usercod = :anonCart",
            ["anonCart" => $anonCartCode]
        );

        if (empty($items)) {
            return true;
        }

        foreach ($items as $item) {
            self::addItem(
                $usercod,
                intval($item["productId"]),
                intval($item["crrctd"]),
                floatval($item["crrprc"])
            );
        }

        return self::executeNonQuery(
            "DELETE FROM carretilla1 WHERE usercod=:anonCart",
            ["anonCart" => $anonCartCode]
        );
    }
}
