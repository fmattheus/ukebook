<?php
// This view returns JSON response for AJAX requests
header('Content-Type: application/json');

$response = array(
    'success' => $model->Success,
    'message' => $model->Success ? 'Setlist saved successfully!' : $model->ErrorMessage,
    'setlistName' => $model->SetlistName,
    'filename' => $model->Filename
);

echo json_encode($response);
?> 