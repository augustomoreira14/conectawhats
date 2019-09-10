<?php

namespace App\Http\Controllers\Dashboard;

use App\ConectaWhats\SideDish\Application\StoreHelper;
use App\ConectaWhats\SideDish\Domain\Models\Store\Store;
use App\Http\Controllers\Controller;
use http\Exception\InvalidArgumentException;
use Illuminate\Http\Request;
use App\ConectaWhats\SideDish\Domain\Models\Gateway\Gateway;
use App\ConectaWhats\SideDish\Domain\Models\Gateway\Type;
use App\ConectaWhats\SideDish\Domain\Models\Gateway\GatewayService;
/**
 * Description of GatewayController
 *
 * @author augus
 */
class GatewayController extends Controller
{
    public function index(Request $req)
    {
        $items = Gateway::where('store_id', StoreHelper::currentStoreId())->paginate(10);
        $types = Type::all();
        return view('dashboard.gateways.index', compact('items', 'types'));
    }
    
    public function store(Request $req)
    {
        $this->validate($req, [
            'type' => 'required',
            'cliente_id' => 'required',
            'token' => 'required'
        ]);

        try{
            $gateway = Gateway::where('store_id', StoreHelper::currentStoreId())->where('type', $req->type);
            if($gateway->count()){
                throw new \InvalidArgumentException("Este gateway já foi inserido.");
            }
            $gatewayService = new GatewayService();

            $gatewayService->createGateway(
                $req->type,
                $req->cliente_id,
                $req->token,
                StoreHelper::currentStoreId()
            );

            return redirect()->back()->with("message", "Cadastrado com sucesso.");

        }catch (\Exception $ex){
            return redirect()->back()->with("error", $ex->getMessage());
        }
    }
    
    public function destroy(Request $req, $id)
    {
        $item = Gateway::where('store_id', StoreHelper::currentStoreId())
                        ->where('id', $id)
                        ->firstOrFail();
        
        $item->delete();
        return redirect()->back()->with("message", "Deletado com sucesso.");
    }
}
