<?php

namespace App\ConectaWhats\SideDish\Infrastructure\Services\Gateway\Interfaces;
use App\ConectaWhats\SideDish\Domain\Models\Order\Order;

/**
 * Description of Gateway
 *
 * @author augus
 */
abstract class Gateway
{
    abstract public function testConnection();

    abstract public function getLinkBoleto(Order $order);
}
