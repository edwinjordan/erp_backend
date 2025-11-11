<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * JWT Protected Controller
 * 
 * Base controller that requires valid JWT token for all requests.
 * Extend this controller to automatically protect your endpoints with JWT authentication.
 * 
 * Usage:
 *   class Your_Controller extends JWT_Protected_Controller {
 *       public function your_method() {
 *           // Access current user data via $this->current_user
 *           $user_id = $this->current_user['fv_userid'];
 *       }
 *   }
 */
class JWT_Protected_Controller extends MX_Controller
{
    /**
     * Current authenticated user data from JWT token
     * @var array|null
     */
    protected $current_user = null;

    /**
     * Decoded JWT token object
     * @var object|null
     */
    protected $decoded_token = null;

    /**
     * Whether to require authentication (can be overridden in child class)
     * @var bool
     */
    protected $require_auth = true;

    /**
     * Constructor - Validates JWT token before allowing access
     */
    public function __construct()
    {
        parent::__construct();
        
        // Load JWT library
        $this->load->library('JWT_Auth');
        
        // Validate JWT token if authentication is required
        if ($this->require_auth) {
            $this->_validate_jwt_token();
        }
    }

    /**
     * Validate JWT token from request header
     * 
     * @return void
     */
    private function _validate_jwt_token()
    {
        // Get and validate token
        $this->decoded_token = $this->jwt_auth->validate_token();
        
        if (!$this->decoded_token) {
            $this->_unauthorized_response('Invalid or expired token. Please login again.');
            return;
        }
        
        // Check if token is expired
        if ($this->jwt_auth->is_token_expired($this->decoded_token)) {
            $this->_unauthorized_response('Token has expired. Please refresh your token or login again.');
            return;
        }
        
        // Get user data from token
        $this->current_user = $this->jwt_auth->get_user_data($this->decoded_token);
        
        if (!$this->current_user) {
            $this->_unauthorized_response('Invalid token data. Please login again.');
            return;
        }
        
        // Optional: Log successful authentication
        log_message('debug', 'JWT Auth: User ' . ($this->current_user['fv_username'] ?? 'unknown') . ' authenticated successfully');
    }

    /**
     * Send unauthorized response and terminate execution
     * 
     * @param string $message Error message
     * @return void
     */
    protected function _unauthorized_response($message = 'Unauthorized access')
    {
        http_response_code(401);
        header('Content-Type: application/json');
        
        $response = array(
            'success' => false,
            'status' => 401,
            'message' => $message,
            'error' => 'Unauthorized'
        );
        
        die(json_encode($response));
    }

    /**
     * Send forbidden response (for insufficient permissions)
     * 
     * @param string $message Error message
     * @return void
     */
    protected function _forbidden_response($message = 'Forbidden - Insufficient permissions')
    {
        http_response_code(403);
        header('Content-Type: application/json');
        
        $response = array(
            'success' => false,
            'status' => 403,
            'message' => $message,
            'error' => 'Forbidden'
        );
        
        die(json_encode($response));
    }

    /**
     * Check if current user has specific permission
     * Override this method to implement your own permission logic
     * 
     * @param string $permission Permission to check
     * @return bool
     */
    protected function has_permission($permission)
    {
        // Default implementation - override in child class
        return true;
    }

    /**
     * Require specific permission or send forbidden response
     * 
     * @param string $permission Permission to check
     * @param string $message Custom error message
     * @return void
     */
    protected function require_permission($permission, $message = null)
    {
        if (!$this->has_permission($permission)) {
            $default_message = "You don't have permission to access this resource";
            $this->_forbidden_response($message ?: $default_message);
        }
    }

    /**
     * Get current user ID
     * 
     * @return string|null
     */
    protected function get_current_user_id()
    {
        return $this->current_user['fv_userid'] ?? null;
    }

    /**
     * Get current user username
     * 
     * @return string|null
     */
    protected function get_current_username()
    {
        return $this->current_user['fv_username'] ?? null;
    }

    /**
     * Get current user department ID
     * 
     * @return string|null
     */
    protected function get_current_department()
    {
        return $this->current_user['f_deptid'] ?? null;
    }

    /**
     * Get current user area
     * 
     * @return string|null
     */
    protected function get_current_area()
    {
        return $this->current_user['fc_kdarea'] ?? null;
    }

    /**
     * Get current user division
     * 
     * @return string|null
     */
    protected function get_current_division()
    {
        return $this->current_user['fc_kddivisi'] ?? null;
    }

    /**
     * Get specific user data field
     * 
     * @param string $field Field name
     * @return mixed|null
     */
    protected function get_user_data($field)
    {
        return $this->current_user[$field] ?? null;
    }

    /**
     * Check if user is authenticated
     * 
     * @return bool
     */
    protected function is_authenticated()
    {
        return $this->current_user !== null;
    }

    /**
     * Send success JSON response
     * 
     * @param mixed $data Response data
     * @param string $message Success message
     * @param int $status_code HTTP status code
     * @return void
     */
    protected function success_response($data, $message = 'Success', $status_code = 200)
    {
        http_response_code($status_code);
        header('Content-Type: application/json');
        
        $response = array(
            'success' => true,
            'status' => $status_code,
            'message' => $message,
            'data' => $data
        );
        
        die(json_encode($response));
    }

    /**
     * Send error JSON response
     * 
     * @param string $message Error message
     * @param int $status_code HTTP status code
     * @param mixed $errors Additional error details
     * @return void
     */
    protected function error_response($message = 'An error occurred', $status_code = 400, $errors = null)
    {
        http_response_code($status_code);
        header('Content-Type: application/json');
        
        $response = array(
            'success' => false,
            'status' => $status_code,
            'message' => $message
        );
        
        if ($errors !== null) {
            $response['errors'] = $errors;
        }
        
        die(json_encode($response));
    }
}
