<?php

namespace App\ConectaWhats\SideDish\Domain\Models\Order;

use App\ConectaWhats\SideDish\Enum;
/**
 * Description of Flow
 *
 * @author augus
 */
final class Flow extends Enum
{
    const ABANDONED_CHECKOUT = 'abandoned_checkout';
    const PENDING_PAYMENT = 'pending_payment';
    const PAID = 'paid';

    public function __construct($value)
    {
        parent::__construct($value);
    }

    public static function all()
    {
        $reflec = new \ReflectionClass(__CLASS__);
        return array_values($reflec->getConstants());
    }

}
