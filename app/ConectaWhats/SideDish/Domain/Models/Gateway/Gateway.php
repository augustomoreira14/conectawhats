<?php
/**
 * Created by PhpStorm.
 * User: augus
 * Date: 01/12/2018
 * Time: 10:12
 */

namespace App\ConectaWhats\SideDish\Domain\Models\Gateway;

use Illuminate\Database\Eloquent\Model;

class Gateway extends Model
{
    protected $table = 'gateways';
    protected $fillable = [
        'type', 'cliente_id', 'token', 'store_id'
    ];
}