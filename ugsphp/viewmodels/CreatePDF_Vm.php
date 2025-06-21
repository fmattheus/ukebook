<?php
/**
 * View Model for creating PDFs
 * @class CreatePDF_Vm
 */
class CreatePDF_Vm extends _base_Vm {
	
	/**
	 * Whether this should return JSON response
	 * @var bool
	 */
	public $IsJson = true;
	
	/**
	 * Whether the PDF creation was successful
	 * @var bool
	 */
	public $Success = false;
	
	/**
	 * Error message if PDF creation failed
	 * @var string
	 */
	public $ErrorMessage = '';
	
	/**
	 * The name of the setlist
	 * @var string
	 */
	public $SetlistName = '';
	
	/**
	 * The filename of the print PDF
	 * @var string
	 */
	public $PrintFile = '';
	
	/**
	 * The filename of the tablet PDF
	 * @var string
	 */
	public $TabletFile = '';
} 