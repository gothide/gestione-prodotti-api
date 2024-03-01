<?php 

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class BasicAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!isset($_SERVER['PHP_AUTH_USER']) || !isset($_SERVER['PHP_AUTH_PW'])) {
            $response = service('response');
            $response->setStatusCode(401);
            $response->setHeader('WWW-Authenticate', 'Basic realm="Restricted Area"');
            return $response;
        }

        $username = $_SERVER['PHP_AUTH_USER'];
        $password = $_SERVER['PHP_AUTH_PW'];

        if ($username !== 'admin' || $password !== 'admin') {
            $response = service('response');
            $response->setStatusCode(401);
            $response->setHeader('WWW-Authenticate', 'Basic realm="Restricted Area"');
            return $response;
        }
        return $request;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        
    }
}