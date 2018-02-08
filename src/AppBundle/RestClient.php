<?php

namespace AppBundle\Services;

use Unirest;

class RestClient
{
    private $api_key;

    public function __construct($param)
    {
        # Reads api_key from parameters.yml
        $this->api_key = $param;
    }

    /*
     * @param string $name
     */
    public function get($name) {
        $query = array(
            'key' => $this->api_key,
            'address' => $name
        );
        $headers = array('Accept' => 'application/json');

        # Temporarily disables SSL cert validation
        Unirest\Request::verifyPeer(false);

        # Uses Unirest as a consumer for Google's RESTful API
        $response = Unirest\Request::get('https://maps.googleapis.com/maps/api/geocode/json', $headers, $query);

        return ($results = $response->body->results) ? $results[0]->place_id: null;
    }
}