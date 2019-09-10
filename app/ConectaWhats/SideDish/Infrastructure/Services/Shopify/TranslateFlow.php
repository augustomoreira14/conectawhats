<?php


namespace App\ConectaWhats\SideDish\Infrastructure\Services\Shopify;


use App\ConectaWhats\SideDish\Domain\Models\Order\Flow;

class TranslateFlow
{
    public static function translate($status)
    {
        if($status !== null){
            if($status == 'paid'){
                return  Flow::PAID;
            }
            return Flow::PENDING_PAYMENT;
        }

        return Flow::ABANDONED_CHECKOUT;
    }
}