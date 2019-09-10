<?php
/**
 * Created by PhpStorm.
 * User: augus
 * Date: 01/12/2018
 * Time: 19:48
 */

namespace App\Http\Controllers\Notification;


use App\ConectaWhats\SideDish\Domain\Models\Order\Order;
use App\ConectaWhats\SideDish\Domain\Models\Order\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ConectaWhats\SideDish\Domain\Models\Store\Store;
use App\ConectaWhats\SideDish\Infrastructure\Services\Shopify\ShopifyAdapter;
use App\ConectaWhats\SideDish\Domain\Models\Order\OrderService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ShopifyWebHookController extends Controller
{
    /**
     *
     * @var ShopifyAdapter
     */
    protected $shopService;

    const ORDER_CREATE = 'orders/create';
    const ORDER_PAID = 'orders/paid';
    const ORDER_DELETE = 'orders/delete';
    const ORDER_CANCELLED = 'orders/cancelled';
    const CHECKOUT_CREATE = 'checkouts/create';
    const CHECKOUT_UPDATE = 'checkouts/update';
    const APP_UNINTALL = 'app/uninstalled';

    public function __construct()
    {
        $this->middleware(['shopify.request.webhook']);
    }

    public function handle(Request $req)
    {
        $data = json_decode(json_encode($req->all()));
        $headers = $req->headers->all();

        try{
            $shop = $headers['x-shopify-shop-domain'][0];
            $store = Store::where('shop', $shop)->firstOrFail();
        }catch (\Exception $ex){
            Log::emergency($ex->getMessage());
            return response('Deu um erro, mas ok.');
        }

        Log::notice("Data " . now()->format('H:i:s') . " " . $headers['x-shopify-topic'][0]);

        $this->shopService = ShopifyAdapter::getInstance($store->shop, $store->token);

        switch ($headers['x-shopify-topic'][0]) {
            case self::ORDER_CREATE:
                return $this->handleOrderCreate($data, $store);
            case self::ORDER_PAID:
                return $this->handleOrderPaid($data);
            case self::ORDER_DELETE:
                return $this->handleOrderDelete($data);
            case self::ORDER_CANCELLED:
                return $this->handleOrderDelete($data);
            case self::CHECKOUT_CREATE:
                return $this->handleOrderCreate($data, $store);
            case self::CHECKOUT_UPDATE:
                return $this->handleCheckoutUpdate($data, $store);
            case self::APP_UNINTALL:
                return $this->handleAppUninstall($store);
            default:
                Log::emergency('Notificação não tratada: ' . $headers['x-shopify-topic'][0]);
                return response('Recebido, mas nenhum método foi tratado!');
        }
    }

    protected function handleOrderCreate($data, Store $store)
    {
        try {
            $orderService = new OrderService();
            $orderService->storeOrderFrom($this->shopService->parseOrder($data), $store);

            return response('Recebido com sucesso!');
        } catch (\Exception $ex) {
            Log::emergency("{$ex->getMessage()} : {$ex->getFile()} : {$ex->getLine()}");
            return response($ex->getMessage());
        }
    }

    protected function handleOrderPaid($data)
    {
        try {
            $orderDTO = $this->shopService->parseOrder($data);
            $order = Order::findOrFail($orderDTO->id);
            $order->converted();
            $order->save();

        } catch (\Exception $ex) {
            Log::emergency($ex->getMessage());
        } finally {
            return response('Recebido com sucesso!');
        }
    }

    protected function handleOrderDelete($data)
    {
        try {
            $orderDTO = $this->shopService->parseOrder($data);
            $order = Order::findOrFail($orderDTO->id);
            $order->delete();
        } catch (\Exception $ex) {
            Log::emergency($ex->getMessage());
        } finally {
            return response('Recebido com sucesso!');
        }
    }

    protected function handleCheckoutUpdate($data, $store)
    {
        try {
            $orderDTO = $this->shopService->parseOrder($data);

            $order = Order::find($orderDTO->id);
            if(!$order){
                return $this->handleOrderCreate($data, $store);
            }

            DB::transaction(function() use ($orderDTO, $order){

                $order->fill($orderDTO->toArray());

                $order->customer->fill($orderDTO->toArray());

                $order->products()->delete();

                $products = [];
                foreach ($orderDTO->products as $product){
                    $products[] = new Product($product->toArray());
                }
                $order->products()->saveMany($products);

                $order->push();

            });

        } catch (\Exception $ex) {
            Log::emergency($ex->getMessage());
        } finally {
            return response('Recebido com sucesso!');
        }
    }

    protected function handleAppUninstall(Store $store)
    {
        //desabilitar o usuário no sistema
        try{
            DB::transaction(function() use ($store){
                $store->deactivate();
                $store->save();
            });
        }catch (\Exception $ex){
            Log::emergency("Uninstall: " . $ex->getMessage());
        }finally{
            return response('Desinstalado');
        }
    }
}