<?php

namespace App\ConectaWhats\SideDish\Infrastructure\Services\Gateway\Interfaces;
/**
 * Description of Gateway
 *
 * @author augus
 */
abstract class Gateway 
{
    protected $clienteId;
    protected $token;
    
    public function __construct($clienteId, $token) 
    {
        $this->clienteId = $clienteId;
        $this->token = $token;
    }

    abstract public function testConnection();

    abstract public function getLinkBoleto($reference_external);
}
