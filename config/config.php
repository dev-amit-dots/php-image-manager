<?php
/**
 * Configuration File
 * Contains application-wide constants and settings.
 */

// Define absolute path to project root
define('BASE_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);

// Directory paths
define('DIR_UPLOADS', BASE_PATH . 'uploads' . DIRECTORY_SEPARATOR);
define('DIR_OPTIMIZED', DIR_UPLOADS . 'optimized' . DIRECTORY_SEPARATOR);
define('DIR_WATERMARK', DIR_UPLOADS . 'watermark' . DIRECTORY_SEPARATOR);
define('DIR_ASSETS', BASE_PATH . 'assets' . DIRECTORY_SEPARATOR);
define('WATERMARK_FILE', DIR_ASSETS . 'watermark' . DIRECTORY_SEPARATOR . 'logo.png');

// File Upload Settings
define('MAX_UPLOAD_SIZE', 5 * 1024 * 1024); // 5 MB
define('ALLOWED_MIME_TYPES', [
    'image/jpeg' => 'jpg',
    'image/png'  => 'png',
    'image/webp' => 'webp'
]);

// Image Processing Settings
define('MAX_IMAGE_WIDTH', 1920); // Resize if wider than this
define('JPEG_QUALITY', 75); // Compression quality (0-100)

// Database Settings
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'images_db'); // We can assume they'll create this or use existing

// Default timezone
date_default_timezone_set('UTC');