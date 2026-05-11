<?php
/**
 * EA Image Upload Endpoint — LOCAL USE ONLY
 * Called by ea-image-review.html to upload images directly to WP Media Library.
 * No credentials needed — protected by localhost-only IP check.
 */

// Buffer ALL output so plugin warnings don't corrupt our JSON response
ob_start();

// Local dev only — block obviously external IPs
$ip = $_SERVER['REMOTE_ADDR'] ?? '';
$blocked = !preg_match('/^(127\.|::1$|::ffff:127\.|10\.|192\.168\.|172\.(1[6-9]|2[0-9]|3[01])\.)/', $ip);
if ($blocked) {
    ob_end_clean();
    http_response_code(403);
    die(json_encode(['error' => 'Local access only']));
}

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, X-File-Name, X-WP-Nonce');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    ob_end_clean();
    http_response_code(200); die();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    ob_end_clean();
    http_response_code(405); die(json_encode(['error' => 'POST only']));
}

// Load WordPress
require_once __DIR__ . '/wp-load.php';

// Load WP admin helpers (needed for media_handle_sideload, wp_tempnam, etc.)
require_once ABSPATH . 'wp-admin/includes/image.php';
require_once ABSPATH . 'wp-admin/includes/file.php';
require_once ABSPATH . 'wp-admin/includes/media.php';

// Set current user to first admin
$admins = get_users(['role' => 'administrator', 'number' => 1, 'fields' => ['ID']]);
if (empty($admins)) {
    ob_end_clean();
    http_response_code(500);
    die(json_encode(['error' => 'No administrator account found in WordPress']));
}
wp_set_current_user($admins[0]->ID);

// Read uploaded file from raw POST body
$filename  = isset($_SERVER['HTTP_X_FILE_NAME'])
    ? sanitize_file_name(rawurldecode($_SERVER['HTTP_X_FILE_NAME']))
    : 'upload.jpg';
$data = file_get_contents('php://input');

if (!$data || strlen($data) === 0) {
    ob_end_clean();
    http_response_code(400);
    die(json_encode(['error' => 'No file data received']));
}

// Write to a temp file
$tmp = wp_tempnam($filename);
file_put_contents($tmp, $data);

$file_array = [
    'name'     => $filename,
    'tmp_name' => $tmp,
    'error'    => UPLOAD_ERR_OK,
    'size'     => strlen($data),
];

$attachment_id = media_handle_sideload($file_array, 0, sanitize_text_field($filename));
@unlink($tmp);

if (is_wp_error($attachment_id)) {
    ob_end_clean();
    http_response_code(500);
    die(json_encode(['error' => $attachment_id->get_error_message()]));
}

ob_end_clean();
die(json_encode([
    'success' => true,
    'id'      => $attachment_id,
    'url'     => wp_get_attachment_url($attachment_id),
    'file'    => $filename,
]));
