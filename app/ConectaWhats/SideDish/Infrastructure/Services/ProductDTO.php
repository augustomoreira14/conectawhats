<?php
/**
 * Created by PhpStorm.
 * User: augus
 * Date: 26/11/2018
 * Time: 23:04
 */

namespace App\ConectaWhats\SideDish\Infrastructure\Services;


use App\ConectaWhats\SideDish\ObjectValue;

class ProductDTO extends ObjectValue
{
    private $id;
    private $title;
    private $image;

    public function __construct($id, $title, $image)
    {
        $this->id = $id;
        $this->title = $title;
        $this->image = $image;
    }
}