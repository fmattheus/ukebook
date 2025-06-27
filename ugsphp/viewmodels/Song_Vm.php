<?php

class Song_Vm extends _base_Vm {
	public $SongTitle = '';
	public $Subtitle = '';
	public $Album = '';
	public $Artist = '';
	public $Body = '';
	public $UgsMeta = null;
	public $SourceUri = '';
	public $EditUri = '';
	public $EditorSettingsJson = '';
	public $Reputation = false;
	public $Tempo = 0;
	public $Gema = '';

	public $Id = '';

	/**
	 * URL where "New Song" AJAX is sent.
	 * -- Only used if Editing is enabled and user has permission.
	 * @var string
	 */
	public $UpdateAjaxUri = '';

	/**
	 * If TRUE View may show edit form
	 * -- Only used if Editing is enabled and user has permission.
	 * @var boolean
	 */
	public $IsUpdateAllowed = false;

	/**
	 * Setlist navigation properties
	 */
	public $IsSetlistNavigation = false;
	public $SetlistName = '';
	public $SetlistSongs = array();
	public $CurrentIndex = 0;
	public $CurrentSongId = '';
	public $PreviousSongId = '';
	public $NextSongId = '';
	public $PreviousSongIndex = null;
	public $NextSongIndex = null;
	public $SongInstanceIndex = 0;
	public $SongInstanceTotal = 0;

	function __construct()
	{
		parent::__construct();
		$this->UpdateAjaxUri = Ugs::MakeUri( Actions::AjaxUpdateSong);
	}

}
