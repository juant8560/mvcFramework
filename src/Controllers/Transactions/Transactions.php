<?php

namespace Controllers\Transactions;

use Controllers\PrivateController;
use Controllers\PublicController;
use Dao\Transactions\Transactions as TransactionsDAO;
use Views\Renderer;
use Utilities\Security;
use Utilities\Site;

class Transactions extends PrivateController
{
    public function run(): void
    {
        $viewData = [];

        $usercod = $_SESSION["usercod"] ?? 9;
        $userType = $_SESSION["usertipo"] ?? "CLI";

        if ($userType === "ADM") {
            $transactions = TransactionsDAO::getAllTransactions();
        } else {
            $transactions = TransactionsDAO::getTransactionsByUser((int)$usercod);
        }

        foreach ($transactions as &$trx) {
            $trx['items'] = TransactionsDAO::getTransactionItems((int)$trx['transactionId']);
        }

        $viewData["transacciones"] = $transactions;

        Renderer::render("transactions/historial", $viewData);
    }
}
