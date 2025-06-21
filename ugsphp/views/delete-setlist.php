<?php
// This view returns JSON response for AJAX requests
header('Content-Type: application/json');

$response = array(
    'success' => $model->Success,
    'message' => $model->Success ? 'Setlist deleted successfully!' : $model->ErrorMessage,
    'setlistName' => $model->SetlistName
);

echo json_encode($response);
?> 