<?php
/**
 * Created by PhpStorm.
 * User: augus
 * Date: 26/11/2018
 * Time: 22:55
 */

namespace App\ConectaWhats\SideDish\Infrastructure\Services;


use App\ConectaWhats\SideDish\Domain\Models\Order\Customer\Phone;
use App\ConectaWhats\SideDish\ObjectValue;
use App\ConectaWhats\SideDish\Domain\Models\Order\Flow;
use Carbon\Carbon;

class OrderDTO extends ObjectValue
{
    private $id;
    private $number;
    private $name;
    private $email;
    private $province_code;
    private $phone;
    private $created_at;
    private $total;
    private $link_checkout;
    private $checkout_id;
    private $gateway;
    private $flow;
    private $zip_code;
    private $city;
    private $address;
    private $products = [];

    public function __construct($id, $number, $name, $email, $phone, $country_code, $province_code, $created_at,
                                $total, $link_checkout, $checkout_id, $gateway, $zip_code, $city, $address, $flow = null)
    {
        $this->id = "$id";
        $this->number = $number;
        $this->name = $name;
        $this->email = $email;
        $this->province_code = $province_code;
        $this->setPhone($phone, $country_code);
        $this->setCreatedAt($created_at);
        $this->total = $total;
        $this->link_checkout = $link_checkout;
        $this->gateway = $gateway;
        $this->setCheckoutId($checkout_id);
        $this->zip_code = $zip_code;
        $this->city = $city;
        $this->address = $address;
        $this->flow = $flow;
    }

    private function setPhone($phone, $country_code)
    {
        $this->phone = new Phone($phone, $country_code);
    }

    private function setCheckoutId($checkout_id)
    {
        if($checkout_id !== null){
            $this->checkout_id = "$checkout_id";
        }
    }

    private function setCreatedAt($created_at)
    {
        $date = Carbon::createFromFormat(Carbon::ISO8601,$created_at);
        $date->setTimezone(now()->timezone);
        $this->created_at = $date;
    }

    public function addAllProducts(array $products)
    {
        foreach ($products as $product){
            $this->addProduct($product);
        }
    }

    public function addProduct(ProductDTO $productDTO)
    {
        $this->products[] = $productDTO;
    }
}