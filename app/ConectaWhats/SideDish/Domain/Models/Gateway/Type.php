<?php
/**
 * Created by PhpStorm.
 * User: augus
 * Date: 01/12/2018
 * Time: 10:14
 */

namespace App\ConectaWhats\SideDish\Domain\Models\Gateway;


use App\ConectaWhats\SideDish\Enum;

class Type extends Enum
{
    const MERCADO_PAGO = 'mercado_pago';
    const UPNID = 'Upnid Boleto';
    //const PAGSEGURO = 'pagseguro';

    public static function all()
    {
        $reflec = new \ReflectionClass(__CLASS__);
        return array_values($reflec->getConstants());
    }
}
