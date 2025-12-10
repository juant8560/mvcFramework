<?php

namespace Dao\Products;

use Dao\Table;

class Products extends Table
{
    // ==== MÉTODOS EN ESPAÑOL (seguros para tu patrón existente) ====

    // Obtener todos los productos
    public static function obtenerProductos(): array
    {
        $sqlstr = "SELECT * FROM products;";
        return self::obtenerRegistros($sqlstr, []);
    }

    // Obtener un producto por ID (devuelve clave productID para la vista)
    public static function obtenerProductoPorId(int $productId): ?array
    {
        $rec = self::obtenerUnRegistro(
            "SELECT * FROM products WHERE productId = :productId;",
            ["productId" => $productId]
        );

        if ($rec) {
            // adaptar claves a lo que usan tus vistas (ej. productID)
            if (isset($rec['productId'])) {
                $rec['productID'] = $rec['productId']; // vista usa productID
            }
        }

        return $rec;
    }

    public static function crearProducto(
        string $name,
        string $description,
        float $price,
        string $imgUrl,
        string $status,
        int $stock = 0
    ): int {
        $sql = "INSERT INTO products (productName, productDescription, productPrice, productImgUrl, productStatus, productStock)
                VALUES (:name, :description, :price, :imgUrl, :status, :stock)";
        self::executeNonQuery($sql, [
            "name" => $name,
            "description" => $description,
            "price" => $price,
            "imgUrl" => $imgUrl,
            "status" => $status,
            "stock" => $stock
        ]);
        return intval(self::getConn()->lastInsertId());
    }

    public static function actualizarProducto(
        int $productId,
        string $name,
        string $description,
        float $price,
        string $imgUrl,
        string $status,
        int $stock = 0
    ): bool {
        $sql = "UPDATE products SET
                    productName = :name,
                    productDescription = :description,
                    productPrice = :price,
                    productImgUrl = :imgUrl,
                    productStatus = :status,
                    productStock = :stock
                WHERE productId = :productId";
        return self::executeNonQuery($sql, [
            "productId" => $productId,
            "name" => $name,
            "description" => $description,
            "price" => $price,
            "imgUrl" => $imgUrl,
            "status" => $status,
            "stock" => $stock
        ]);
    }

    public static function eliminarProducto(int $productId): bool
    {
        return self::executeNonQuery(
            "DELETE FROM products WHERE productId = :productId",
            ["productId" => $productId]
        );
    }

    public static function actualizarStock(int $productId, int $quantity): bool
    {
        return self::executeNonQuery(
            "UPDATE products SET productStock = productStock - :quantity WHERE productId = :productId",
            ["productId" => $productId, "quantity" => $quantity]
        );
    }

    // ==== WRAPPERS EN INGLÉS (compatibilidad) ====
    public static function getAllProducts(): array
    {
        return self::obtenerProductos();
    }

    public static function getProductById(int $productId): ?array
    {
        return self::obtenerProductoPorId($productId);
    }

    public static function insertProduct(
        string $name,
        string $description,
        float $price,
        string $imgUrl,
        string $status,
        int $stock = 0
    ): int {
        return self::crearProducto($name, $description, $price, $imgUrl, $status, $stock);
    }

    public static function updateProduct(
        int $productId,
        string $name,
        string $description,
        float $price,
        string $imgUrl,
        string $status,
        int $stock = 0
    ): bool {
        return self::actualizarProducto($productId, $name, $description, $price, $imgUrl, $status, $stock);
    }

    public static function deleteProduct(int $productId): bool
    {
        return self::eliminarProducto($productId);
    }
}
