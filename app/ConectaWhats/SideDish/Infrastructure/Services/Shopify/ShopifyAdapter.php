<?php

namespace App\ConectaWhats\SideDish\Infrastructure\Services\Shopify;

use App\ConectaWhats\SideDish\Domain\Models\ShopService;
use Oseintow\Shopify\Facades\Shopify;
use App\ConectaWhats\SideDish\Domain\Models\Order\Flow;
use Illuminate\Support\Facades\Log;
/**
 * Description of ShopifyAdapter
 *
 * @author augus
 */
class ShopifyAdapter implements ShopService
{
    private $shopifyService;
    private $translateOrder;
    private static $instance;

    public function __construct($shop, $token) 
    {
        $this->shopifyService = Shopify::setShopUrl($shop)
                                ->setAccessToken($token);
        
        $this->translateOrder = new TranslateOrder();
        
    }
    
    public function getInfo() 
    {
        $info = $this->shopifyService->get('admin/shop.json');
        return (object) [
            'name' => $info['shop_owner'],
            'email' => $info['email']
        ];
    }

    public function getOrders($flow = null, $query = array())
    {
        if($flow == Flow::ABANDONED_CHECKOUT){
            $orders = $this->getResource('admin/checkouts.json', $query);
        }else{
            $orders = $this->getResource('admin/orders.json', $query);
        }
        
        $ordersParsed = [];
        foreach($orders as $order){
            try {
                $ordersParsed[] = $this->parseOrder($order);
            } catch (\Exception $ex) {
                Log::alert('Get customers: ' . $ex->getMessage());
            }     
        }
        return $ordersParsed;
    }

    protected function getResource($endpoint, $query)
    {
        return $this->shopifyService->get($endpoint, $query);
    }
    
    public function getOrder($id) 
    {

        $order = $this->shopifyService->get("admin/orders/{$id}.json");

        return $this->parseOrder((object) $order->all());
        
    }

    public function parseOrder($order)
    {
        return $this->translateOrder->translate($order, $this->getProducts($order));
    }
    
    protected function getProducts($order)
    {
        $ids = [];
        if(isset($order->line_items)){
            $ids = array_column($order->line_items, 'product_id');
        }

        $implode = implode(",", $ids);
      
        return $this->shopifyService->get('admin/products.json', [
            'ids' => $implode
        ]);
    }

    public function createWebHook($topic, $address)
    {
        return $this->shopifyService->post('admin/webhooks.json', [
            'webhook' => [
                'topic' => $topic,
                'address' => $address,
                'format' => 'json'
            ]
        ]);
    }


    public function getChargeService()
    {
        return new ChargeService($this->shopifyService);
    }    

    public static function getUrlInstall($shop, $redirect_url)
    {
        $shopify = Shopify::setShopUrl($shop);
        
        $scope = ["read_products","read_orders", "read_checkouts", "read_customers"];
        
        return $shopify->getAuthorizeUrl($scope,$redirect_url);
    }
    
    public static function getToken($shop, $code)
    {
        return Shopify::setShopUrl($shop)->getAccessToken($code);
    }
    
    public static function getInstance($shop, $token)
    {
        if(!self::$instance){
            self::$instance = new ShopifyAdapter($shop, $token);
        }
        return self::$instance;
    }

    public function getTrackCode($order_id)
    {
        $order = $this->shopifyService->get("admin/orders/{$order_id}.json");

        $order = (object) $order->all();

        $code = null;
        if(isset($order->fulfillments[0])){
            $code = $order->fulfillments[0]->tracking_number;
        }

        return $code;
    }
}
