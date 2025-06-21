<?php

/**
 * View Model Builder -- Creates a "Setlist" View Model
 * @class Setlist_Vmb
 */
class Setlist_Vmb extends _base_Vmb {

	/**
	 * Populates Setlist View Model using detailed song list from cache
	 */
	public function Build() {
		$viewModel = new Setlist_Vm();
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
		
		return $viewModel;
	}

	/**
	 * Handles titles beginning with "The"
	 * @method getTitle
	 * @param string $filename
	 * @return string
	 */
	private function getTitle($filename) {
		$title = trim(ucwords(str_replace('-', ' ', str_replace('_', ' ', $filename))));
		$pos = strpos($title, 'The ');
		if (($pos !== false) && ($pos == 0)) {
			$title = substr($title, 4, strlen($title)) . ', The';
		}
		return $title;
	}

} 