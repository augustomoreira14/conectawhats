<?php

namespace App\ConectaWhats\SideDish\Infrastructure\Services\Shopify;

use App\ConectaWhats\SideDish\Domain\Models\Order\Order\Order;
use App\ConectaWhats\SideDish\Domain\Models\Order\Order\Product;
use App\ConectaWhats\SideDish\Domain\Models\Order\Flow;
use App\ConectaWhats\SideDish\Domain\Models\Order\Customer;
use App\ConectaWhats\SideDish\Domain\Models\Order\Phone;
use App\ConectaWhats\SideDish\Infrastructure\Services\OrderDTO;
use App\ConectaWhats\SideDish\Infrastructure\Services\ProductDTO;
use Carbon\Carbon;
/**
 * Description of TranslateOrder
 *
 * @author augus
 */
class TranslateOrder 
{
    public function translate($order, $products)
    {
        $phone = isset($order->shipping_address->phone) && $order->shipping_address->phone ? $order->shipping_address->phone : $order->phone;

        $orderDTO = new OrderDTO(
            $order->id,
            isset($order->order_number) ? $order->order_number : null,
            $order->shipping_address->first_name . " "  . $order->shipping_address->last_name,
            $order->email,
            $phone,
            $order->shipping_address->country_code,
            $order->shipping_address->province_code,
            $order->created_at,
            $order->total_price,
            isset($order->abandoned_checkout_url) ? $order->abandoned_checkout_url : null,
            isset($order->checkout_id) ? $order->checkout_id: null,
            $order->gateway,
            isset($order->shipping_address) ? $order->shipping_address->zip : null,
            isset($order->shipping_address) ? $order->shipping_address->city : null,
            isset($order->shipping_address) ? $order->shipping_address->address2 : null,
            TranslateFlow::translate($order->financial_status)
        );

        $orderDTO->addAllProducts($this->translateProducts($products));

        return $orderDTO;
    }
    
    protected function translateProducts($products)
    {
        $productsDTO = [];
        foreach($products as $product){
            $productsDTO[] = new ProductDTO($product->id, $product->title, $product->image->src);
        }
        
        return $productsDTO;
    }
}
