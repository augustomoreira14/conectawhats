<?php

namespace App\Http\Controllers\InstallStore;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ConectaWhats\SideDish\Infrastructure\Services\Shopify\ShopifyAdapter;
use App\ConectaWhats\SideDish\Domain\Models\Store\Plan;
use App\ConectaWhats\SideDish\Domain\Models\Store\Type as TypeStore;
use App\ConectaWhats\SideDish\Domain\Models\Store\Store;
use App\ConectaWhats\SideDish\Domain\Models\Store\StoreService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\ConectaWhats\Auth\Domain\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\Application\UserService;
/**
 * Description of ShopifyController
 *
 * @author augus
 */
class ShopifyController extends Controller 
{
    public function index()
    {
        return view('site.install');
    }
    
    public function redirectToInstall(Request $req)
    {
        //regex =>
//        $this->validate($req, [
//            'shop' => "required|regex:/^(.+)\.myshopify\.com$/|in:{$this->whiteList()}"
//        ]);

        $this->validate($req, [
            'shop' => "required|regex:/^(.+)\.myshopify\.com$/"
        ]);
        
        $url = ShopifyAdapter::getUrlInstall($req->shop, route('install.charge'));
        
        return redirect($url);
    }

    protected function whiteList()
    {
        $array = [
        ];

        return implode(',', $array);
    }
    
    public function installCharge(Request $req)
    {
        $token = ShopifyAdapter::getToken($req->shop, $req->code);
        $shopifyAdapter = new ShopifyAdapter($req->shop, $token);

        $store = StoreService::createStore($req->shop, $token, TypeStore::SHOPIFY, Plan::create(Plan::TEST));
        
        if(!$store->isActived()){
            try {
                $charge = DB::transaction(function() use ($store, $shopifyAdapter){
                    $store->save();

                    return $shopifyAdapter
                                ->getChargeService()
                                ->createCharge($store->plan, route('accepted.charge'));                        
                });
                
                $req->session()->flash('store', $store->id);
            
                return redirect($charge['confirmation_url']);
            
            } catch (\Exception $ex) {
                Log::emergency('Install charge: ' . $ex->getMessage());
                abort(500);
            }
        }    
        
        return abort(401, "Not Authorized. App has been installed.");
    }
    
    public function installApp(Request $req)
    {
        $store = Store::findOrFail($req->session()->get('store'));
        try {
            $userService = new UserService();
            DB::transaction(function() use ($req, $store, $userService){
                $shopifyAdapter = new ShopifyAdapter($store->shop, $store->token);
                $serviceCharge = $shopifyAdapter->getChargeService();
                $serviceCharge->activateCharge($req->charge_id);

                $owner = $shopifyAdapter->getInfo();
                $user = $userService->createAdminUser($owner->name, $owner->email);

                $store->activate();
                $store->associateUser($user->id);
                $store->save();
            });

            return $this->authenticateAndRedirect($store);
            
        } catch (\Exception $ex) {
            Log::emergency('Intall app: ' . $ex->getMessage());
            abort(500);
        }
    }

    public function accessApp(Request $req)
    {
        try {
            $store = Store::where('shop', $req->shop)->firstOrFail();

            return $this->authenticateAndRedirect($store);

        } catch (\Exception $ex) {
            abort(403);
        }
    }

    public function authenticateAndRedirect(Store $store)
    {
        $user = User::findOrFail($store->user_id);

        Auth::login($user, true);

        return redirect()->route('dashboard');
    }
}
