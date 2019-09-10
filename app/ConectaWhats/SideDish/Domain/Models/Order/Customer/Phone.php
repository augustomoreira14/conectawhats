<?php

namespace App\ConectaWhats\SideDish\Domain\Models\Order\Customer;

use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumber;
use libphonenumber\PhoneNumberFormat;
/**
 * Description of Phone
 *
 * @author augus
 */
class Phone implements \JsonSerializable
{
    private $phoneNumber;
    /**
     *
     * @var PhoneNumber 
     */
    private $phone;
    
    public function __construct($phone, $country_code = null) 
    {
        $this->phoneNumber = PhoneNumberUtil::getInstance();
        $this->setPhone($phone, $country_code);
    }
    
    private function setPhone($phone, $country_code)
    {
        $this->phone = $this->phoneNumber->parse($phone, $country_code);
    }
    
    public function isValid()
    {
        return $this->phoneNumber->isValidNumber($this->phone);
    }
    
    public function __toString() 
    {
        return "{$this->phoneNumber->format($this->phone, PhoneNumberFormat::E164)}";
    }
    
    public function phoneStringFormated()
    {
        return "{$this->getCode()}{$this->getNumber()}";
    }
    
    public function getCode()
    {
        return $this->phone->getCountryCode();
    }
    
    public function getNumber()
    {
        return $this->phone->getNationalNumber();
    }

    public function jsonSerialize() 
    {
        return [
            'code' => $this->getCode(),
            'phone' => $this->getNumber(),
            'whatsapp' => $this->phoneStringFormated()
        ];
    }

}
