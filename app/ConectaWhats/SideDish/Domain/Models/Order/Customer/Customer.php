<?php

namespace App\ConectaWhats\SideDish\Domain\Models\Order\Customer;

use App\ConectaWhats\SideDish\Domain\Models\Order\Order;
use Illuminate\Database\Eloquent\Model;
use App\ConectaWhats\SideDish\Domain\Models\Store\Store;
/**
 * Description of Customer
 *
 * @author augus
 */
class Customer extends Model
{
    protected $table = 'customers';
    
    protected $fillable = [
        'name', 'phone', 'email', 'province_code', 'order_id',
        'zip_code', 'city', 'address'
    ];
    
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
    
    public function setPhoneAttribute(Phone $value)
    {  
        $this->attributes['phone'] = $value;
    }
    
    public function getPhoneAttribute($value)
    {
        return new Phone($value);
    }

}
