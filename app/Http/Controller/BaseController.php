<?php

namespace App\Http\Controller;

use Pho\Http\Controller;

abstract class BaseController extends Controller
{
    protected $json_data;

    protected function getJsonData(string $key = null, $default = null)
    {
        if ($this->json_data === null) {
            $contentType = $this->request->headers->get('Content-Type');
            if ($contentType === 'application/json') {
                $this->json_data = json_decode($this->request->getContent(), true);
            }
            if ($this->json_data === null) {
                $this->json_data = [];
            }
        }
        if ($key === null) {
            return $this->json_data;
        }
        return isset($this->json_data[$key]) ? $this->json_data[$key] : $default;
    }
}
