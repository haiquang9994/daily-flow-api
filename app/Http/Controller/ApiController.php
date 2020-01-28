<?php

namespace App\Http\Controller;

use Exception;

abstract class ApiController extends BaseController
{
    /** Action */
    public function index()
    {
        $method = '___' . strtolower($this->request->getMethod());
        if (method_exists($this, $method)) {
            $result = call_user_func_array([$this, $method], []);
            return $this->json($result);
        }
        throw new Exception(sprintf('Method %s not found in controller [%s]', $method, get_class($this)));
    }
}
