<?php
/**
 * View Model for setlist navigation
 * @class StartSetlist_Vm
 */
class StartSetlist_Vm extends _base_Vm {
	
	/**
	 * The setlist name
	 * @var string
	 */
	public $SetlistName = '';
	
	/**
	 * Array of songs in the setlist
	 * @var array
	 */
	public $Songs = array();
	
	/**
	 * Current song index in the setlist
	 * @var int
	 */
	public $CurrentIndex = 0;
	
	/**
	 * Current song ID
	 * @var string
	 */
	public $CurrentSongId = '';
	
	/**
	 * Previous song ID (if any)
	 * @var string
	 */
	public $PreviousSongId = '';
	
	/**
	 * Next song ID (if any)
	 * @var string
	 */
	public $NextSongId = '';
	
	/**
	 * Whether this is part of a setlist navigation
	 * @var bool
	 */
	public $IsSetlistNavigation = false;
	
	function __construct()
	{
		parent::__construct();
		$this->PageTitle = 'Setlist Navigation ' . Config::PageTitleSuffix;
	}
} 