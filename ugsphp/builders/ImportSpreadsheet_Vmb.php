<?php

/**
 * View Model Builder -- Creates an "Import Spreadsheet" View Model
 * @class ImportSpreadsheet_Vmb
 */
class ImportSpreadsheet_Vmb extends _base_Vmb {

	/**
	 * Populates ImportSpreadsheet View Model using detailed song list from cache
	 */
	public function Build() {
		$viewModel = new ImportSpreadsheet_Vm();
		$viewModel->IsNewAllowed = true; // Allow editing for now
		
		// Get detailed song list from cache to get proper titles and artists
		$cache = new SongListCacheManager();
		$songListPlus = $cache->Get();
		
		// Handle both array and object returns from cache
		if (is_array($songListPlus)) {
			// If cache returns an array directly, use it
			$viewModel->SongList = $songListPlus;
		} elseif (is_object($songListPlus) && isset($songListPlus->SongList)) {
			// If cache returns a SongListPlus_Pvm object, use its SongList property
			$viewModel->SongList = $songListPlus->SongList;
		} else {
			// Fallback: if cache returns something unexpected, rebuild it
			$songListPlus = $cache->Rebuild();
			if (is_array($songListPlus)) {
				$viewModel->SongList = $songListPlus;
			} else {
				$viewModel->SongList = $songListPlus->SongList;
			}
		}
		
		// Check if we have POST data for processing
		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			if (isset($_POST['step']) && $_POST['step'] === '1') {
				// Step 1: Process pasted spreadsheet data
				$viewModel->CurrentStep = 2;
				$viewModel->SetlistName = isset($_POST['setlist_name']) ? $_POST['setlist_name'] : 'Imported Setlist';
				$viewModel->ImportedSongs = $this->parseSpreadsheetData($_POST['spreadsheet_data']);
			} elseif (isset($_POST['step']) && $_POST['step'] === '2') {
				// Step 2: Process song matches
				$viewModel->CurrentStep = 3;
				$viewModel->SetlistName = $_POST['setlist_name'];
				$viewModel->ImportedSongs = json_decode($_POST['matched_songs'], true);
			}
		}
		
		return $viewModel;
	}

	/**
	 * Parse spreadsheet data from Google Docs
	 * @method parseSpreadsheetData
	 * @param string $data
	 * @return array
	 */
	private function parseSpreadsheetData($data) {
		$lines = explode("\n", trim($data));
		$songs = array();
		
		foreach ($lines as $line) {
			$line = trim($line);
			if (empty($line)) continue;
			
			// Split by tab character (Google Docs uses tabs)
			$columns = explode("\t", $line);
			
			// Ensure we have at least 4 columns
			while (count($columns) < 4) {
				$columns[] = '';
			}
			
			$title = trim($columns[0]);
			$artist = trim($columns[1]);
			$gema = trim($columns[2]);
			$leader = trim($columns[3]);
			
			// Skip empty titles or "Break"
			if (empty($title) || strtolower($title) === 'break') {
				continue;
			}
			
			$songs[] = array(
				'title' => $title,
				'artist' => $artist,
				'gema' => $gema, // Keep internal name as gemsa for compatibility
				'leader' => $leader,
				'matched_song' => null
			);
		}
		
		return $songs;
	}
} 
