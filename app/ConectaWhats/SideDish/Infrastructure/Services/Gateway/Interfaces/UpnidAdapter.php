<?php


namespace App\ConectaWhats\SideDish\Infrastructure\Services\Gateway\Interfaces;


use App\ConectaWhats\SideDish\Application\StoreHelper;
use App\ConectaWhats\SideDish\Domain\Models\Order\Order;
use App\ConectaWhats\SideDish\Infrastructure\Services\ShopFactory;

class UpnidAdapter extends Gateway
{
    protected $shop;

    public function __construct()
    {
        $this->shop = ShopFactory::factory(StoreHelper::getCurrentStore());
    }

    public function testConnection()
    {
        return true;
        // TODO: Implement testConnection() method.
    }

    public function getLinkBoleto(Order $order)
    {
        $orderShop = $this->shop->getOrderShop($order->id);

        return $orderShop['note_attributes'][0]->value;
    }
}
