<?php
/**
 * View Model Builder for starting a setlist
 * @class StartSetlist_Vmb
 */
class StartSetlist_Vmb extends _base_Vmb {

	/**
	 * Populates StartSetlist View Model and redirects to first song
	 */
	public function Build() {
		// Ensure session is started
		if (session_status() == PHP_SESSION_NONE) {
			session_start();
		}
		
		// Include SongHelper for parsing songs
		require_once Config::$AppDirectory . 'classes/SongHelper.php';
		
		$viewModel = new StartSetlist_Vm();
		
		// Get setlist filename from query parameter or URL path
		$setlistFile = isset($_GET['setlist']) ? $_GET['setlist'] : '';
		
		// If no setlist in GET, try to get it from the URL path (for mod_rewrite)
		if (empty($setlistFile)) {
			// Parse the URL to get the setlist filename from the path
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
		
		if (empty($setlistFile)) {
			// No setlist specified, redirect to setlist list
			header('Location: ' . Ugs::MakeUri(Actions::ListSetlists));
			exit();
		}
		
		// Get setlist directory
		$setlistDir = Config::$SongDirectory . 'setlists/';
		$setlistPath = $setlistDir . $setlistFile;
		
		// Check if setlist file exists
		if (!file_exists($setlistPath)) {
			$errorUrl = Ugs::MakeUri(Actions::ListSetlists);
			$errorUrl .= (Config::UseModRewrite ? '?' : '&') . 'error=setlist_not_found';
			header('Location: ' . $errorUrl);
			exit();
		}
		
		// Load setlist data
		$content = file_get_contents($setlistPath);
		$setlistData = json_decode($content, true);
		
		if (!$setlistData || !isset($setlistData['songs']) || empty($setlistData['songs'])) {
			$errorUrl = Ugs::MakeUri(Actions::ListSetlists);
			$errorUrl .= (Config::UseModRewrite ? '?' : '&') . 'error=empty_setlist';
			header('Location: ' . $errorUrl);
			exit();
		}
		
		// Get the first song from the setlist
		$firstSong = $setlistData['songs'][0];
		
		// Extract song ID from various possible field formats
		$firstSongId = '';
		$songUri = '';
		
		if (isset($firstSong['id'])) {
			$firstSongId = $firstSong['id'];
		} elseif (isset($firstSong['Uri'])) {
			// Use the URI directly - it's already the correct path
			$songUri = $firstSong['Uri'];
			// Extract filename from URI for session storage
			$pathParts = explode('/', trim($songUri, '/'));
			$lastPart = end($pathParts);
			$firstSongId = $lastPart . '.cpm.txt'; // For session storage
		} elseif (isset($firstSong['Title'])) {
			// If we have a Title, we need to find the corresponding file
			$songTitle = $firstSong['Title'];
			// Look for a .cpm.txt file that matches this title
			$songFiles = glob(Config::$SongDirectory . '*.cpm.txt');
			foreach ($songFiles as $songFile) {
				$content = file_get_contents($songFile);
				$song = SongHelper::parseSong($content);
				if ($song->isOK && $song->title === $songTitle) {
					$firstSongId = basename($songFile);
					break;
				}
			}
		} elseif (isset($firstSong['title'])) {
			$firstSongId = $firstSong['title'];
		}
		
		if (empty($firstSongId)) {
			$errorUrl = Ugs::MakeUri(Actions::ListSetlists);
			$errorUrl .= (Config::UseModRewrite ? '?' : '&') . 'error=invalid_song';
			header('Location: ' . $errorUrl);
			exit();
		}
		
		// Store setlist data in session for navigation
		$_SESSION['current_setlist'] = array(
			'filename' => $setlistFile,
			'name' => $setlistData['name'],
			'songs' => $setlistData['songs'],
			'current_index' => 0
		);
		
		// Redirect to the first song with setlist parameter
		if (!empty($songUri)) {
			// Use the URI directly from the setlist
			$redirectUrl = $songUri;
			$redirectUrl .= '?setlist=' . urlencode($setlistFile);
		} else {
			// Fall back to using Ugs::MakeUri for other cases
			$redirectUrl = Ugs::MakeUri(Actions::Song, $firstSongId);
			if (Config::UseModRewrite) {
				$redirectUrl .= '?setlist=' . urlencode($setlistFile);
			} else {
				$redirectUrl .= '&setlist=' . urlencode($setlistFile);
			}
		}
		
		header('Location: ' . $redirectUrl);
		exit();
	}
} 