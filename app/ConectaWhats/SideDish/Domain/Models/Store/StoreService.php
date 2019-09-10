<?php

namespace App\ConectaWhats\SideDish\Domain\Models\Store;

use App\ConectaWhats\SideDish\Infrastructure\Services\ShopFactory;
/**
 * Description of StoreService
 *
 * @author augus
 */
class StoreService 
{
    public static function createStore($shop, $token, $type, Plan $plan)
    {
        $store = Store::where('shop', $shop)->first();
        if($store){
            $store->token = $token;
            $store->plan = $plan->discountDays($store->created_at);
            $store->save();

            return $store;
        }
        return Store::create([
            'shop' => $shop,
            'token' => $token,
            'type' => $type,
            'plan' => $plan,
            'actived' => false
        ]);
    }
    
    public function getInfo(Store $store)
    {
        return ShopFactory::factory($store);
    }
}
