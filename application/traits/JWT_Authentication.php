<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * JWT Authentication Trait
 * 
 * Use this trait in any controller (including REST_Controller) to add JWT authentication.
 * This provides a flexible way to protect endpoints without extending a specific base class.
 * 
 * Usage:
 *   class Your_Controller extends REST_Controller {
 *       use JWT_Authentication;
 *       
 *       public function __construct() {
 *           parent::__construct();
 *           $this->authenticate_jwt(); // Call this to require JWT auth
 *       }
 *       
 *       public function your_method_get() {
 *           $user_id = $this->current_user['fv_userid'];
 *           // Your code here
 *       }
 *   }
 */
trait JWT_Authentication
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
     * JWT Auth library instance
     * @var JWT_Auth|null
     */
    protected $jwt_auth_instance = null;

    /**
     * Authenticate request using JWT token
     * Call this method in your constructor or specific methods to require authentication
     * 
     * @param bool $required Whether authentication is required (default: true)
     * @return bool True if authenticated, false otherwise
     */
    protected function authenticate_jwt($required = true)
    {
        // Load JWT library if not already loaded
        if (!$this->jwt_auth_instance) {
            // Check if CodeIgniter instance is available
            if (!isset($this->load)) {
                log_message('error', 'JWT Auth: CodeIgniter instance not available');
                if ($required) {
                    $this->jwt_unauthorized('Authentication system error');
                }
                return false;
            }
            
            $this->load->library('JWT_Auth');
            $this->jwt_auth_instance = $this->jwt_auth;
        }
        
        // Validate token
        $this->decoded_token = $this->jwt_auth_instance->validate_token();
        
        if (!$this->decoded_token) {
            if ($required) {
                $this->jwt_unauthorized('Invalid or expired token. Please login again.');
            }
            return false;
        }
        
        // Check if token is expired
        if ($this->jwt_auth_instance->is_token_expired($this->decoded_token)) {
            if ($required) {
                $this->jwt_unauthorized('Token has expired. Please refresh your token or login again.');
            }
            return false;
        }
        
        // Get user data from token
        $this->current_user = $this->jwt_auth_instance->get_user_data($this->decoded_token);
        
        if (!$this->current_user) {
            if ($required) {
                $this->jwt_unauthorized('Invalid token data. Please login again.');
            }
            return false;
        }
        
        // Log successful authentication
        log_message('debug', 'JWT Auth: User ' . ($this->current_user['fv_username'] ?? 'unknown') . ' authenticated successfully');
        
        return true;
    }

    /**
     * Send unauthorized response
     * Works with both REST_Controller and regular controllers
     * 
     * @param string $message Error message
     * @return void
     */
    protected function jwt_unauthorized($message = 'Unauthorized access')
    {
        // Check if this is a REST_Controller
        if (method_exists($this, 'response')) {
            // REST_Controller response
            $this->response([
                'success' => false,
                'status' => 401,
                'message' => $message,
                'error' => 'Unauthorized'
            ], 401); // REST_Controller::HTTP_UNAUTHORIZED
        } else {
            // Standard JSON response
            http_response_code(401);
            header('Content-Type: application/json');
            die(json_encode([
                'success' => false,
                'status' => 401,
                'message' => $message,
                'error' => 'Unauthorized'
            ]));
        }
    }

    /**
     * Send forbidden response
     * 
     * @param string $message Error message
     * @return void
     */
    protected function jwt_forbidden($message = 'Forbidden - Insufficient permissions')
    {
        // Check if this is a REST_Controller
        if (method_exists($this, 'response')) {
            $this->response([
                'success' => false,
                'status' => 403,
                'message' => $message,
                'error' => 'Forbidden'
            ], 403); // REST_Controller::HTTP_FORBIDDEN
        } else {
            http_response_code(403);
            header('Content-Type: application/json');
            die(json_encode([
                'success' => false,
                'status' => 403,
                'message' => $message,
                'error' => 'Forbidden'
            ]));
        }
    }

    /**
     * Check if current user has specific permission
     * Override this method to implement your own permission logic
     * 
     * @param string $permission Permission to check
     * @return bool
     */
    protected function jwt_has_permission($permission)
    {
        // Default implementation - always return true
        // Override this method in your controller for custom permission logic
        return true;
    }

    /**
     * Require specific permission or send forbidden response
     * 
     * @param string $permission Permission to check
     * @param string $message Custom error message
     * @return void
     */
    protected function jwt_require_permission($permission, $message = null)
    {
        if (!$this->jwt_has_permission($permission)) {
            $default_message = "You don't have permission to access this resource";
            $this->jwt_forbidden($message ?: $default_message);
        }
    }

    /**
     * Get current user ID
     * 
     * @return string|null
     */
    protected function jwt_get_user_id()
    {
        return $this->current_user['fv_userid'] ?? null;
    }

    /**
     * Get current user username
     * 
     * @return string|null
     */
    protected function jwt_get_username()
    {
        return $this->current_user['fv_username'] ?? null;
    }

    /**
     * Get current user department ID
     * 
     * @return string|null
     */
    protected function jwt_get_department()
    {
        return $this->current_user['f_deptid'] ?? null;
    }

    /**
     * Get current user area
     * 
     * @return string|null
     */
    protected function jwt_get_area()
    {
        return $this->current_user['fc_kdarea'] ?? null;
    }

    /**
     * Get current user division
     * 
     * @return string|null
     */
    protected function jwt_get_division()
    {
        return $this->current_user['fc_kddivisi'] ?? null;
    }

    /**
     * Get specific user data field
     * 
     * @param string $field Field name
     * @return mixed|null
     */
    protected function jwt_get_user_data($field)
    {
        return $this->current_user[$field] ?? null;
    }

    /**
     * Check if user is authenticated
     * 
     * @return bool
     */
    protected function jwt_is_authenticated()
    {
        return $this->current_user !== null;
    }

    /**
     * Get all current user data
     * 
     * @return array|null
     */
    protected function jwt_get_current_user()
    {
        return $this->current_user;
    }

    /**
     * Optional: Authenticate only for specific methods
     * 
     * @param array $methods Array of method names that require authentication
     * @param string $current_method Current method being called
     * @return bool
     */
    protected function jwt_authenticate_for_methods($methods, $current_method = null)
    {
        if ($current_method === null) {
            // Try to detect current method
            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
            $current_method = $backtrace[1]['function'] ?? null;
        }
        
        if ($current_method && in_array($current_method, $methods)) {
            return $this->authenticate_jwt(true);
        }
        
        return true;
    }

    /**
     * Optional: Authenticate except for specific methods (whitelist)
     * 
     * @param array $methods Array of method names that DON'T require authentication
     * @param string $current_method Current method being called
     * @return bool
     */
    protected function jwt_authenticate_except_methods($methods, $current_method = null)
    {
        if ($current_method === null) {
            // Try to detect current method
            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
            $current_method = $backtrace[1]['function'] ?? null;
        }
        
        if ($current_method && !in_array($current_method, $methods)) {
            return $this->authenticate_jwt(true);
        }
        
        return true;
    }
}
