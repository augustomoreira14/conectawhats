<?php

namespace App\ConectaWhats\SideDish;
/**
 * Description of ObjectValue
 *
 * @author augus
 */
abstract class ObjectValue implements \JsonSerializable, \Serializable
{
    
    public function __get($name) 
    {
        $refl = new \ReflectionObject($this);
        
        if($refl->hasProperty($name)){
            $property = $refl->getProperty($name);
            $property->setAccessible(true);
            
            return $property->getValue($this); 
        }             
        throw new \InvalidArgumentException("Property {$name} invalid.");
    }
    
    public function jsonSerialize() 
    {
        return $this->toArray();
    }

    public function toJson()
    {
        return json_encode($this);
    }
    
    public function toArray()
    {
        $refl = new \ReflectionObject($this);
        $array = [];
        foreach($refl->getProperties() as $property){
            $property->setAccessible(true);
            $array[$property->getName()] = $property->getValue($this);
        }
        
        return $array;
    }
    
    public function serialize() 
    {
        return serialize($this->toArray());
    }
    
    public function unserialize($serialized) 
    {
        $refl = new \ReflectionObject($this);
        $unserialized = unserialize($serialized);
        foreach($unserialized as $name => $value){
            $property = $refl->getProperty($name);
            $property->setAccessible(true);
            $property->setValue($this, $value);
        }
    }
}
