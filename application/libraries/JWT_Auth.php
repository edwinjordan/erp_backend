<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

/**
 * JWT Authentication Library for CodeIgniter
 * 
 * This library provides JWT token generation and validation
 */
class JWT_Auth
{
    private $CI;
    private $secret_key;
    private $algorithm;
    private $token_expiration;
    private $refresh_token_expiration;

    public function __construct()
    {
        $this->CI =& get_instance();
        
        // Load JWT configuration
        $this->CI->load->config('jwt');
        
        $this->secret_key = $this->CI->config->item('jwt_secret_key');
        $this->algorithm = $this->CI->config->item('jwt_algorithm') ?: 'HS256';
        $this->token_expiration = $this->CI->config->item('jwt_token_expiration') ?: 3600; // 1 hour
        $this->refresh_token_expiration = $this->CI->config->item('jwt_refresh_token_expiration') ?: 604800; // 7 days
    }

    /**
     * Generate JWT token
     * 
     * @param array $user_data User data to encode in token
     * @param bool $is_refresh Whether this is a refresh token
     * @return string JWT token
     */
    public function generate_token($user_data, $is_refresh = false)
    {
        $issued_at = time();
        $expiration = $is_refresh ? $issued_at + $this->refresh_token_expiration : $issued_at + $this->token_expiration;
        
        $payload = array(
            'iat' => $issued_at,                    // Issued at: time when the token was generated
            'exp' => $expiration,                   // Expire time
            'nbf' => $issued_at,                    // Not before: token can't be used before this time
            'iss' => base_url(),                    // Issuer
            'data' => $user_data,                   // User data
            'type' => $is_refresh ? 'refresh' : 'access' // Token type
        );

        return JWT::encode($payload, $this->secret_key, $this->algorithm);
    }

    /**
     * Decode and validate JWT token
     * 
     * @param string $token JWT token to decode
     * @return object|false Decoded token data or false if invalid
     */
    public function decode_token($token)
    {
        try {
            $decoded = JWT::decode($token, new Key($this->secret_key, $this->algorithm));
            return $decoded;
        } catch (\Exception $e) {
            // Token is invalid or expired
            log_message('error', 'JWT Decode Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get token from request header
     * 
     * @return string|null Token or null if not found
     */
    public function get_token_from_header()
    {
        $headers = $this->CI->input->request_headers();
        
        // Check Authorization header
        if (isset($headers['Authorization'])) {
            $auth_header = $headers['Authorization'];
            // Extract token from "Bearer <token>"
            if (preg_match('/Bearer\s+(.*)$/i', $auth_header, $matches)) {
                return $matches[1];
            }
        }
        
        return null;
    }

    /**
     * Validate token from request header
     * 
     * @return object|false Decoded token data or false if invalid
     */
    public function validate_token()
    {
        $token = $this->get_token_from_header();
        
        if (!$token) {
            return false;
        }
        
        return $this->decode_token($token);
    }

    /**
     * Get user data from token
     * 
     * @param object $decoded_token Decoded token object
     * @return array|null User data or null
     */
    public function get_user_data($decoded_token)
    {
        if ($decoded_token && isset($decoded_token->data)) {
            return (array) $decoded_token->data;
        }
        
        return null;
    }

    /**
     * Check if token is expired
     * 
     * @param object $decoded_token Decoded token object
     * @return bool True if expired, false otherwise
     */
    public function is_token_expired($decoded_token)
    {
        if (!$decoded_token || !isset($decoded_token->exp)) {
            return true;
        }
        
        return time() >= $decoded_token->exp;
    }

    /**
     * Refresh access token using refresh token
     * 
     * @param string $refresh_token Refresh token
     * @return string|false New access token or false if invalid
     */
    public function refresh_access_token($refresh_token)
    {
        $decoded = $this->decode_token($refresh_token);
        
        if (!$decoded || !isset($decoded->type) || $decoded->type !== 'refresh') {
            return false;
        }
        
        if ($this->is_token_expired($decoded)) {
            return false;
        }
        
        $user_data = $this->get_user_data($decoded);
        
        if (!$user_data) {
            return false;
        }
        
        return $this->generate_token($user_data, false);
    }
}
