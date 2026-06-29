<?php
/**
 * Upload Wrapper
 * Combines all processing steps into a single workflow.
 */

require_once __DIR__ . '/validation.php';
require_once __DIR__ . '/image.php';
require_once __DIR__ . '/watermark.php';
require_once __DIR__ . '/helper.php';

/**
 * Handles the full upload, optimize, and watermark process.
 */
function uploadImage($file, $dbConn) {
    // 1. Validate
    $validation = validateImage($file);
    if (!$validation['success']) {
        return ['success' => false, 'error' => $validation['error']];
    }

    $extension = $validation['extension'];
    $mimeType = $validation['mime'];

    // 2. Generate Name
    $filename = generateUniqueImageName($extension);
    
    $optimizedPath = DIR_OPTIMIZED . $filename;
    $watermarkPath = DIR_WATERMARK . $filename;

    // 3. Create Resource
    $imageResource = createImageResource($file['tmp_name'], $mimeType);
    if (!$imageResource) {
        return ['success' => false, 'error' => 'Failed to process image.'];
    }

    $originalWidth = imagesx($imageResource);
    $originalHeight = imagesy($imageResource);

    // 4. Resize and Compress -> Save Optimized
    $optimizedResource = resizeImage($imageResource, $originalWidth, $originalHeight);
    
    // Save Alpha channels correctly before saving
    if ($extension === 'png' || $extension === 'webp') {
        imagealphablending($optimizedResource, false);
        imagesavealpha($optimizedResource, true);
    }

    if (!saveImage($optimizedResource, $optimizedPath, $extension)) {
        imagedestroy($imageResource);
        if ($imageResource !== $optimizedResource) imagedestroy($optimizedResource);
        return ['success' => false, 'error' => 'Failed to save optimized image.'];
    }

    // 5. Apply Watermark -> Save Watermarked
    $optimizedWidth = imagesx($optimizedResource);
    $optimizedHeight = imagesy($optimizedResource);
    
    $watermarkedResource = applyWatermark($optimizedResource, $optimizedWidth, $optimizedHeight);
    
    if ($extension === 'png' || $extension === 'webp') {
        imagealphablending($watermarkedResource, false);
        imagesavealpha($watermarkedResource, true);
    }

    if (!saveImage($watermarkedResource, $watermarkPath, $extension)) {
        return ['success' => false, 'error' => 'Failed to save watermarked image.'];
    }

    // Clean up memory
    imagedestroy($imageResource);
    if ($imageResource !== $watermarkedResource) imagedestroy($watermarkedResource);

    // 6. Insert to DB
    // Get actual size of final optimized file (since we delete original)
    $finalSize = filesize($optimizedPath);
    
    $dbRelativeOptimized = 'uploads/optimized/' . $filename;
    $dbRelativeWatermark = 'uploads/watermark/' . $filename;

    $recordId = insertImageRecord($dbConn, $filename, $dbRelativeOptimized, $dbRelativeWatermark, $finalSize, $mimeType);

    if (!$recordId) {
        // Rollback files if DB fails
        deleteImage($optimizedPath);
        deleteImage($watermarkPath);
        return ['success' => false, 'error' => 'Database insertion failed.'];
    }

    return [
        'success' => true,
        'message' => 'Image processed and uploaded successfully.',
        'id' => $recordId,
        'optimized' => $dbRelativeOptimized,
        'watermark' => $dbRelativeWatermark
    ];
}