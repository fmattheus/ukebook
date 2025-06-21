<?php
/**
 * View Model Builder for saving setlists
 * @class SaveSetlist_Vmb
 */
class SaveSetlist_Vmb extends _base_Vmb {

	/**
	 * Populates SaveSetlist View Model and handles the save operation
	 */
	public function Build() {
		$viewModel = new SaveSetlist_Vm();
		
		// Check if this is a POST request with setlist data
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$input = json_decode(file_get_contents('php://input'), true);
			
			if ($input && isset($input['name']) && isset($input['songs'])) {
				$setlistName = trim($input['name']);
				$songs = $input['songs'];
				
				// Validate input
				if (empty($setlistName)) {
					$viewModel->Success = false;
					$viewModel->ErrorMessage = 'Setlist name cannot be empty';
					return $viewModel;
				}
				
				if (strpos($setlistName, '_') !== false) {
					$viewModel->Success = false;
					$viewModel->ErrorMessage = 'Setlist name cannot contain underscores (_). Please use another character like a dash (-).';
					return $viewModel;
				}
				
				if (empty($songs) || !is_array($songs)) {
					$viewModel->Success = false;
					$viewModel->ErrorMessage = 'Setlist must contain at least one song';
					return $viewModel;
				}
				
				// Create setlist directory if it doesn't exist
				$setlistDir = Config::$SongDirectory . 'setlists/';
				if (!is_dir($setlistDir)) {
					if (!mkdir($setlistDir, 0755, true)) {
						$viewModel->Success = false;
						$viewModel->ErrorMessage = 'Could not create setlist directory';
						return $viewModel;
					}
				}
				
				// Create filename from setlist name
				$filename = $this->sanitizeFilename($setlistName) . '.json';
				$filepath = $setlistDir . $filename;
				
				// Prepare setlist data
				$setlistData = array(
					'name' => $setlistName,
					'created' => date('Y-m-d H:i:s'),
					'songs' => $songs
				);
				
				// Save to file
				$jsonData = json_encode($setlistData, JSON_PRETTY_PRINT);
				if (file_put_contents($filepath, $jsonData) !== false) {
					$viewModel->Success = true;
					$viewModel->SetlistName = $setlistName;
					$viewModel->Filename = $filename;
				} else {
					$viewModel->Success = false;
					$viewModel->ErrorMessage = 'Could not save setlist file';
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
	
	/**
	 * Sanitize filename to be safe for filesystem
	 * @param string $name
	 * @return string
	 */
	private function sanitizeFilename($name) {
		// Remove or replace unsafe characters
		$filename = preg_replace('/[^a-zA-Z0-9\s\-_]/', '', $name);
		$filename = preg_replace('/\s+/', '_', $filename);
		$filename = trim($filename, '_');
		
		// Ensure it's not empty
		if (empty($filename)) {
			$filename = 'setlist_' . date('Y-m-d_H-i-s');
		}
		
		return $filename;
	}
} 