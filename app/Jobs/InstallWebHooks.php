<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\ConectaWhats\SideDish\Domain\Models\Store\Store;
use App\ConectaWhats\SideDish\Infrastructure\Services\ShopFactory;
use Illuminate\Support\Facades\Log;

class InstallWebHooks implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $store;
    protected $topics = [
        'orders/paid',
        'orders/create',
        'orders/delete',
        'orders/cancelled',
        'checkouts/create',
        'checkouts/update',
        'app/uninstalled'
    ];
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $shop = ShopFactory::factory($this->store);
        
        foreach($this->topics as $topic){
            try {
                $shop->createWebHook($topic, $this->address());
            } catch (\Exception $ex) {
                Log::emergency("Install WebHook: " . $ex->getMessage());
            }
        }   
    }
    
    protected function address()
    {
        //return 'https://conectaleads.com/teste/notify';
        return route('shopify.notify');
    }
}
