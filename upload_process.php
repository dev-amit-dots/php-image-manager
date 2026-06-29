<?php
/**
 * Upload Processor
 * Receives the AJAX request, initializes DB, and processes the image.
 */

header('Content-Type: application/json');

// Include required files
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/functions/upload.php';

// Only allow POST requests
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
    exit;
}

// Check if file was sent
if (!isset($_FILES['image'])) {
    echo json_encode(['success' => false, 'error' => 'No image uploaded.']);
    exit;
}

try {
    // Initialize Database
    $db = new Database();
    $conn = $db->getConnection();

    // Process Upload
    $result = uploadImage($_FILES['image'], $conn);

    // Return JSON response
    echo json_encode($result);

} catch (Exception $e) {
    // Catch any unexpected system errors
    echo json_encode(['success' => false, 'error' => 'Server error: ' . $e->getMessage()]);
}