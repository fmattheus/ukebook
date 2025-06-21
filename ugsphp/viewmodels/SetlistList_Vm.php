<?php
/**
 * View Model for listing setlists
 * @class SetlistList_Vm
 */
class SetlistList_Vm extends _base_Vm {
	
	/**
	 * Array of setlist information
	 * @var array
	 */
	public $Setlists = array();
	
	/**
	 * Whether the user can edit setlists
	 * @var bool
	 */
	public $CanEdit = false;
} 