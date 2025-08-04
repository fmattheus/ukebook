<?php


/**
 * View Model Builder -- Creates a "Song" View Model
 * @class Song_Vmb
 */
class Song_Vmb extends _base_Vmb {

	/**
	 * Parses file (using URL query param) and attempts to load View Model
	 * @return Song_Vm
	 */
	public function Build() {
		
		$filename = FileHelper::getFilename();
                $fileContent = FileHelper::getFile(Config::$SongDirectory . $filename); 
		$song = SongHelper::parseSong($fileContent);

		$title = htmlspecialchars((($song->isOK) ? ($song->title . ((strlen($song->subtitle) > 0) ? (' | ' . $song->subtitle) : '')) : 'Not Found'));

		$viewModel = new Song_Vm();
		$viewModel->PageTitle = $this->MakePageTitle($song, $filename);
		$viewModel->SongTitle = htmlspecialchars($song->title);
		$viewModel->Subtitle = htmlspecialchars($song->subtitle);
		$viewModel->Artist = $song->artist;
		$viewModel->Album = $song->album; // htmlspecialchars();
		$viewModel->Body = $song->body;
        $viewModel->Reputation = $song->reputation;
		$viewModel->UgsMeta = $song->meta;
		$viewModel->Tempo = $song->tempo;
		$viewModel->Gema = $song->gema;
		$viewModel->SourceUri = Ugs::MakeUri(Actions::Source, $filename);
		$viewModel->EditUri = Ugs::MakeUri(Actions::Edit, $filename);

		$viewModel->Id = $filename;
        $viewModel->IsUpdateAllowed = $this->SiteUser->MayEdit && $this->SiteUser->IsAuthenticated && !(!$this->SiteUser->IsAdmin && $song->reputation);

		$viewModel->EditorSettingsJson = $this->getSettings();
		
		// Check if this is part of a setlist navigation
		$setlistFile = '';
		$setlistIndex = 0;
		
		// First try to get from GET parameters
		if (isset($_GET['setlist'])) {
			$setlistFile = $_GET['setlist'];
			$setlistIndex = isset($_GET['setlist_index']) ? intval($_GET['setlist_index']) : 0;
		}
		// If no setlist in GET, try to get it from the URL path (for mod_rewrite)
		elseif (empty($setlistFile)) {
			$requestUri = $_SERVER['REQUEST_URI'];
			$path = parse_url($requestUri, PHP_URL_PATH);
			$pathParts = explode('/', trim($path, '/'));
			// Look for the setlist filename in the path
			foreach ($pathParts as $part) {
				if (strpos($part, '.json') !== false) {
					$setlistFile = $part;
					break;
				}
			}
		}
		
		// Load setlist data if we have a setlist file
		if (!empty($setlistFile)) {
			$setlistData = null;
			
			// Always load from file - no session dependency
			$setlistDir = Config::$SongDirectory . 'setlists/';
			$setlistPath = $setlistDir . $setlistFile;
			
			if (file_exists($setlistPath)) {
				$content = file_get_contents($setlistPath);
				$fileData = json_decode($content, true);
				
				if ($fileData && isset($fileData['name']) && isset($fileData['songs'])) {
					// Convert song references to use Uri format for consistency
					$processedSongs = array();
					foreach ($fileData['songs'] as $song) {
						$processedSong = $song;
						if (isset($song['id']) && !isset($song['Uri'])) {
							$processedSong['Uri'] = Ugs::MakeUri(Actions::Song, $song['id']);
						}
						$processedSongs[] = $processedSong;
					}
					
					// Create setlist data without storing in session
					$setlistData = array(
						'filename' => $setlistFile,
						'name' => $fileData['name'],
						'songs' => $processedSongs,
						'current_index' => $setlistIndex
					);
				}
			}
			
			// If we have setlist data, set up navigation
			if ($setlistData) {
				$viewModel->IsSetlistNavigation = true;
				$viewModel->SetlistName = $setlistData['name'];
				$viewModel->SetlistSongs = $setlistData['songs'];
				// Use setlist_index to determine current song
				$currentIndex = $setlistIndex;
				if ($currentIndex < 0 || $currentIndex >= count($setlistData['songs'])) {
					$currentIndex = 0;
				}
				$viewModel->CurrentIndex = $currentIndex;
				
				// Get current song URI - handle different field formats
				$currentSong = $setlistData['songs'][$currentIndex];
				$currentSongUri = '';
				if (isset($currentSong['Uri'])) {
					$currentSongUri = $currentSong['Uri'];
				} elseif (isset($currentSong['id'])) {
					// Convert id to URI format
					$currentSongUri = Ugs::MakeUri(Actions::Song, $currentSong['id']);
				}
				$viewModel->CurrentSongId = $currentSongUri;
				
				// Set transpose value from setlist
				$viewModel->Transpose = intval($currentSong['Transpose'] ?? 0);
				
				// Set previous song
				if ($currentIndex > 0) {
					$prevSong = $setlistData['songs'][$currentIndex - 1];
					$prevSongUri = '';
					if (isset($prevSong['Uri'])) {
						$prevSongUri = $prevSong['Uri'];
					} elseif (isset($prevSong['id'])) {
						$prevSongUri = Ugs::MakeUri(Actions::Song, $prevSong['id']);
					}
					// Add setlist parameters to previous song URL (only if not already present)
					if (strpos($prevSongUri, 'setlist=') === false) {
						$prevSongUri .= (strpos($prevSongUri, '?') !== false ? '&' : '?') . 'setlist=' . urlencode($setlistFile) . '&setlist_index=' . ($currentIndex - 1);
					}
					$viewModel->PreviousSongId = $prevSongUri;
					$viewModel->PreviousSongIndex = $currentIndex - 1;
				}
				
				// Set next song
				if ($currentIndex < count($setlistData['songs']) - 1) {
					$nextSong = $setlistData['songs'][$currentIndex + 1];
					$nextSongUri = '';
					if (isset($nextSong['Uri'])) {
						$nextSongUri = $nextSong['Uri'];
					} elseif (isset($nextSong['id'])) {
						$nextSongUri = Ugs::MakeUri(Actions::Song, $nextSong['id']);
					}
					// Add setlist parameters to next song URL (only if not already present)
					if (strpos($nextSongUri, 'setlist=') === false) {
						$nextSongUri .= (strpos($nextSongUri, '?') !== false ? '&' : '?') . 'setlist=' . urlencode($setlistFile) . '&setlist_index=' . ($currentIndex + 1);
					}
					$viewModel->NextSongId = $nextSongUri;
					$viewModel->NextSongIndex = $currentIndex + 1;
				}
				
				// Add instance info if song appears multiple times
				$totalInstances = 0;
				$instanceIndex = 0;
				for ($i = 0; $i <= $currentIndex; $i++) {
					$songUri = '';
					if (isset($setlistData['songs'][$i]['Uri'])) {
						$songUri = $setlistData['songs'][$i]['Uri'];
					} elseif (isset($setlistData['songs'][$i]['id'])) {
						$songUri = Ugs::MakeUri(Actions::Song, $setlistData['songs'][$i]['id']);
					}
					if ($songUri === $currentSongUri) {
						$instanceIndex++;
					}
				}
				foreach ($setlistData['songs'] as $song) {
					$songUri = '';
					if (isset($song['Uri'])) {
						$songUri = $song['Uri'];
					} elseif (isset($song['id'])) {
						$songUri = Ugs::MakeUri(Actions::Song, $song['id']);
					}
					if ($songUri === $currentSongUri) {
						$totalInstances++;
					}
				}
				$viewModel->SongInstanceIndex = $instanceIndex;
				$viewModel->SongInstanceTotal = $totalInstances;
				// No longer updating session - using GET parameters instead
			}
		}
		
		return $viewModel;
	}

	/**
	 * Does not validate values, but does ensure only valid JSON was provided.
	 * @method getSettings
	 * @return string
	 */
	private function getSettings() {
		$settings = FileHelper::getFile(Config::$AppDirectory . 'settings.json');
		if ($settings === null){
			return '{}';
		}

		if (!function_exists('json_decode')){
			return $settings;
		}

		$json = preg_replace("#(/\*([^*]|[\r\n]|(\*+([^*/]|[\r\n])))*\*+/)|([\s\t]//.*)|(^//.*)#", '', $settings);
		if (json_decode($json)){
			return $settings;
		}

		return '{"invalidJson": "There is a problem with your settings: invalid JSON. Please check for typos."}';
	}

	/**
	 * Uses either Title(s) from Song or the file name
	 * @param string $song
	 * @param string $filename
	 * @return string
	 */
	private function MakePageTitle($song, $filename){
		$title = '';

		if ($song->isOK){
			$title = $song->title;

			if (strlen($song->artist) > 0){
				$title .= ' - '	. $song->artist;
			} else if (strlen($song->subtitle) > 0) {
				$title .= ' - ' . $song->subtitle;
			}

			$title = htmlspecialchars($title);
		}

		return ((strlen($title) > 0) ? $title : $filename) . ' ' . Config::PageTitleSuffix;
	}
}
