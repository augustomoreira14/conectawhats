<?php

namespace App\ConectaWhats\SideDish\Infrastructure\Services\Shopify;

use Oseintow\Shopify\Shopify;
use App\ConectaWhats\SideDish\Domain\Models\Store\Plan;
/**
 * Description of ChargeService
 *
 * @author augus
 */
class ChargeService 
{
    private $serviceShopify;
    
    public function __construct(Shopify $serviceShopify) 
    {
        $this->serviceShopify = $serviceShopify;
    } 
    
    public function activateCharge($id) 
    {
        $uri = "/admin/recurring_application_charges/{$id}/activate.json";
        $this->serviceShopify->post($uri);
        //$charge = $this->getCharge($id);
        //$this->serviceShopify->get("/admin/recurring_application_charges/{$id}.json");
        //dd($charge);
    }



    protected function getCharge($id)
    {
        return $this->serviceShopify->get("/admin/recurring_application_charges/{$id}.json");
    }

    public function createCharge(Plan $plan, $return_url) 
    {
        return $this->serviceShopify->post('/admin/recurring_application_charges.json', [
            "recurring_application_charge" => [
                "name" => $plan->name,
                "price" => $plan->price,
                "test" => $plan->test,
                "trial_days" => $plan->trial_days,
                "return_url" => $return_url
            ]
        ]);
    }    
}
