<?php

namespace Utilities\Cart;

class CartFns
{

    public static function getAuthTimeDelta()
    {
        return 21600; // 6 * 60 * 60; // horas * minutos * segundo
        // No puede ser mayor a 34 días
    }

    public static function getUnAuthTimeDelta()
    {
        return 600; // 10 * 60; //h , m, s
        // No puede ser mayor a 34 días
    }

    public static function getAnnonCartCode()
    {
        // Genera un código único de carrito no autenticado
        return bin2hex(random_bytes(8));
    }
}
