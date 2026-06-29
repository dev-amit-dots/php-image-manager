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
        
        // Ensure image supports alpha for the background overlay
        imagealphablending($sourceImageResource, true);
        
        $bgColor = imagecolorallocatealpha($sourceImageResource, 0, 0, 0, 80); // Dark background with some transparency
        $textColor = imagecolorallocate($sourceImageResource, 255, 255, 255);
        
        $spacingX = $textWidth * 1.5;
        $spacingY = $textHeight * 4.0;
        
        $row = 0;
        for ($y = -$textHeight; $y < $imageHeight; $y += ($textHeight + $spacingY)) {
            $offsetX = ($row % 2 == 0) ? 0 : ($textWidth + $spacingX) / 2;
            
            for ($x = -$textWidth; $x < $imageWidth; $x += ($textWidth + $spacingX)) {
                $destX = $x - $offsetX;
                
                if ($destX > -$textWidth && $destX < $imageWidth) {
                    imagefilledrectangle($sourceImageResource, $destX - 10, $y - 10, $destX + $textWidth + 10, $y + $textHeight + 10, $bgColor);
                    imagestring($sourceImageResource, $fontSize, $destX, $y, $fallbackText, $textColor);
                }
            }
            $row++;
        }
        
        return $sourceImageResource;
    }

    // --- Image Watermark Logic ---
    $watermarkWidth = imagesx($watermark);
    $watermarkHeight = imagesy($watermark);

    // Scale watermark to be smaller for tiling (Max 15% width)
    $maxWatermarkWidth = $imageWidth * 0.15;
    
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

    // Enable alpha blending to apply transparent logo
    imagealphablending($sourceImageResource, true);

    // Tile the watermark across the entire image in a staggered grid
    $spacingX = $watermarkWidth * 0.5; // Spacing between watermarks
    $spacingY = $watermarkHeight * 1.5;

    $row = 0;
    for ($y = -$watermarkHeight; $y < $imageHeight; $y += ($watermarkHeight + $spacingY)) {
        $offsetX = ($row % 2 == 0) ? 0 : ($watermarkWidth + $spacingX) / 2;
        
        for ($x = -$watermarkWidth; $x < $imageWidth; $x += ($watermarkWidth + $spacingX)) {
            $destX = $x - $offsetX;
            
            // Only draw if it's somewhat visible on the canvas
            if ($destX > -$watermarkWidth && $destX < $imageWidth) {
                imagecopy($sourceImageResource, $watermark, $destX, $y, 0, 0, $watermarkWidth, $watermarkHeight);
            }
        }
        $row++;
    }

    imagedestroy($watermark);
    
    return $sourceImageResource;
}
