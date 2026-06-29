<?php
/**
 * Helper Functions
 * Reusable utility functions for the application.
 */

/**
 * Formats bytes into a human-readable string.
 */
function formatFileSize($bytes) {
    if ($bytes >= 1073741824) {
        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        $bytes = number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        $bytes = number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        $bytes = $bytes . ' bytes';
    } elseif ($bytes == 1) {
        $bytes = $bytes . ' byte';
    } else {
        $bytes = '0 bytes';
    }
    return $bytes;
}

/**
 * Generates a unique, secure file name.
 */
function generateUniqueImageName($extension) {
    // Generate a highly secure random string
    $randomBytes = bin2hex(random_bytes(16));
    $timestamp = time();
    return $timestamp . '_' . $randomBytes . '.' . $extension;
}

/**
 * Inserts image details into the database.
 */
function insertImageRecord($conn, $imageName, $optimizedPath, $watermarkPath, $size, $type) {
    $stmt = $conn->prepare("INSERT INTO images (image_name, optimized_image, watermark_image, image_size, image_type) VALUES (?, ?, ?, ?, ?)");
    if (!$stmt) {
        return false;
    }
    $stmt->bind_param("sssss", $imageName, $optimizedPath, $watermarkPath, $size, $type);
    
    if ($stmt->execute()) {
        $id = $stmt->insert_id;
        $stmt->close();
        return $id;
    }
    $stmt->close();
    return false;
}

/**
 * Retrieves an image record by ID.
 */
function getImageById($conn, $id) {
    $stmt = $conn->prepare("SELECT * FROM images WHERE id = ? LIMIT 1");
    if (!$stmt) return null;
    
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $data = $result->fetch_assoc();
    $stmt->close();
    
    return $data;
}

/**
 * Deletes a physical file if it exists.
 */
function deleteImage($filePath) {
    if (file_exists($filePath) && is_file($filePath)) {
        return unlink($filePath);
    }
    return false;
}

/**
 * Deletes a database record by ID.
 */
function deleteDatabaseRecord($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM images WHERE id = ?");
    if (!$stmt) return false;
    
    $stmt->bind_param("i", $id);
    $success = $stmt->execute();
    $stmt->close();
    
    return $success;
}