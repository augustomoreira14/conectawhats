<?php
/**
 * Created by PhpStorm.
 * User: augus
 * Date: 07/02/2019
 * Time: 12:29
 */

namespace App\ConectaWhats\SideDish\Infrastructure\Services\Delivery;

use App\ConectaWhats\SideDish\Infrastructure\Services\ShopFactory;
use App\ConectaWhats\SideDish\Application\StoreHelper;

class TrackCodeService
{
    private static $intance;
    private $shop;

    private function __construct()
    {
        $store = StoreHelper::getCurrentStore();
        $this->shop = ShopFactory::factory($store);
    }

    public function getCode($order_id)
    {
        return $this->shop->getTrackCode($order_id);
    }

    public static function getInstance()
    {
        if(self::$intance === null){
            self::$intance = new self();
        }
        return self::$intance;
    }

}