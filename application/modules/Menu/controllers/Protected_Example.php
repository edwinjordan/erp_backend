<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'traits/JWT_Authentication.php';

/**
 * Example Protected API Controller
 * 
 * This controller demonstrates how to use JWT authentication middleware
 * to protect API endpoints.
 */
class Protected_Example extends REST_Controller {
    
    use JWT_Authentication;

    public function __construct()
    {
        parent::__construct();
        
        // Authenticate JWT for all methods
        // This will check token and populate $this->current_user
        $this->authenticate_jwt();
        
        // Set CORS headers
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        
        if ($this->input->method() === 'options') {
            exit();
        }
    }

    /**
     * GET: Test protected endpoint
     * URL: /protected_example/test
     * Header: Authorization: Bearer <token>
     */
    public function test_get()
    {
        $this->response([
            'status' => true,
            'message' => 'Protected endpoint accessed successfully',
            'user' => $this->current_user,
            'timestamp' => date('Y-m-d H:i:s')
        ], REST_Controller::HTTP_OK);
    }

    /**
     * GET: Get user profile
     * URL: /protected_example/profile
     * Header: Authorization: Bearer <token>
     */
    public function profile_get()
    {
        $user_id = $this->jwt_get_user_id();
        $username = $this->jwt_get_username();
        $department = $this->jwt_get_department();
        
        $this->response([
            'status' => true,
            'message' => 'User profile retrieved',
            'data' => [
                'user_id' => $user_id,
                'username' => $username,
                'department' => $department,
                'full_user_data' => $this->current_user
            ]
        ], REST_Controller::HTTP_OK);
    }

    /**
     * POST: Create something (example)
     * URL: /protected_example/create
     * Header: Authorization: Bearer <token>
     */
    public function create_post()
    {
        $name = $this->post('name');
        $description = $this->post('description');
        
        // Get current user for audit trail
        $created_by = $this->jwt_get_user_id();
        
        // Your business logic here
        $data = [
            'name' => $name,
            'description' => $description,
            'created_by' => $created_by,
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $this->response([
            'status' => true,
            'message' => 'Data created successfully',
            'data' => $data
        ], REST_Controller::HTTP_CREATED);
    }
}
