<?php
/**
 * View Model for saving setlists
 * @class SaveSetlist_Vm
 */
class SaveSetlist_Vm extends _base_Vm {
	
	/**
	 * Whether the save was successful
	 * @var bool
	 */
	public $Success = false;
	
	/**
	 * Error message if save failed
	 * @var string
	 */
	public $ErrorMessage = '';
	
	/**
	 * The name of the saved setlist
	 * @var string
	 */
	public $SetlistName = '';
	
	/**
	 * The filename of the saved setlist
	 * @var string
	 */
	public $Filename = '';
} 