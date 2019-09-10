<?php
/**
 * Created by PhpStorm.
 * User: augus
 * Date: 01/12/2018
 * Time: 09:09
 */

namespace App\ConectaWhats\SideDish\Domain\Models\Message;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = "messages";
    protected $fillable = [
        'title', 'content', 'store_id', 'flow'
    ];
}