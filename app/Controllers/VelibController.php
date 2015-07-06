<?php  namespace Controllers;

use Services\Controller;
use \GuzzleHttp\Client;
use GuzzleHttp\EntityBody;

class VelibController extends Controller {

    public function index()
    {
        $client = new Client();
        $response = $client->get('https://api.jcdecaux.com/vls/v1/stations/10151?contract=paris&apiKey=878640cf9601b708dc67970dea8c8fc35e271123');
        $status = $response->getStatusCode();
        $response->getHeader('Content-type: application/json');

        if($status!=200) throw new \RuntimeException(sprintf('api jcdecaux service is busy'));

        return $response->getBody(true);
    }

}