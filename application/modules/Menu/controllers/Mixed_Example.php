<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Restserver\Libraries\REST_Controller;

require APPPATH . 'libraries/REST_Controller.php';
require APPPATH . 'traits/JWT_Authentication.php';

/**
 * Example Mixed API Controller
 * 
 * This controller demonstrates selective JWT authentication:
 * - Some endpoints are public (no JWT required)
 * - Some endpoints are protected (JWT required)
 */
class Mixed_Example extends REST_Controller {
    
    use JWT_Authentication;

    public function __construct()
    {
        parent::__construct();
        
        // Set CORS headers
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
        
        if ($this->input->method() === 'options') {
            exit();
        }
        
        // Note: We DON'T call authenticate_jwt() in constructor
        // We'll call it selectively in methods that need protection
    }

    /**
     * GET: Public endpoint - No JWT required
     * URL: /mixed_example/public
     */
    public function public_get()
    {
        $this->response([
            'status' => true,
            'message' => 'This is a public endpoint',
            'data' => [
                'info' => 'Anyone can access this without authentication',
                'timestamp' => date('Y-m-d H:i:s')
            ]
        ], REST_Controller::HTTP_OK);
    }

    /**
     * GET: Protected endpoint - JWT required
     * URL: /mixed_example/protected
     * Header: Authorization: Bearer <token>
     */
    public function protected_get()
    {
        // Require authentication for this method only
        $this->authenticate_jwt();
        
        $this->response([
            'status' => true,
            'message' => 'This is a protected endpoint',
            'data' => [
                'info' => 'Only authenticated users can access this',
                'user' => $this->current_user,
                'timestamp' => date('Y-m-d H:i:s')
            ]
        ], REST_Controller::HTTP_OK);
    }

    /**
     * GET: Another protected endpoint
     * URL: /mixed_example/user_data
     * Header: Authorization: Bearer <token>
     */
    public function user_data_get()
    {
        // Require authentication
        $this->authenticate_jwt();
        
        $this->response([
            'status' => true,
            'message' => 'User data retrieved',
            'data' => [
                'user_id' => $this->jwt_get_user_id(),
                'username' => $this->jwt_get_username(),
                'department' => $this->jwt_get_department(),
                'area' => $this->jwt_get_area(),
                'division' => $this->jwt_get_division()
            ]
        ], REST_Controller::HTTP_OK);
    }

    /**
     * GET: Optional authentication endpoint
     * Returns different data based on authentication status
     * URL: /mixed_example/optional
     * Header: Authorization: Bearer <token> (optional)
     */
    public function optional_get()
    {
        // Try to authenticate, but don't require it
        $is_authenticated = $this->authenticate_jwt(false);
        
        if ($is_authenticated) {
            // User is authenticated
            $this->response([
                'status' => true,
                'message' => 'You are authenticated',
                'authenticated' => true,
                'user' => $this->current_user
            ], REST_Controller::HTTP_OK);
        } else {
            // User is not authenticated
            $this->response([
                'status' => true,
                'message' => 'You are not authenticated (anonymous access)',
                'authenticated' => false,
                'info' => 'Login to see personalized content'
            ], REST_Controller::HTTP_OK);
        }
    }
}
