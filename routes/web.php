<?php

//Route::get('/teste', function(){
//    $store = \App\ConectaWhats\SideDish\Domain\Models\Store\Store::find(2);
//    $shopify = \Oseintow\Shopify\Facades\Shopify::setShopUrl($store->shop)
//        ->setAccessToken($store->token);
//    dd($store, $shopify->get('/admin/webhooks.json'));
//    //dd();
//});

Route::post('/guru', function(\Illuminate\Http\Request $req){
    $data = $req->all();

    file_put_contents('~/public/file.json', json_encode($data));

    return response('Thank you!', 200);

});

Route::group(['namespace' => 'Auth'], function(){
    Route::get('login', 'LoginController@showLoginForm')->name('login');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout')->name('logout');
});

Route::group(['namespace' => 'InstallStore'], function(){
    Route::get('install-start', 'ShopifyController@index')->name('install.start');
    Route::post('install-start', 'ShopifyController@redirectToInstall');
    Route::get('accept-charge', 'ShopifyController@installCharge')->name('install.charge')->middleware('shopify.request');
    Route::get('accepted-charge', 'ShopifyController@installApp')->name('accepted.charge');
    Route::get('access-app', 'ShopifyController@accessApp')->middleware('shopify.request');
});

Route::post('/notify-shopify', 'Notification\ShopifyWebHookController@handle')->name('shopify.notify');

Route::group(['middleware' => ['auth'], 'namespace' => 'Dashboard'], function(){

    Route::get("/new", function(\Illuminate\Http\Request $req){
        $store = \App\ConectaWhats\SideDish\Domain\Models\Store\Store::where('user_id', $req->user()->id)->firstOrFail();
        $shop = \App\ConectaWhats\SideDish\Infrastructure\Services\ShopFactory::factory($store);

        //$url = $store->shop;
        //$token = $store->token;
        $order_id = "695154049088"; //695154049088
        //$shopify = \App\ConectaWhats\SideDish\Infrastructure\Services\Shopify\ShopifyAdapter::getInstance($url, $token);

        dd(\App\ConectaWhats\SideDish\Infrastructure\Services\Delivery\TrackCodeService::getInstance()->getCode($order_id));
    });

    Route::get('redirect_shopify/{id}', function(Illuminate\Http\Request $req, $id){
        $order = \App\ConectaWhats\SideDish\Domain\Models\Order\Order::findOrFail($id);
        if($order->isAbandonedCheckout()){
            $uri = "https://{$order->store->shop}/admin/checkouts/{$order->id}";
        }else{
            $uri = "https://{$order->store->shop}/admin/orders/{$order->id}";
        }

        return redirect()->to($uri);
    })->name('redirect_shopify');

    Route::get('/profile', 'ProfileController@index')->name('profile.index');
    Route::put('/profile', 'ProfileController@update')->name('profile.update');
    Route::get('/profile/update-password', 'ProfileController@updatePasswordView')->name('profile.password');
    Route::put('/profile/update-password', 'ProfileController@updatePassword')->name('profile.password.update');

    Route::get('/', 'HomeController@index')->name('dashboard');
    Route::delete('/customer/destroy-many', 'CustomerController@destroyMany')->name('customer.destroyMany');
    Route::put('/customer/{id}', 'CustomerController@update')->name('customer.update');
    Route::delete('/customer/{id}', 'CustomerController@destroy')->name('customer.destroy');
    Route::put('/customer/{id}/contacted', 'CustomerController@contacted')->name('customer.contacted');

    Route::resource('/messages', "MessageController");
    Route::get('/api/messages', "MessageController@getMessages");
    Route::get('/api/messages_processeds', "ProcessMessageController@messagesProcesseds");

    Route::resource('/gateways', "GatewayController");

    Route::get('/pendings', 'CustomerController@pendings')->name('pendings');
    Route::get('/contacteds', 'CustomerController@contacteds')->name('contacteds');
    Route::get('/followup', 'CustomerController@followup')->name('followup');
    Route::get('/converteds', 'CustomerController@converteds')->name('converteds');

});