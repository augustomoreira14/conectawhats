<?php

namespace App\ConectaWhats\SideDish\Infrastructure\Services;

use App\ConectaWhats\SideDish\Domain\Models\Store\Store;
use App\ConectaWhats\SideDish\Domain\Models\Store\Type;
use App\ConectaWhats\SideDish\Infrastructure\Services\Shopify\ShopifyAdapter;
use App\ConectaWhats\SideDish\Domain\Models\ShopService;

/**
 * Description of ShopFactory
 *
 * @author augus
 */
class ShopFactory 
{
    public static function factory(Store $store) : ShopService
    {
        switch ($store->type){
            case Type::SHOPIFY:
                return ShopifyAdapter::getInstance($store->shop, $store->token);
        }
    }
}
