<?php
/**
 * View Model Builder for creating PDFs
 * @class CreatePDF_Vmb
 */
class CreatePDF_Vmb extends _base_Vmb {

	/**
	 * Populates CreatePDF View Model and handles the PDF creation
	 */
	public function Build() {
		// Set execution time limit to 15 minutes for long-running PDF generation
		set_time_limit(900);
		
		$viewModel = new CreatePDF_Vm();
		
		// Check if this is a POST request with setlist data
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$input = json_decode(file_get_contents('php://input'), true);
			
			if ($input && isset($input['filename']) && isset($input['name'])) {
				$filename = trim($input['filename']);
				$setlistName = trim($input['name']);
				
				// Validate filename
				if (empty($filename) || !preg_match('/^[a-zA-Z0-9\s\-_]+\.json$/', $filename)) {
					$viewModel->Success = false;
					$viewModel->ErrorMessage = 'Invalid filename';
					return $viewModel;
				}
				
				// Get the first guest user credentials from config
				$guestUser = null;
				foreach (Config::$Accounts as $account) {
					if (isset($account['isActive']) && $account['isActive'] && !isset($account['isAdmin'])) {
						$guestUser = $account;
						break;
					}
				}
				
				if (!$guestUser) {
					$viewModel->Success = false;
					$viewModel->ErrorMessage = 'No guest user found in configuration';
					return $viewModel;
				}
				
				// Build file paths
				$setlistDir = Config::$SongDirectory . 'setlists/';
				$setlistFile = $setlistDir . $filename;
				$pdfDir = Config::$SongDirectory . 'setlist_pdfs/';
				
				// Create PDF directory if it doesn't exist
				if (!is_dir($pdfDir)) {
					if (!mkdir($pdfDir, 0755, true)) {
						$viewModel->Success = false;
						$viewModel->ErrorMessage = 'Could not create PDF directory';
						return $viewModel;
					}
				}
				
				// Check if setlist file exists
				if (!file_exists($setlistFile)) {
					$viewModel->Success = false;
					$viewModel->ErrorMessage = 'Setlist file not found';
					return $viewModel;
				}
				
				// Create base filename for PDFs
				$baseName = pathinfo($filename, PATHINFO_FILENAME);
				$printFile = $pdfDir . $baseName . '_print.pdf';
				$tabletFile = $pdfDir . $baseName . '_tablet.pdf';
				
				// Get credentials
				$credentials = $guestUser['user'] . ':' . $guestUser['pass'];
				
				// Use setlist name instead of songbook name
				$setlistTitle = $setlistName;
				
				// Get base URL dynamically from the HTTP request
				$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
				$host = $_SERVER['HTTP_HOST'];
				$baseURL = $protocol . '://' . $host;
				
				// Run the script twice
				$scriptPath = Config::createPDFscriptPath;
				
				// First run: print version
				// Parameters: songlist_file setlist_title base_url output_file
				$printCommand = escapeshellcmd($scriptPath) . ' ' . 
							   escapeshellarg($setlistFile) . ' ' . 
							   escapeshellarg($setlistTitle) . ' ' . 
							   escapeshellarg($baseURL) . ' ' . 
							   escapeshellarg($printFile) . ' ' . 
							   '-u ' . escapeshellarg($credentials) . ' ' . 
							   '-d';
				
				$printOutput = array();
				$printReturnCode = -1;
				exec($printCommand, $printOutput, $printReturnCode);
				
				// Second run: tablet version
				// Parameters: songlist_file setlist_title base_url output_file
				$tabletCommand = escapeshellcmd($scriptPath) . ' ' . 
								escapeshellarg($setlistFile) . ' ' . 
								escapeshellarg($setlistTitle) . ' ' . 
								escapeshellarg($baseURL) . ' ' . 
								escapeshellarg($tabletFile) . ' ' . 
								'-u ' . escapeshellarg($credentials) . ' ' . 
								'--tablet';
				
				$tabletOutput = array();
				$tabletReturnCode = -1;
				exec($tabletCommand, $tabletOutput, $tabletReturnCode);
				
				// Check if both commands succeeded (return code 0)
				if ($printReturnCode === 0 && $tabletReturnCode === 0) {
					$viewModel->Success = true;
					$viewModel->SetlistName = $setlistName;
					$viewModel->PrintFile = basename($printFile);
					$viewModel->TabletFile = basename($tabletFile);
				} else {
					$viewModel->Success = false;
					$viewModel->ErrorMessage = 'PDF creation failed. Print return code: ' . $printReturnCode . ', Tablet return code: ' . $tabletReturnCode;
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