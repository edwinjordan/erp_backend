<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| JWT Configuration
|--------------------------------------------------------------------------
| Configuration for JWT (JSON Web Token) authentication
|
*/

// Secret key for encoding/decoding JWT tokens
// IMPORTANT: Change this to a strong, random string in production!
$config['jwt_secret_key'] = 'your-secret-key-change-this-in-production-2025';

// Algorithm to use for JWT encoding
// Supported algorithms: HS256, HS384, HS512, RS256, RS384, RS512
$config['jwt_algorithm'] = 'HS256';

// Access token expiration time in seconds
// Default: 3600 seconds (1 hour)
$config['jwt_token_expiration'] = 3600;

// Refresh token expiration time in seconds
// Default: 604800 seconds (7 days)
$config['jwt_refresh_token_expiration'] = 604800;

// Token issuer (usually your application URL)
$config['jwt_issuer'] = base_url();

// Enable/disable token refresh
$config['jwt_enable_refresh_token'] = true;
