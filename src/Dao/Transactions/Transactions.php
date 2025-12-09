<?php

namespace Dao\Transactions;

use Dao\Table;

class Transactions extends Table
{
    /**
     * Crear una transacción con sus items
     *
     * @param int $usercod
     * @param float $total
     * @param array $details Array de items: [ ["productId"=>int, "quantity"=>int, "price"=>float], ... ]
     * @return int ID de la transacción creada
     * @throws \Exception
     */
    public static function createTransaction(int $usercod, float $total, array $details): int
    {
        $conn = self::getConn();
        $conn->beginTransaction();

        try {
            self::executeNonQuery(
                "INSERT INTO transactions(usercod, total, trxdate) VALUES(:usercod, :total, NOW())",
                ["usercod" => $usercod, "total" => $total],
                $conn
            );

            $trxId = $conn->lastInsertId();

            foreach ($details as $item) {
                self::executeNonQuery(
                    "INSERT INTO transaction_items(transactionId, productId, quantity, price)
                     VALUES(:trxId, :productId, :quantity, :price)",
                    [
                        "trxId" => $trxId,
                        "productId" => $item["productId"],
                        "quantity" => $item["quantity"],
                        "price" => $item["price"]
                    ],
                    $conn
                );
            }

            $conn->commit();
            return $trxId;
        } catch (\Exception $ex) {
            $conn->rollBack();
            throw $ex;
        }
    }

    /**
     * Obtener todas las transacciones de un usuario
     */
    public static function getTransactionsByUser(int $usercod): array
    {
        return self::obtenerRegistros(
            "SELECT transactionId, usercod, total, trxdate
             FROM transactions
             WHERE usercod = :usercod
             ORDER BY trxdate DESC",
            ["usercod" => $usercod]
        );
    }

    /**
     * Obtener todas las transacciones (para administrador)
     */
    public static function getAllTransactions(): array
    {
        return self::obtenerRegistros(
            "SELECT t.transactionId, t.usercod, t.total, t.trxdate, u.username
             FROM transactions t
             INNER JOIN usuario u ON t.usercod = u.usercod
             ORDER BY t.trxdate DESC",
            []
        );
    }

    /**
     * Obtener items de una transacción
     */
    public static function getTransactionItems(int $transactionId): array
    {
        return self::obtenerRegistros(
            "SELECT ti.*, p.productName, p.productPrice
             FROM transaction_items ti
             INNER JOIN products p ON ti.productId = p.productId
             WHERE ti.transactionId = :transactionId",
            ["transactionId" => $transactionId]
        );
    }
}
