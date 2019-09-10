<?php
/**
 * Created by PhpStorm.
 * User: augus
 * Date: 30/11/2018
 * Time: 12:03
 */

namespace App\ConectaWhats\SideDish\Application;

use App\ConectaWhats\SideDish\Domain\Models\Order\Order;

class OrderSearchService
{
    protected $query;

    public function __construct()
    {
        $this->query = Order::query()->where('store_id', StoreHelper::currentStoreId());
    }

    public function filterStatus($status)
    {
        if(!is_null($status)){
            $this->query->where('status', $status);
        }
        return $this;
    }

    public function filterFlow($flow)
    {
        if(!is_null($flow)){
            $this->query->where('flow', $flow);
        }
        return $this;
    }

    public function filterKeyWord($key)
    {
        if($key !== null){
            $this->query->where(function($q) use ($key) {
                $q->whereHas('customer', function($q) use ($key){
                    $q->where('name', 'like', "%$key%");
                });

                $q->orWhereHas('products', function($q) use ($key){
                    $q->where('title', 'like', "%$key%");
                });
            });
        }
        return $this;
    }

    public function filterDateInterval($date_init, $date_final)
    {
        if(!is_null($date_init) && !is_null($date_final)){
            $this->query->whereBetween('created_at', [$date_init, $date_final]);
        }
        return $this;
    }

    public function getQuery()
    {
        return $this->query;
    }
}