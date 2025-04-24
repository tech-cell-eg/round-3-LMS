<?php

namespace App\Services;

use GuzzleHttp\Client;
use Illuminate\Http\Request;

class FatoorahService
{
    private $base_url;
    private $headers;
    private $request_client;

    public function __construct(Client $request_client)
    {
        $this->request_client = $request_client;
        $this->base_url = config('fatoorah.base_url');
        $this->headers = [
            'content-type' => 'application/json',
            'authorization' => 'Bearer ' . config('fatoorah.api_key'),
        ];
    }

    public function buildRequest($uri, $method, $body = [])
    {
        $request = new Request($method, $this->base_url . $uri, $this->headers);
        if(!$body) {
            return false;
        }
    }
}
