<?php

namespace App\ConectaWhats\SideDish\Application;

use App\ConectaWhats\SideDish\Domain\Models\Order\Order;
use Carbon\CarbonPeriod;
use Illuminate\Support\Facades\DB;
use App\ConectaWhats\SideDish\Domain\Models\Order\Status;
/**
 * Description of StatisticService
 *
 * @author augus
 */
class StatisticService 
{
    public static function orderQuery()
    {
        return Order::where('store_id', StoreHelper::currentStoreId());
    }

    public static function countConverteds($user_id)
    {
        $graphics = self::orderQuery()
                        ->select(DB::raw('DATE(last_status_at) date_only'), DB::raw('COUNT(status) as total'))
                        ->where('status', Status::CONVERTED)
                        ->whereBetween('last_status_at', [
                            now()->copy()->subDays(6)->toDateTimeString(),
                            now()->toDateTimeString()
                        ])
                        ->groupBy('status', 'date_only')
                        ->orderBy('date_only')->get();

        $total = self::orderQuery()
                    ->where(function ($q){
                        $q->where('status', Status::CONTACTED);
                        $q->orWhere('status', Status::FOLLOWUP);
                    })
                    ->whereBetween('created_at', [
                        now()->copy()->subDays(6)->toDateTimeString(),
                        now()->toDateTimeString()
                    ])->count();

        if($total == 0){
            $total = 1;
        }

        $items = [];
        foreach($graphics as $item){
            $items[$item['date_only']] = $item['total'];
        }

        $period = CarbonPeriod::create(now()->subDay(6), now());
        $data = [];
        foreach($period as $date){
            $dates[] = $date->format('d/m/Y');
            $key = $date->format('Y-m-d');
            $data[] = isset($items[$key]) ? $items[$key] : 0;
        }
        $data = collect($data);

        return [
            'data' => $data,
            'dates' => collect($dates),
            'percent' => (int)(($data->sum()/$total)*100)
        ];
    }
    
    
    public static function countStatusPerDay($user_id)
    {
        $graphics = Customer::select('status', DB::raw('DATE(created_at) date_only'), DB::raw('COUNT(status) as total'))
                            ->where('user_id', $user_id)
                            ->whereBetween('created_at', [
                                now()->copy()->subDays(7)->toDateTimeString(), 
                                now()->toDateTimeString()
                            ])->groupBy('status', 'date_only')
                            ->orderBy('date_only')->get();
      
        
        $period = CarbonPeriod::create(now()->subDay(6), now());

        $allStatus = ['pending' => [], 'followup' => [], 'converted' => []];
        
        $items = [];
        foreach($graphics as $item){
            $items[$item['status']][$item['date_only']] = $item['total'];
        }
        $dates = [];
        foreach($period as $date){
            $newKey = $date->format('Y-m-d');
            $dates[] = $date->format('d/m/Y');
            foreach($allStatus as $key => $status){
                $allStatus[$key][] = isset($items[$key][$newKey]) ? $items[$key][$newKey] : 0;
            }
        }
        
        return [
            'data' => $allStatus,
            'dates' => $dates
        ];
    }
}
