<?php

require('REST_Controller.php');
// require('../libraries/REST_Controller.php'); 

defined('BASEPATH') OR exit('No direct script access allowed');

class Api extends REST_Controller
{
	function user_get()
	// http://localhost/cistack/api/user/id/1
	// http://localhost/cistack/api/user/id/1/format/json -- Output JSON
	// http://localhost/cistack/api/user/id/1/format/xml  -- Output XML

    {
		$this->load->model('user', '', TRUE);

		if(!$this->get('id'))
        {
			$this->response(NULL, 400);
		}
		 
		$data = $this->user->get($this->get('id'));
         
        if($data)
        {
            $this->response($data, 200); // 200 being the HTTP response code
        }
         else
        {
            $this->response(NULL, 404);
        }
    }
     
    function user_post()
    {
        $result = $this->user_model->update( $this->post('id'), array(
            'name' => $this->post('name'),
            'email' => $this->post('email')
        ));
         
        if($result === FALSE)
        {
            $this->response(array('status' => 'failed'));
        }
         
        else
        {
            $this->response(array('status' => 'success'));
        }
         
    }
     
    function users_get()
    {
		
		// http://localhost/cistack/api/users
		
		$this->load->model('user', '', TRUE);
		$data['ci_user'] = $this->user->getList();
         
        if($data)
        {
            $this->response($data, 200);
        }
 
        else
        {
            $this->response(NULL, 404);
        }
    }

	function nomina_get()
    {
		
		// http://localhost/cistack/api/users
		
		$this->load->model('nomina', '', TRUE);
		$data['ci_nomina'] = $this->nomina->getList();
         
        if($data)
        {
            $this->response($data, 200);
        }
 
        else
        {
            $this->response(NULL, 404);
        }
    }


}
?>
