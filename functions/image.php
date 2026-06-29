<?php
/**
 * Image Processing Functions
 * Handles resizing and compression using GD Library.
 */

require_once dirname(__DIR__) . '/config/config.php';

/**
 * Creates a GD image resource from a file based on its MIME type.
 */
function createImageResource($filePath, $mimeType) {
    switch ($mimeType) {
        case 'image/jpeg':
            return @imagecreatefromjpeg($filePath);
        case 'image/png':
            return @imagecreatefrompng($filePath);
        case 'image/webp':
            return @imagecreatefromwebp($filePath);
        default:
            return false;
    }
}

/**
 * Resizes an image if it exceeds MAX_IMAGE_WIDTH, maintaining aspect ratio.
 */
function resizeImage($imageResource, $originalWidth, $originalHeight) {
    if ($originalWidth <= MAX_IMAGE_WIDTH) {
        return $imageResource; // No resize needed
    }

    $newWidth = MAX_IMAGE_WIDTH;
    $newHeight = (int) (($originalHeight / $originalWidth) * $newWidth);

    $resizedImage = imagecreatetruecolor($newWidth, $newHeight);

    // Preserve transparency for PNG and WebP
    imagealphablending($resizedImage, false);
    imagesavealpha($resizedImage, true);
    $transparent = imagecolorallocatealpha($resizedImage, 255, 255, 255, 127);
    imagefilledrectangle($resizedImage, 0, 0, $newWidth, $newHeight, $transparent);

    // Perform resize
    imagecopyresampled(
        $resizedImage, $imageResource,
        0, 0, 0, 0,
        $newWidth, $newHeight,
        $originalWidth, $originalHeight
    );

    return $resizedImage;
}

/**
 * Saves the optimized image to the server.
 */
function saveImage($imageResource, $destination, $extension) {
    switch ($extension) {
        case 'jpg':
        case 'jpeg':
            return imagejpeg($imageResource, $destination, JPEG_QUALITY);
        case 'png':
            // PNG compression is 0 (no compression) to 9
            $pngQuality = round((100 - JPEG_QUALITY) / 100 * 9);
            return imagepng($imageResource, $destination, $pngQuality);
        case 'webp':
            return imagewebp($imageResource, $destination, JPEG_QUALITY);
        default:
            return false;
    }
}
