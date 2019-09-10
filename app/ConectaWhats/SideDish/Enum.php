<?php

namespace App\ConectaWhats\SideDish;

/**
 * Description of Enum
 *
 * @author augus
 */
abstract class Enum extends ObjectValue 
{
    protected $value;
    
    public function __construct($value) 
    {
        $this->setValue($value);
    }
    
    protected function setValue($value)
    {
        $this->value = $value;
    }
    
    public function __toString() 
    {
        return "$this->value";
    }
}
