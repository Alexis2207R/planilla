<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class SessionFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {   
        // if( !session()->get( 'id_user' ) ){
        //     return redirect()->to( base_url()."/login" );
        // }
    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        if( !session()->get( 'id_user' ) ){
            return redirect()->to( base_url()."/login" );
        }
        else{
            return redirect()->to( base_url() );
        }
    }
}