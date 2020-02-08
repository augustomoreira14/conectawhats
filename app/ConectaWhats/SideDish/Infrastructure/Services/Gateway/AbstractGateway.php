<?php
/**
 * Created by PhpStorm.
 * User: augus
 * Date: 01/12/2018
 * Time: 11:10
 */

namespace App\ConectaWhats\SideDish\Infrastructure\Services\Gateway;


use App\ConectaWhats\SideDish\Domain\Models\Gateway\Gateway;
use App\ConectaWhats\SideDish\Domain\Models\Gateway\Type;
use App\ConectaWhats\SideDish\Infrastructure\Services\Gateway\Excepetions\GatewayNotFound;
use App\ConectaWhats\SideDish\Infrastructure\Services\Gateway\Interfaces\MercadoPagoAdapter;
use App\ConectaWhats\SideDish\Infrastructure\Services\Gateway\Interfaces\Gateway as IGateway;
use App\ConectaWhats\SideDish\Infrastructure\Services\Gateway\Interfaces\UpnidAdapter;

abstract class AbstractGateway
{
    public static function factory(Gateway $gateway) : IGateway
    {
        switch ($gateway->type){
            case Type::MERCADO_PAGO:
                return new MercadoPagoAdapter($gateway->cliente_id, $gateway->token);
            case Type::UPNID:
                return new UpnidAdapter();
            default:
                throw new GatewayNotFound();
        }
    }
}
