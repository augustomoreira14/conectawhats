<?php

namespace App\ConectaWhats\SideDish\Domain\Models;

/**
 *
 * @author augus
 */
interface ShopService
{
    public function getOrders($flow = null, $query = []);
    public function getInfo();
    public function createWebHook($topic, $address);
    public function getTrackCode($order_id);
    public function getOrder($id);
    public function getOrderShop($id);
}
