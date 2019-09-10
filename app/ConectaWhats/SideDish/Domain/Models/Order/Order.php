<?php

namespace App\ConectaWhats\SideDish\Domain\Models\Order;

use App\ConectaWhats\SideDish\Domain\Models\Order\Customer\Customer;
use App\ConectaWhats\SideDish\Domain\Models\Store\Store;
use Illuminate\Database\Eloquent\Model;
/**
 * Description of Order
 *
 * @author augus
 */
class Order extends Model
{
    protected $table = "orders";
    
    public $incrementing = false;

    protected $keyType = 'string';

    protected $fillable = [
        'id', 'gateway', 'link_checkout', 'checkout_id',
        'total', 'number', 'created_at', 'last_status_at',
        'followup_at', 'flow', 'store_id', 'note', 'status'
    ];

    protected $with = ['customer'];

    protected $dates = ['followup_at', 'created_at', 'last_status_at'];

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function customer()
    {
        return $this->hasOne(Customer::class);
    }

    public function setStatusAttribute($value)
    {
        $this->attributes['status'] = $value;
        $this->last_status_at = now();
    }

    public function isAbandonedCheckout()
    {
        return $this->flow == Flow::ABANDONED_CHECKOUT;
    }

    public function isPendingPayment()
    {
        return $this->flow == Flow::PENDING_PAYMENT;
    }

    public function isPaid()
    {
        return $this->flow == Flow::PAID;
    }

    public function pending()
    {
        if($this->status){
            throw new \Exception("Invalid set state");
        }
        $this->status = new Status(Status::PENDING);
    }

    public function followUp($date)
    {
        if($this->status == Status::CONVERTED){
            throw new \Exception("Invalid set state");
        }
        $this->followup_at = $date;
        $this->status = new Status(Status::FOLLOWUP);
    }

    public function contacted()
    {
        if($this->status == Status::CONVERTED){
            throw new \Exception("Invalid set state");
        }
        $this->status = new Status(Status::CONTACTED);
        $this->followup_at = null;
    }

    public function converted()
    {
        $this->status = Status::CONVERTED;
        $this->flow = Flow::PAID;
        $this->followup_at = null;
    }

    public function isConverted()
    {
        return $this->status == Status::CONVERTED;
    }
    
}
