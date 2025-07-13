<?php

/**
* View model for import spreadsheet page
*/
class ImportSpreadsheet_Vm extends _base_Vm {
	public $SongList = array();
	public $SetlistName = '';
	public $ImportedSongs = array();
	public $CurrentStep = 1; // 1 = paste data, 2 = review matches, 3 = save setlist

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
		$this->Headline = 'Import Spreadsheet';
		$this->SubHeadline = 'Import songs from Google Docs spreadsheet &raquo;';
		$this->PageTitle = 'Import Spreadsheet ' . Config::PageTitleSuffix;
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
	 * Filters songs based on search term for fuzzy matching
	 * @method FilterSongs
	 * @param mixed $searchTerm String (legacy) or array with 'title' and 'artist' keys
	 * @return array
	 */
	public function FilterSongs($searchTerm) {
		if (empty($searchTerm)) {
			return array();
		}

		// Use the FuzzySearch library for proper fuzzy matching
		$matches = FuzzySearch::search($searchTerm, $this->SongList, 10);
		
		// Convert to the expected format
		$filtered = array();
		foreach ($matches as $match) {
			$filtered[] = array(
				'song' => $match['item'],
				'score' => $match['score']
			);
		}
		
		return $filtered;
	}
	

} 