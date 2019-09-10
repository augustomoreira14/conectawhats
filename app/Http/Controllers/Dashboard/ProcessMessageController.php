<?php

namespace App\Http\Controllers\Dashboard;

use App\ConectaWhats\SideDish\Application\StoreHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ConectaWhats\SideDish\Domain\Models\Message\Message;
use App\ConectaWhats\SideDish\Domain\Models\Order\Order;
use App\ConectaWhats\SideDish\Domain\Models\Message\ProcessMessageService;
/**
 * Description of ProcessMessageController
 *
 * @author augus
 */
class ProcessMessageController extends Controller
{
    public function messagesProcesseds(Request $req)
    {
        $this->validate($req, [
            'order' => 'required',
            'flow' => 'required',
        ]);

        $messages = Message::where('store_id', StoreHelper::currentStoreId())
                            ->where('flow', $req->flow)
                            ->get();

        $order = Order::where('store_id', StoreHelper::currentStoreId())
                              ->where('id', $req->order)
                              ->firstOrFail();
        
        $service = new ProcessMessageService($order);
        
        $messageProcesseds = $service->processMany($messages);

        return response()->json($messageProcesseds);        
    }
}
