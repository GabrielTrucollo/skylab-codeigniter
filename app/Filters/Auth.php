<?php namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Auth implements FilterInterface{

    public function before($request, $arguments = null)
    {
        if(session()->get('logged_in') != true){
            return redirect()->to('user/login');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // TODO: Implement after() method.
    }
}
