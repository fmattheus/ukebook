<?php
/**
 * Serves .tutorial and .playalong video files from the song directory.
 * Supports HTTP range requests so browsers can seek within the video.
 */

$type = isset($_GET['type']) ? $_GET['type'] : '';
$song = isset($_GET['song']) ? $_GET['song'] : '';

// Only allow the two known types
if (!in_array($type, array('tutorial', 'playalong'))) {
    http_response_code(400);
    exit;
}

// Sanitize: strip directory separators, then only allow safe filename chars
$song = basename($song);
$song = preg_replace('/[^a-zA-Z0-9._-]/', '', $song);
// Strip any file extension that may have been passed
$song = preg_replace('/\.[^.]+$/', '', $song);

if (empty($song)) {
    http_response_code(400);
    exit;
}

$songDir = __DIR__ . '/cpm/';

// Find the actual file — it may be song.tutorial.mp4, .webm, etc.
$matches = glob($songDir . $song . '.' . $type . '.*');
if (empty($matches)) {
    http_response_code(404);
    exit;
}
$filePath = realpath($matches[0]);

// Ensure the resolved path is still inside the song directory
if ($filePath === false || strpos($filePath, realpath($songDir)) !== 0) {
    http_response_code(404);
    exit;
}

// Derive MIME type from the actual file extension
$ext = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
$mimeMap = array(
    'mp4'  => 'video/mp4',
    'm4v'  => 'video/mp4',
    'webm' => 'video/webm',
    'ogv'  => 'video/ogg',
    'ogg'  => 'video/ogg',
    'mov'  => 'video/quicktime',
    'avi'  => 'video/x-msvideo',
    'mkv'  => 'video/x-matroska',
);
$mimeType = isset($mimeMap[$ext]) ? $mimeMap[$ext] : 'video/mp4';

$fileSize = filesize($filePath);
$start = 0;
$end   = $fileSize - 1;

header('Accept-Ranges: bytes');
header('Content-Type: ' . $mimeType);

// Handle range requests so the browser can seek
if (isset($_SERVER['HTTP_RANGE'])) {
    if (preg_match('/bytes=(\d*)-(\d*)/', $_SERVER['HTTP_RANGE'], $m)) {
        $start = $m[1] !== '' ? intval($m[1]) : 0;
        $end   = $m[2] !== '' ? intval($m[2]) : $fileSize - 1;

        if ($start > $end || $end >= $fileSize) {
            http_response_code(416);
            header('Content-Range: bytes */' . $fileSize);
            exit;
        }

        http_response_code(206);
        header('Content-Range: bytes ' . $start . '-' . $end . '/' . $fileSize);
    }
} else {
    http_response_code(200);
}

$length = $end - $start + 1;
header('Content-Length: ' . $length);

$fp = fopen($filePath, 'rb');
fseek($fp, $start);
$bufSize = 8192;
$sent    = 0;
while (!feof($fp) && $sent < $length) {
    $chunk = min($bufSize, $length - $sent);
    echo fread($fp, $chunk);
    $sent += $chunk;
    flush();
}
fclose($fp);
