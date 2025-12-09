<?php

namespace Dao\Carretilla;

use Dao\Table;

class Carretilla extends Table
{
    public static function addItem(int $usercod, int $productId, int $quantity, float $price): bool
    {
        return self::executeNonQuery(
            "INSERT INTO carretilla1(usercod, productId, crrctd, crrprc, crrfching)
             VALUES(:usercod, :productId, :quantity, :price, NOW())
             ON DUPLICATE KEY UPDATE crrctd=crrctd+:quantity, crrprc=crrprc+:price",
            ["usercod" => $usercod, "productId" => $productId, "quantity" => $quantity, "price" => $price]
        );
    }

    public static function getItemsByUser(int $usercod): array
    {

        return self::obtenerRegistros(
            "SELECT 
                c.productId,
                c.usercod,
                c.crrctd AS cantidad,
                p.productPrice AS precio,
                p.productName,
                p.productImgUrl
         FROM carretilla1 c
         INNER JOIN products p ON c.productId=p.productId
         WHERE c.usercod=:usercod",
            ["usercod" => $usercod]
        );
    }


    public static function clearCart(int $usercod): bool
    {
        return self::executeNonQuery("DELETE FROM carretilla1 WHERE usercod=:usercod", ["usercod" => $usercod]);
    }

    public static function moveAnonToAuth(string $anonCartCode, int $usercod): bool
    {
        // 1. Obtener los items del carrito anónimo
        $items = self::obtenerRegistros(
            "SELECT * FROM carretilla1 WHERE usercod = :anonCart",
            ["anonCart" => $anonCartCode]
        );

        if (empty($items)) {
            return true; // No hay nada que mover
        }

        // 2. Pasar items al usuario autenticado
        foreach ($items as $item) {
            self::addItem(
                $usercod,
                intval($item["productId"]),
                intval($item["crrctd"]),
                floatval($item["crrprc"])
            );
        }

        // 3. Borrar carrito anónimo
        return self::executeNonQuery(
            "DELETE FROM carretilla1 WHERE usercod=:anonCart",
            ["anonCart" => $anonCartCode]
        );
    }
}
