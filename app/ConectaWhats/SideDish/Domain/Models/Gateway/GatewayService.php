<?php

namespace App\ConectaWhats\SideDish\Domain\Models\Gateway;

use App\ConectaWhats\SideDish\Domain\Models\Order\Order;
use App\ConectaWhats\SideDish\Infrastructure\Services\Gateway\AbstractGateway;

/**
 * Description of GatewayService
 *
 * @author augus
 */
class GatewayService
{
    public function createGateway($type, $cliente_id, $token, $store_id)
    {
        $gateway = new Gateway([
            'type' => new Type($type),
            'cliente_id' => $cliente_id,
            'token' => $token,
            'store_id' => $store_id
        ]);

        $gatewayService = AbstractGateway::factory($gateway);

        if(!$gatewayService->testConnection()){
            throw new \InvalidArgumentException("Não foi possível estabelecer conexão com o gateway.");
        }

        $gateway->save();

        return $gateway;
    }

    public function getLinkBoleto(Order $order)
    {
        $gateway = $this->gateway($order->gateway, $order->store_id);

        $serviceGateway = AbstractGateway::factory($gateway);

        return $serviceGateway->getLinkBoleto($order);
    }

    protected function gateway($type, $store_id)
    {
        $gateway = Gateway::firstOrNew([
            'type' => $type,
            'store_id' => $store_id
        ]);

        if(!$gateway){
            throw new \InvalidArgumentException('Gateway not found');
        }

        return $gateway;
    }
}
