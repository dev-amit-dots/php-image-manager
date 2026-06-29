<?php
/**
 * Watermark Functions
 * Applies a transparent PNG watermark or text fallback to an image.
 */

require_once dirname(__DIR__) . '/config/config.php';

/**
 * Applies the logo watermark to the bottom right of the image.
 * If the logo doesn't exist, it applies a fallback text watermark.
 */
function applyWatermark($sourceImageResource, $imageWidth, $imageHeight) {
    $fallbackText = "dev-amit-tiwari";
    
    // Check if file exists and can be created
    if (!file_exists(WATERMARK_FILE) || !($watermark = @imagecreatefrompng(WATERMARK_FILE))) {
        // --- Fallback Text Watermark Logic ---
        $margin = 20;
        $fontSize = 5; // Built-in font size (1-5)
        
        // Calculate text dimensions
        $textWidth = imagefontwidth($fontSize) * strlen($fallbackText);
        $textHeight = imagefontheight($fontSize);
        
        $destX = $imageWidth - $textWidth - $margin;
        $destY = $imageHeight - $textHeight - $margin;
        
        // Ensure image supports alpha for the background overlay
        imagealphablending($sourceImageResource, true);
        
        // Add a semi-transparent dark background block behind text for readability
        $bgColor = imagecolorallocatealpha($sourceImageResource, 0, 0, 0, 80); // Dark background with some transparency
        imagefilledrectangle($sourceImageResource, $destX - 10, $destY - 10, $destX + $textWidth + 10, $destY + $textHeight + 10, $bgColor);
        
        // Add the white text
        $textColor = imagecolorallocate($sourceImageResource, 255, 255, 255);
        imagestring($sourceImageResource, $fontSize, $destX, $destY, $fallbackText, $textColor);
        
        return $sourceImageResource;
    }

    // --- Image Watermark Logic ---
    $watermarkWidth = imagesx($watermark);
    $watermarkHeight = imagesy($watermark);

    // Scale watermark if it's too large for the image (Max 20% width)
    $maxWatermarkWidth = $imageWidth * 0.20;
    
    if ($watermarkWidth > $maxWatermarkWidth) {
        $newWatermarkWidth = $maxWatermarkWidth;
        $newWatermarkHeight = ($watermarkHeight / $watermarkWidth) * $newWatermarkWidth;
        
        $resizedWatermark = imagecreatetruecolor($newWatermarkWidth, $newWatermarkHeight);
        imagealphablending($resizedWatermark, false);
        imagesavealpha($resizedWatermark, true);
        
        imagecopyresampled(
            $resizedWatermark, $watermark,
            0, 0, 0, 0,
            $newWatermarkWidth, $newWatermarkHeight,
            $watermarkWidth, $watermarkHeight
        );
        
        $watermark = $resizedWatermark;
        $watermarkWidth = $newWatermarkWidth;
        $watermarkHeight = $newWatermarkHeight;
    }

    // Calculate position (Bottom Right with 20px margin)
    $margin = 20;
    $destX = $imageWidth - $watermarkWidth - $margin;
    $destY = $imageHeight - $watermarkHeight - $margin;

    // Enable alpha blending to apply transparent logo
    imagealphablending($sourceImageResource, true);

    // Copy watermark onto the source image
    imagecopy($sourceImageResource, $watermark, $destX, $destY, 0, 0, $watermarkWidth, $watermarkHeight);

    imagedestroy($watermark);
    
    return $sourceImageResource;
}
