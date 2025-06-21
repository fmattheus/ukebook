<?php

/**
* View model for setlist page with search and setlist management
*/
class Setlist_Vm extends _base_Vm {
	public $SongList = array();
	public $SetlistSongs = array();
	public $SearchTerm = '';
	public $SetlistName = '';

	/**
	 * URL where "New Song" AJAX is sent.
	 * -- Only used if Editing is enabled and user has permission.
	 * @var string
	 */
	public $EditAjaxUri = '';

	/**
	 * If TRUE View may show edit form
	 * -- Only used if Editing is enabled and user has permission.
	 * @var boolean
	 */
	public $IsNewAllowed = false;

	public $LogoutUri = '';
	public $Headline = '';
	public $SubHeadline = '';

	function __construct()
	{
		parent::__construct();
		$this->EditAjaxUri = Ugs::MakeUri( Actions::AjaxNewSong);
		$this->LogoutUri = Ugs::MakeUri( Actions::Logout);
		$this->Headline = 'Setlist Manager';
		$this->SubHeadline = 'Create and manage your song sets &raquo;';
		$this->PageTitle = 'Setlist Manager ' . Config::PageTitleSuffix;
	}

	/**
	 * Sorts songs based on title
	 * @method sortSongs
	 * @return (song array)
	 */
	public function Sort() {
		$temp = array();
		$sortedTitles = array();
		foreach ($this->SongList as $song) {
			$sortedTitles[] = $song->Title;
			$temp[$song->Title] = $song;
		}

		sort($sortedTitles);

		$this->SongList = array();
		foreach ($sortedTitles as $title) {
			$this->SongList[] = $temp[$title];
		}

		return $this->SongList;
	}

	/**
	 * Adds a new SongLinkPlus_Pvm to list (detailed song info)
	 * @method Add
	 * @param string $title
	 * @param string $url
	 * @param string $artist (optional)
	 * @return (none)
	 */
	public function Add($title, $url, $artist = ''){
		$song = new SongLinkPlus_Pvm();
		$song->Title = $title;
		$song->Uri = $url;
		$song->Artist = $artist;
		$this->SongList[] = $song;
	}

	/**
	 * Filters songs based on search term
	 * @method FilterSongs
	 * @param string $searchTerm
	 * @return array
	 */
	public function FilterSongs($searchTerm) {
		if (empty($searchTerm)) {
			return $this->SongList;
		}

		$filtered = array();
		$searchLower = strtolower($searchTerm);
		
		foreach ($this->SongList as $song) {
			if (strpos(strtolower($song->Title), $searchLower) !== false) {
				$filtered[] = $song;
			}
		}
		
		return $filtered;
	}

	/**
	 * Adds a song to the setlist
	 * @method AddToSetlist
	 * @param string $title
	 * @param string $url
	 * @return (none)
	 */
	public function AddToSetlist($title, $url) {
		// Check if song is already in setlist
		foreach ($this->SetlistSongs as $song) {
			if ($song->Title === $title) {
				return false; // Already exists
			}
		}
		
		$this->SetlistSongs[] = new SongLink_Pvm($title, $url);
		return true;
	}

	/**
	 * Removes a song from the setlist
	 * @method RemoveFromSetlist
	 * @param string $title
	 * @return (none)
	 */
	public function RemoveFromSetlist($title) {
		foreach ($this->SetlistSongs as $key => $song) {
			if ($song->Title === $title) {
				unset($this->SetlistSongs[$key]);
				$this->SetlistSongs = array_values($this->SetlistSongs); // Reindex array
				return true;
			}
		}
		return false;
	}
} 