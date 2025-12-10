<?php

namespace Controllers\Products;

use Controllers\PublicController;
use Utilities\Site;
use Utilities\Validators;
use Views\Renderer;
use Exception;
use Dao\Products\Products as DAOProducts;

const ProductsList = 'index.php?page=Products_Products';
const ProductView = "products/product";

class Product extends PublicController
{
    private $modes = [
        "INS" => "Nuevo Producto",
        "UPD" => "Editando %s",
        "DSP" => "Detalle de %s",
        "DEL" => "Eliminando %s"
    ];

    private string $mode = '';
    private string $tokenKey = "product_xss_token";

    private int $productId = 0;
    private string $productName = '';
    private string $productDescription = '';
    private float $productPrice = 0.0;
    private string $productImgUrl = '';
    private string $productStatus = 'ACT';
    private int $productStock = 0;

    private string $tokenValue = '';
    private array $errores = [];

    public function run(): void
    {
        try {
            $this->page_init();

            if ($this->isPostBack()) {
                $this->errores = $this->validarPostData();

                if (count($this->errores) === 0) {
                    try {
                        switch ($this->mode) {
                            case "INS":
                                $newId = DAOProducts::crearProducto(
                                    $this->productName,
                                    $this->productDescription,
                                    $this->productPrice,
                                    $this->productImgUrl,
                                    $this->productStatus,
                                    $this->productStock
                                );
                                if ($newId > 0) {
                                    Site::redirectToWithMsg(ProductsList, "Producto creado correctamente");
                                }
                                break;

                            case "UPD":
                                $affected = DAOProducts::actualizarProducto(
                                    $this->productId,
                                    $this->productName,
                                    $this->productDescription,
                                    $this->productPrice,
                                    $this->productImgUrl,
                                    $this->productStatus,
                                    $this->productStock
                                );
                                if ($affected) {
                                    Site::redirectToWithMsg(ProductsList, "Producto actualizado correctamente");
                                }
                                break;

                            case "DEL":
                                $affected = DAOProducts::eliminarProducto($this->productId);
                                if ($affected) {
                                    Site::redirectToWithMsg(ProductsList, "Producto eliminado correctamente");
                                }
                                break;
                        }
                    } catch (Exception $err) {
                        $this->errores[] = $err->getMessage();
                    }
                }
            }

            Renderer::render(ProductView, $this->preparar_datos_vista());
        } catch (Exception $ex) {
            Site::redirectToWithMsg(ProductsList, "Error inesperado: " . $ex->getMessage());
        }
    }

    private function page_init()
    {
        if (!isset($_GET["mode"]) || !isset($this->modes[$_GET["mode"]])) {
            throw new Exception("Modo inválido");
        }

        $this->mode = $_GET["mode"];

        if ($this->mode !== "INS") {
            if (!isset($_GET["productId"])) {
                throw new Exception("ID de producto no proporcionado");
            }

            $tmp = DAOProducts::obtenerProductoPorId(intval($_GET["productId"]));
            if (!$tmp) {
                throw new Exception("Producto no encontrado");
            }

            $this->productId = intval($tmp["productId"] ?? $tmp["productID"] ?? 0);
            $this->productName = $tmp["productName"] ?? '';
            $this->productDescription = $tmp["productDescription"] ?? '';
            $this->productPrice = floatval($tmp["productPrice"] ?? 0);
            $this->productImgUrl = $tmp["productImgUrl"] ?? '';
            $this->productStatus = $tmp["productStatus"] ?? 'ACT';
            $this->productStock = intval($tmp["productStock"] ?? 0);
        }
    }

    private function validarPostData(): array
    {
        $errors = [];

        // Validación de token
        if (
            !isset($_POST[$this->tokenKey]) ||
            !isset($_SESSION[$this->tokenKey]) ||
            $_SESSION[$this->tokenKey] !== $_POST[$this->tokenKey]
        ) {
            throw new Exception("Error inesperado en el token");
        }

        // Se elimina para evitar reutilización
        unset($_SESSION[$this->tokenKey]);

        // Captura de datos
        $this->productId = intval($_POST["productId"] ?? $this->productId);
        $this->productName = trim($_POST["productName"] ?? '');
        $this->productDescription = trim($_POST["productDescription"] ?? '');
        $this->productPrice = floatval($_POST["productPrice"] ?? 0);
        $this->productImgUrl = trim($_POST["productImgUrl"] ?? '');
        $this->productStatus = trim($_POST["productStatus"] ?? 'ACT');
        $this->productStock = intval($_POST["productStock"] ?? 0);

        // Validaciones
        if ($this->mode !== "DEL") {
            if (Validators::IsEmpty($this->productName)) {
                $errors[] = "Nombre no puede ir vacío.";
            }
            if (Validators::IsEmpty($this->productDescription)) {
                $errors[] = "Descripción no puede ir vacía.";
            }
            if ($this->productPrice <= 0) {
                $errors[] = "Precio debe ser mayor a cero.";
            }
            if (Validators::IsEmpty($this->productImgUrl)) {
                $errors[] = "URL de imagen es requerida.";
            }
            if (!in_array($this->productStatus, ["ACT", "INA"])) {
                $errors[] = "Estado inválido.";
            }
        } else {
            if ($this->productId <= 0) {
                $errors[] = "ID inválido para eliminar.";
            }
        }

        return $errors;
    }

    private function generarToken()
    {
        $this->tokenValue = md5(time() . rand(1000, 9999));
        $_SESSION[$this->tokenKey] = $this->tokenValue;
    }

    private function preparar_datos_vista()
    {
        $viewData = [];

        $viewData["mode"] = $this->mode;
        $viewData["modeDsc"] = $this->modes[$this->mode];
        if ($this->mode !== "INS") {
            $viewData["modeDsc"] = sprintf($viewData["modeDsc"], $this->productName);
        }

        $viewData["productId"] = $this->productId;
        $viewData["productName"] = $this->productName;
        $viewData["productDescription"] = $this->productDescription;
        $viewData["productPrice"] = $this->productPrice;
        $viewData["productImgUrl"] = $this->productImgUrl;
        $viewData["productStatus"] = $this->productStatus;
        $viewData["productStock"] = $this->productStock;

        // Token
        $this->generarToken();
        $viewData["product_xss_token"] = $this->tokenValue;

        // Errores
        $viewData["errores"] = $this->errores;
        $viewData["hasErrores"] = count($this->errores) > 0;

        $viewData["readonly"] = in_array($this->mode, ["DSP", "DEL"]) ? "readonly" : "";
        $viewData["codigoReadonly"] = $this->mode !== "INS" ? "readonly" : "";
        $viewData["isDisplay"] = $this->mode === "DSP";
        $viewData["showCommitBtn"] = $this->mode !== "DSP";

        // Estado seleccionado
        $viewData["productStatus_ACT"] = $this->productStatus === "ACT" ? "selected" : "";
        $viewData["productStatus_INA"] = $this->productStatus === "INA" ? "selected" : "";

        return $viewData;
    }
}
