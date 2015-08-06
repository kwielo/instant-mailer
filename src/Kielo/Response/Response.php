<?php

namespace Kielo\Response;

class Response
{
    public static function json(\Slim\Http\Response $response, array $body, $code = 200)
    {
        $response->setStatus($code);
        $response->header('Content-Type', 'application/json');
        $response->setBody(json_encode($body));
    }
}