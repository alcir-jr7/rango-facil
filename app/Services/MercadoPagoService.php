<?php

namespace App\Services;

use MercadoPago\SDK;

class MercadoPagoService
{
    public function __construct()
    {
        SDK::setAccessToken(
            config('services.mercadopago.token')
        );
    }
}