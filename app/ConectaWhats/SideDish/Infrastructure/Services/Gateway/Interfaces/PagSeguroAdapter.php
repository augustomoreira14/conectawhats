<?php

namespace App\ConectaWhats\SideDish\Infrastructure\Services\Gateway\Interfaces;
/**
 * Description of PagSeguro
 *
 * @author augus
 */
class PagSeguroAdapter extends Gateway
{
    public function __construct($clienteId, $token)
    {
        //parent::__construct($clienteId, $token);
    }

    public function getLinkBoleto($reference_external)
    {
    }

    public function testConnection()
    {
        // TODO: Implement testConnection() method.
    }
}
