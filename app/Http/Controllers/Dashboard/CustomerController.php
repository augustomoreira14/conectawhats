<?php

namespace App\Http\Controllers\Dashboard;

use App\ConectaWhats\SideDish\Application\StoreHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ConectaWhats\SideDish\Domain\Models\Order\Order;
use App\ConectaWhats\SideDish\Domain\Models\Order\Status;
use App\ConectaWhats\SideDish\Application\OrderSearchService;
use App\ConectaWhats\SideDish\Domain\Models\Order\Flow;
use App\ConectaWhats\SideDish\Domain\Models\Order\Customer\Phone;
/**
 * Description of CustomerController
 *
 * @author augus
 */
class CustomerController extends Controller
{
    public function contacted(Request $req, $id)
    {
        try {
            $customer = Order::where('id', $id)
                                ->where('store_id', StoreHelper::currentStoreId())
                                ->firstOrFail();
            
            if($customer->status != Status::CONVERTED){
                $customer->contacted();
                $customer->saveOrFail();
            }         
            
            return redirect()->back()->with('message', 'Movido para Contactados');
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', 'Occoreu um problema. Tente novamente.');
        }    
    }
    
    public function update(Request $req, $id)
    {
        $this->validate($req, [
            'note' => 'nullable|string',
            'phone' => 'required',
            'date' => 'nullable|date'
        ]);

        $order = Order::findOrFail($id);
        $order->note = $req->note;

        try {
            $order->customer->phone = new Phone($req->phone);
        } catch (\Exception $ex) {
            return redirect()->back()->with('error', 'WhatsApp Inválido');
        }


        if ($req->date) {
            return $this->toFollowUp($order, $req->date);
        }

        $order->push();

        return redirect()->back()->with('message', 'Atualizado com sucesso');
    }

    protected function toFollowUp(Order $order, $date)
    {
        $order->followUp($date);
        $order->push();
        return redirect()->back()->with('message', 'Movido para Follow Up');
    }

    public function destroy(Request $req, $id)
    {
        $item = Order::where('store_id', StoreHelper::currentStoreId())
                        ->where('id', $id)
                        ->firstOrFail();
        
        $item->delete();
           
        return redirect()->back()->with('message', 'Cliente descartado');
    }

    public function destroyMany(Request $req)
    {
        $this->validate($req,[
            'ids' => 'array|required'
        ]);

        Order::where('store_id', StoreHelper::currentStoreId())
            ->whereIn('id', $req->ids)
            ->delete();

        return redirect()->back()->with('message', 'Clientes descartados');
    }

    public function pendings(Request $req)
    {
        $search = new OrderSearchService();
        $query = $search->filterStatus(Status::PENDING)
                        ->filterFlow($req->flow)
                        ->filterKeyWord($req->key_word)
                        ->filterDateInterval($req->date_init, $req->date_final)
                        ->getQuery();
        
        $items = $query->with('products')->orderBy('created_at', 'DESC')->paginate(15);

        $title = __('titles.pendings');
        
        return view('dashboard.customers.index', compact('items', 'title'));
    }
    
    public function contacteds(Request $req)
    {
        $search = new OrderSearchService();
        $query = $search->filterStatus(Status::CONTACTED)
                        ->filterFlow($req->flow)
                        ->filterKeyWord($req->key_word)
                        ->filterDateInterval($req->date_init, $req->date_final)
                        ->getQuery();
        
        $items = $query->with('products')->orderBy('created_at', 'DESC')->paginate(15);
        $flows = Flow::all();
        $title = __('titles.contacteds');
        
        return view('dashboard.customers.contacteds', compact('items', 'title', 'flows'));
    }

    public function followup(Request $req)
    {
        $search = new OrderSearchService();
        $query = $search->filterStatus(Status::FOLLOWUP)
                        ->filterFlow($req->flow)
                        ->filterKeyWord($req->key_word)
                        ->filterDateInterval($req->date_init, $req->date_final)
                        ->getQuery();
        
        $items = $query->with('products')->orderBy('followup_at', 'ASC')->paginate(15);
        $title = __('titles.followup');
        
        return view('dashboard.customers.followup', compact('items', 'title'));
    }

    public function converteds(Request $req)
    {
        $search = new OrderSearchService();
        $query = $search->filterStatus(Status::CONVERTED)
                        ->filterFlow($req->flow)
                        ->filterKeyWord($req->key_word)
                        ->filterDateInterval($req->date_init, $req->date_final)
                        ->getQuery();
        
        $items = $query->with('products')->orderBy('last_status_at', 'DESC')->paginate(15);
        $title = __('titles.converteds');
        
        return view('dashboard.customers.index', compact('items', 'title'));
    }
}
