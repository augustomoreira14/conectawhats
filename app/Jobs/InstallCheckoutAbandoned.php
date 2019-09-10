<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\ConectaWhats\SideDish\Domain\Models\Store\Store;
use App\ConectaWhats\SideDish\Infrastructure\Services\ShopFactory;
use App\ConectaWhats\SideDish\Domain\Models\Order\Flow;
use App\ConectaWhats\SideDish\Domain\Models\Order\OrderService;
use Illuminate\Support\Facades\Log;

class InstallCheckoutAbandoned implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $store;
    private $page;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Store $user, $page = 1)
    {
        $this->store = $user;
        $this->page = $page;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $query = [
            'page' => $this->page,
            'limit' => 30,
            'created_at_min' => now()->subDay()->toIso8601String(),
        ];

        $shopService = ShopFactory::factory($this->store);

        $ordersDTO = $shopService->getOrders(Flow::ABANDONED_CHECKOUT, $query);

        if(count($ordersDTO) >= $query['limit']){
            self::dispatch($this->store, $this->page + 1)->delay(now()->addMinute());
        }

        $orderService = new OrderService();

        foreach ($ordersDTO as $orderDTO){
            try{
                $orderService->storeOrderFrom($orderDTO, $this->store);

            }catch (\Exception $ex){
                Log::emergency('Install checkouts: ' . $ex->getMessage());
            }
        }
    }
}
