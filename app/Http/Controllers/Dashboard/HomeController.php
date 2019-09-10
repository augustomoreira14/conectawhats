<?php

namespace App\Http\Controllers\Dashboard;

use App\ConectaWhats\SideDish\Application\StoreHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\ConectaWhats\SideDish\Domain\Models\Order\Status;
use App\ConectaWhats\SideDish\Application\StatisticService;
use App\ConectaWhats\SideDish\Application\CustomerService;
use App\ConectaWhats\SideDish\Domain\Models\Order\Order;
/**
 * Description of HomeController
 *
 * @author augus
 */
class HomeController extends Controller
{
    public function index(Request $req)
    {
        $now = now();
        
        $totalPendings = CustomerService::totalPendings();
        $totalContacteds = CustomerService::totalContacteds();
        $totalFollowups = CustomerService::totalFollowup();
        $totalConverteds = CustomerService::totalConverteds();

        $totalConvertedsMonth = Order::where('store_id', StoreHelper::currentStoreId())
                                ->where('status', Status::CONVERTED)
                                ->whereBetween('last_status_at', [
                                    $now->copy()->firstOfMonth()->toDateTimeString(),
                                    $now->copy()->lastOfMonth()->toDateTimeString()
                                ])
                                ->sum('total');
       
        $statistics = StatisticService::countConverteds($req->user()->id);
        return view('dashboard.home', compact(
            'totalPendings',
            'totalContacteds',
            'totalFollowups', 
            'totalConverteds',
            'totalConvertedsMonth',
            'statistics'
        ));
    }
}
