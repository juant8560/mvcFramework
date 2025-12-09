<?php

namespace Dao\Transactions;

use Dao\Table;

class TransactionItems extends Table
{
    public static function getItemsByTransaction(int $transactionId): array
    {
        return self::obtenerRegistros(
            "SELECT ti.*, p.productName, p.productPrice
             FROM transaction_items ti
             INNER JOIN products p ON ti.productId=p.productId
             WHERE ti.transactionId=:transactionId",
            ["transactionId" => $transactionId]
        );
    }
}
