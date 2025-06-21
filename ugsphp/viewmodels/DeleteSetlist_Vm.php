<?php
/**
 * View Model for deleting setlists
 * @class DeleteSetlist_Vm
 */
class DeleteSetlist_Vm extends _base_Vm {
	
	/**
	 * Whether the delete was successful
	 * @var bool
	 */
	public $Success = false;
	
	/**
	 * Error message if delete failed
	 * @var string
	 */
	public $ErrorMessage = '';
	
	/**
	 * The name of the deleted setlist
	 * @var string
	 */
	public $SetlistName = '';
} 