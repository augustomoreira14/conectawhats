<?php
/**
 * Created by PhpStorm.
 * User: augus
 * Date: 30/11/2018
 * Time: 10:44
 */

namespace App\ConectaWhats\SideDish\Application;

use App\ConectaWhats\SideDish\Domain\Models\Order\Order;
use App\ConectaWhats\SideDish\Domain\Models\Order\Status;
use Illuminate\Database\Console\Migrations\StatusCommand;

class CustomerService
{
    protected static function orderQuery()
    {
        return Order::where('store_id', StoreHelper::currentStoreId());
    }

    public static function totalPendings()
    {
        return self::orderQuery()->where('status', Status::PENDING)->count();
    }

    public static function totalContacteds()
    {
        return self::orderQuery()->where('status', Status::CONTACTED)->count();
    }

    public static function totalFollowup()
    {
        return self::orderQuery()->where('status', Status::FOLLOWUP)->count();
    }

    public static function totalConverteds()
    {
        return self::orderQuery()->where('status', Status::CONVERTED)->count();
    }
}