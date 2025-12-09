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
        $userType = $_SESSION["usertipo"] ?? "CLI"; // CLI = cliente, ADM = administrador


        if ($userType === "ADM") {
            $viewData["transacciones"] = TransactionsDAO::getAllTransactions();
        } else {
            $viewData["transacciones"] = TransactionsDAO::getTransactionsByUser((int)$usercod);
        }

        Renderer::render("transactions/historial", $viewData);
    }
}
