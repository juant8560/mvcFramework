<?php

namespace Dao\Products;

use Dao\Table;

class Products extends Table
{
    // Obtiene todos los productos activos
    public static function getAllProducts(): array
    {
        $sqlstr = "SELECT * FROM products;";
        return self::obtenerRegistros($sqlstr, []);
    }

    // Obtiene un producto por su ID
    public static function getProductById(int $productId): array
    {
        $rec = self::obtenerUnRegistro(
            "SELECT * FROM products WHERE productId=:productId;",
            ["productId" => $productId]
        );

        // Ajustamos la clave para que la vista la reconozca
        if ($rec) {
            $rec["productID"] = $rec["productId"];
            unset($rec["productId"]);
        }

        return $rec;
    }

    // Inserta un nuevo producto y devuelve el ID recién creado
    public static function insertProduct(
        string $name,
        string $description,
        float $price,
        string $imgUrl,
        string $status
    ): int {
        self::executeNonQuery(
            "INSERT INTO products (productName, productDescription, productPrice, productImgUrl, productStatus)
             VALUES (:name, :description, :price, :imgUrl, :status)",
            [
                "name" => $name,
                "description" => $description,
                "price" => $price,
                "imgUrl" => $imgUrl,
                "status" => $status
            ]
        );
        return intval(self::getConn()->lastInsertId());
    }

    // Actualiza un producto existente
    public static function updateProduct(
        int $productId,
        string $name,
        string $description,
        float $price,
        string $imgUrl,
        string $status
    ): bool {
        return self::executeNonQuery(
            "UPDATE products SET
             productName=:name,
             productDescription=:description,
             productPrice=:price,
             productImgUrl=:imgUrl,
             productStatus=:status
             WHERE productId=:productId",
            [
                "productId" => $productId,
                "name" => $name,
                "description" => $description,
                "price" => $price,
                "imgUrl" => $imgUrl,
                "status" => $status
            ]
        );
    }

    // Elimina un producto por ID
    public static function deleteProduct(int $productId): bool
    {
        return self::executeNonQuery(
            "DELETE FROM products WHERE productId=:productId",
            ["productId" => $productId]
        );
    }

    // Actualiza el stock de un producto
    public static function updateStock(int $productId, int $quantity): bool
    {
        return self::executeNonQuery(
            "UPDATE products SET productStock = productStock - :quantity WHERE productId=:productId",
            ["productId" => $productId, "quantity" => $quantity]
        );
    }
}
