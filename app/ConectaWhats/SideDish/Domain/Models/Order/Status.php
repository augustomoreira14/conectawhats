<?php

namespace App\ConectaWhats\SideDish\Domain\Models\Order;

use App\ConectaWhats\SideDish\Enum;
/**
 * Description of Status
 *
 * @author augus
 */
final class Status extends Enum
{
    const PENDING = 'pending';
    const CONTACTED = 'contacted';
    const FOLLOWUP = 'followup';
    const CONVERTED = 'converted';
}
