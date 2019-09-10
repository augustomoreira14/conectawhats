<?php
/**
 * Created by PhpStorm.
 * User: augus
 * Date: 30/11/2018
 * Time: 11:40
 */

namespace App\ConectaWhats\SideDish\Application;

use Illuminate\Support\Facades\Auth;
use App\ConectaWhats\SideDish\Domain\Models\Store\Store;

class StoreHelper
{
    public static function currentStoreId()
    {
        $user_id = Auth::user()->id;
        $store = Store::where('user_id', $user_id)->firstOrFail();

        return $store->id;
    }

    public static function getCurrentStore()
    {
        $user_id = Auth::user()->id;
        $store = Store::where('user_id', $user_id)->firstOrFail();

        return $store;
    }
}