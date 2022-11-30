<?php 
	
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
class PagesFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {   

    }
    
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
		if( session()->get( 'id_user' ) ){
			$request = \Config\Services::request();
    		$Permisos = session()->get( 'Modulos' );
			$dataSave = [];
				foreach ($Permisos as $key => $value) {
					$dataSave[] = substr($value[ 'urlmodulo' ], 1);
				}
				// $dataSave[] = "perfiluser";
			
			$dataSave[] = "";
    		$page = $request->uri->getSegment(1);
    		if( in_array( $page, $dataSave ) || in_array( $request->uri->getPath(), $dataSave )  ){
				
    		}
    		else{
    			return redirect()->to( base_url() );
    		}
    	}
    	else{
    		return redirect()->to( base_url()."/login" );
    	}
    }
}
 ?>