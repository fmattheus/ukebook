<?php
/**
 * View Model Builder for downloading PDF files
 * @class DownloadPDF_Vmb
 */
class DownloadPDF_Vmb extends _base_Vmb {

	/**
	 * Populates DownloadPDF View Model
	 */
	public function Build() {
		$viewModel = new DownloadPDF_Vm();
		
		// The actual download logic is handled in the view
		// This builder just provides a valid view model
		
		return $viewModel;
	}
} 