<?php
/**
 * View for downloading or viewing PDF files
 */

// Get the filename from query parameter
$filename = isset($_GET['file']) ? $_GET['file'] : '';
$inline = isset($_GET['view']) && $_GET['view'] == '1';

// Validate filename
if (empty($filename) || !preg_match('/^[a-zA-Z0-9\s\-_]+\.pdf$/', $filename)) {
    http_response_code(400);
    echo 'Invalid filename';
    exit;
}

// Build file path
$pdfDir = Config::$SongDirectory . 'setlist_pdfs/';
$filePath = $pdfDir . $filename;

// Check if file exists
if (!file_exists($filePath)) {
    http_response_code(404);
    echo 'File not found';
    exit;
}

// Set headers for download or inline view
if ($inline) {
    // Inline viewing
    header('Content-Type: application/pdf');
    header('Content-Disposition: inline; filename="' . $filename . '"');
} else {
    // Force download
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Content-Transfer-Encoding: binary');
    header('Accept-Ranges: bytes');
}
header('Content-Length: ' . filesize($filePath));
header('Cache-Control: no-cache, must-revalidate');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');

// Output file
readfile($filePath);
?> 