<?php
/**
 * View Model Builder for listing setlists
 * @class SetlistList_Vmb
 */
class SetlistList_Vmb extends _base_Vmb {

	/**
	 * Populates SetlistList View Model by reading setlist files
	 */
	public function Build() {
		$viewModel = new SetlistList_Vm();
		$viewModel->CanEdit = true; // Allow editing for now
		
		// Get setlist directory
		$setlistDir = Config::$SongDirectory . 'setlists/';
		
		// Check if setlist directory exists
		if (!is_dir($setlistDir)) {
			$viewModel->Setlists = array();
			return $viewModel;
		}
		
		// Get all JSON files in the setlist directory
		$files = glob($setlistDir . '*.json');
		$setlists = array();
		
		foreach ($files as $file) {
			$content = file_get_contents($file);
			$setlistData = json_decode($content, true);
			
			if ($setlistData && isset($setlistData['name']) && isset($setlistData['songs'])) {
				$setlistInfo = array(
					'filename' => basename($file),
					'name' => $setlistData['name'],
					'created' => isset($setlistData['created']) ? $setlistData['created'] : 'Unknown',
					'songCount' => count($setlistData['songs']),
					'songs' => $setlistData['songs']
				);
				
				$setlists[] = $setlistInfo;
			}
		}
		
		// Sort setlists by creation date (newest first)
		usort($setlists, function($a, $b) {
			return strtotime($b['created']) - strtotime($a['created']);
		});
		
		$viewModel->Setlists = $setlists;
		
		return $viewModel;
	}
} 