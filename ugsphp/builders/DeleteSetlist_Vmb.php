<?php
/**
 * View Model Builder for deleting setlists
 * @class DeleteSetlist_Vmb
 */
class DeleteSetlist_Vmb extends _base_Vmb {

	/**
	 * Populates DeleteSetlist View Model and handles the delete operation
	 */
	public function Build() {
		$viewModel = new DeleteSetlist_Vm();
		
		// Check if this is a POST request with filename
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$input = json_decode(file_get_contents('php://input'), true);
			
			if ($input && isset($input['filename'])) {
				$filename = trim($input['filename']);
				
				// Validate filename
				if (empty($filename) || !preg_match('/^[a-zA-Z0-9\s\-_]+\.json$/', $filename)) {
					$viewModel->Success = false;
					$viewModel->ErrorMessage = 'Invalid filename';
					return $viewModel;
				}
				
				// Build file path
				$setlistDir = Config::$SongDirectory . 'setlists/';
				$filepath = $setlistDir . $filename;
				
				// Check if file exists
				if (!file_exists($filepath)) {
					$viewModel->Success = false;
					$viewModel->ErrorMessage = 'Setlist file not found';
					return $viewModel;
				}
				
				// Read the file to get the setlist name for the response
				$content = file_get_contents($filepath);
				$setlistData = json_decode($content, true);
				$setlistName = isset($setlistData['name']) ? $setlistData['name'] : 'Unknown';
				
				// Delete the file
				if (unlink($filepath)) {
					$viewModel->Success = true;
					$viewModel->SetlistName = $setlistName;
				} else {
					$viewModel->Success = false;
					$viewModel->ErrorMessage = 'Could not delete setlist file';
				}
			} else {
				$viewModel->Success = false;
				$viewModel->ErrorMessage = 'Invalid request data';
			}
		} else {
			$viewModel->Success = false;
			$viewModel->ErrorMessage = 'Invalid request method';
		}
		
		return $viewModel;
	}
} 