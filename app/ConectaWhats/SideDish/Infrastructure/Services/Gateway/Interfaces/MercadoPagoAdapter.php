<?php

namespace App\ConectaWhats\SideDish\Infrastructure\Services\Gateway\Interfaces;

use MP;

/**
 * Description of MercadoPago
 *
 * @author augus
 */
class MercadoPagoAdapter extends Gateway
{
    private $sdk;
    public function __construct($clienteId, $token) 
    {
        parent::__construct($clienteId, $token);
        $this->sdk = new MP($this->clienteId, $this->token);

    }
    
    public function getLinkBoleto($reference_external) 
    {
        $filters = [
            'external_reference' => $reference_external
        ];     
        
        $searchResult = $this->sdk->search_payment($filters, 0, 10);
        $results = $searchResult['response']['results'];
        
        if(!empty($results)){
            $itemDetails = $results[0]['transaction_details'];
            return $itemDetails['external_resource_url'];
        }
    }

    public function testConnection()
    {
        try{
            $this->sdk->get_access_token();
            return true;
        }catch (\Exception $ex){
            return false;
        }
    }
}
