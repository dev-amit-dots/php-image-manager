<?php
/**
 * Validation Functions
 * Secures the application by validating file uploads.
 */

require_once dirname(__DIR__) . '/config/config.php';

/**
 * Validates the uploaded file.
 * Returns an array with 'success' boolean and 'error' message if applicable.
 */
function validateImage($file) {
    // 1. Check for basic PHP upload errors
    if (!isset($file['error']) || is_array($file['error'])) {
        return ['success' => false, 'error' => 'Invalid parameters.'];
    }

    switch ($file['error']) {
        case UPLOAD_ERR_OK:
            break;
        case UPLOAD_ERR_NO_FILE:
            return ['success' => false, 'error' => 'No file sent.'];
        case UPLOAD_ERR_INI_SIZE:
        case UPLOAD_ERR_FORM_SIZE:
            return ['success' => false, 'error' => 'Exceeded filesize limit.'];
        default:
            return ['success' => false, 'error' => 'Unknown errors.'];
    }

    // 2. Check for empty file
    if ($file['size'] == 0) {
        return ['success' => false, 'error' => 'The uploaded file is empty.'];
    }

    // 3. Check filesize against our custom max size
    if ($file['size'] > MAX_UPLOAD_SIZE) {
        return ['success' => false, 'error' => 'File size exceeds the 5 MB limit.'];
    }

    // 4. Validate MIME type securely
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->file($file['tmp_name']);

    if (!array_key_exists($mimeType, ALLOWED_MIME_TYPES)) {
        return ['success' => false, 'error' => 'Invalid image format. Allowed formats: JPG, PNG, WebP.'];
    }

    // 5. Ensure it's an actual image via GD
    $imageInfo = @getimagesize($file['tmp_name']);
    if ($imageInfo === false) {
        return ['success' => false, 'error' => 'The file is a corrupted or fake image.'];
    }

    return [
        'success' => true,
        'extension' => ALLOWED_MIME_TYPES[$mimeType],
        'mime' => $mimeType
    ];
}
