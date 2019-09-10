<?php
/**
 * Created by PhpStorm.
 * User: augus
 * Date: 27/11/2018
 * Time: 09:13
 */

namespace App\ConectaWhats\SideDish\Domain\Models\Order;


use App\ConectaWhats\SideDish\Domain\Models\Store\Store;
use App\ConectaWhats\SideDish\Infrastructure\Services\OrderDTO;
use App\ConectaWhats\SideDish\Domain\Models\Order\Customer\Customer;
use Illuminate\Support\Facades\DB;

class OrderService
{

    public function storeOrderFrom(OrderDTO $orderDTO, Store $store)
    {
        if($this->orderExists($orderDTO->id)){
            throw new \DomainException("Order {$orderDTO->id} already exists.");
        }

        return DB::transaction(function() use ($orderDTO, $store){
            $order = new Order($orderDTO->toArray());

            $order->store()->associate($store);
            $order->pending();
            $order->save();

            $products = array_map(function($item){
                return new Product($item->toArray());
            }, $orderDTO->products);

            $this->removeCheckoutIfExists($orderDTO->checkout_id);

            $order->customer()->save(new Customer($orderDTO->toArray()));
            $order->products()->saveMany($products);

            return $order;
        });
    }

    protected function removeCheckoutIfExists($checkout_id)
    {
        if($checkout_id){
            $order = Order::find($checkout_id);
            if($order){
                $order->delete();
            }
        }
    }

    public function orderExists($order_id)
    {
        return Order::find($order_id) || Order::where('checkout_id', $order_id)->first() ? true : false;
    }

}