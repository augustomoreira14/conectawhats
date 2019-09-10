<?php

namespace App\ConectaWhats\SideDish\Domain\Models\Order;

use Illuminate\Database\Eloquent\Model;
/**
 * Description of Product
 *
 * @author augus
 */
class Product extends Model
{
    protected $table = 'products';
    
    protected $fillable = [
        'title', 'image', 'order_id'
    ];
    
    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
