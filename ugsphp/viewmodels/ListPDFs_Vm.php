<?php
/**
 * View Model for listing PDF files
 * @class ListPDFs_Vm
 */
class ListPDFs_Vm extends _base_Vm {
	
	/**
	 * Array of PDF file information
	 * @var array
	 */
	public $PDFs = array();
	
	/**
	 * Whether the user can edit (delete PDFs)
	 * @var bool
	 */
	public $CanEdit = false;
	
	/**
	 * Total number of PDF files
	 * @var int
	 */
	public $TotalCount = 0;
} 