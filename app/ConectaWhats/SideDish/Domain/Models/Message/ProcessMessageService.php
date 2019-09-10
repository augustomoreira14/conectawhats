<?php
/**
 * Created by PhpStorm.
 * User: augus
 * Date: 01/12/2018
 * Time: 18:05
 */

namespace App\ConectaWhats\SideDish\Domain\Models\Message;

use App\ConectaWhats\SideDish\Domain\Models\Message\Message;
use App\ConectaWhats\SideDish\Domain\Models\Order\Order;
use App\ConectaWhats\SideDish\Domain\Models\Gateway\GatewayService;
use yedincisenol\DynamicLinks\DynamicLink;
use yedincisenol\DynamicLinks\DynamicLinks;
use Illuminate\Support\Facades\Log;
use App\WhatSend\Common\TagUtil;
use App\ConectaWhats\SideDish\Infrastructure\Services\Delivery\TrackCodeService;

class ProcessMessageService
{
    private $gatewayService;
    private $dinamicLinks;
    private $tagService;

    public function __construct(Order $order)
    {
        $this->gatewayService = new GatewayService();
        $this->dinamicLinks = new DynamicLinks();

        $this->tagService = new TagService(
            $this->mountAndGetTagsData($order),
            $order->products->count() <= 1
        );
    }

    protected function mountAndGetTagsData(Order $order)
    {
        return [
            '[customer]' => $order->customer->name,
            '[products]' => $this->getProducts($order),
            '[link_checkout]' => $this->getLinkCheckout($order),
            '[link_boleto]' => $this->getLinkBoleto($order),
            '[number_order]' => $order->number ? '#' . $order->number : '#' . $order->id,
            '[address]' => $order->customer->address,
            '[zip_code]' => $order->customer->zip_code,
            '[city]' => $order->customer->city . " - " . $order->customer->province_code,
            '[track_code]' => $this->getTrackCode($order)
        ];
    }

    public function getProducts(Order $order)
    {
        $arrayTitles = $order->products->pluck('title')->toArray();
        return implode(", ", $arrayTitles);
    }

    protected function getLinkBoleto(Order $order)
    {
        if(!$order->isPendingPayment()){
            return null;
        }

        try {
            $link_boleto = $this->gatewayService->getLinkBoleto($order);
            $dLink = new DynamicLink($link_boleto);

            return $this->dinamicLinks->create($dLink, 'UNGUESSABLE')->getShortLink();
        } catch (\Exception $ex) {
            Log::emergency($ex->getMessage());
        }
    }

    protected function getLinkCheckout(Order $order)
    {
        if (!$order->isAbandonedCheckout()) {
            return null;
        }
        try {
            $linkCheckout = new DynamicLink($order->link_checkout);
            return $this->dinamicLinks->create($linkCheckout, 'UNGUESSABLE')->getShortLink();
        } catch (\Exception $ex) {
            Log::emergency($ex->getMessage());
        }
    }

    public function getTrackCode(Order $order)
    {
        if($order->isPaid()){
            return TrackCodeService::getInstance()->getCode($order->id);
        }
    }

    public function processMany($messages)
    {
        $messagesProcesseds = [];
        foreach($messages as $message){
            $messagesProcesseds[] = $this->process($message);
        }

        return $messagesProcesseds;
    }

    public function process(Message $message)
    {
        return [
            'id' => $message->id,
            'title' => $message->title,
            'message' => $this->tagService->transformText($message->content)
        ];
    }
}