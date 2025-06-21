<?php
/**
 * View Model Builder for listing PDF files
 * @class ListPDFs_Vmb
 */
class ListPDFs_Vmb extends _base_Vmb {

	/**
	 * Populates ListPDFs View Model
	 */
	public function Build() {
		$viewModel = new ListPDFs_Vm();
		
		// Set edit permissions based on user
		$viewModel->CanEdit = $this->SiteUser->IsAllowAccess;
		
		// Get PDF directory path
		$pdfDir = Config::$SongDirectory . 'setlist_pdfs/';
		
		// Check if PDF directory exists
		if (!is_dir($pdfDir)) {
			$viewModel->PDFs = array();
			$viewModel->TotalCount = 0;
			return $viewModel;
		}
		
		// Get all PDF files
		$pdfFiles = glob($pdfDir . '*.pdf');
		$pdfs = array();
		
		foreach ($pdfFiles as $pdfFile) {
			$filename = basename($pdfFile);
			$filePath = $pdfFile;
			$fileSize = filesize($pdfFile);
			$fileTime = filemtime($pdfFile);
			$fileDate = date('Y-m-d H:i:s', $fileTime);
			
			// Determine file type (print or tablet)
			$fileType = 'Unknown';
			if (strpos($filename, '_print.pdf') !== false) {
				$fileType = 'Print';
			} elseif (strpos($filename, '_tablet.pdf') !== false) {
				$fileType = 'Tablet';
			}
			
			// Extract setlist name from filename
			$setlistName = str_replace(array('_print.pdf', '_tablet.pdf'), '', $filename);
			
			$pdfs[] = array(
				'filename' => $filename,
				'filepath' => $filePath,
				'filesize' => $fileSize,
				'filesize_formatted' => $this->formatFileSize($fileSize),
				'filetime' => $fileTime,
				'filedate' => $fileDate,
				'filetype' => $fileType,
				'setlist_name' => $setlistName
			);
		}
		
		// Sort by file time (newest first)
		usort($pdfs, function($a, $b) {
			return $b['filetime'] - $a['filetime'];
		});
		
		$viewModel->PDFs = $pdfs;
		$viewModel->TotalCount = count($pdfs);
		
		return $viewModel;
	}
	
	/**
	 * Format file size in human readable format
	 * @param int $bytes
	 * @return string
	 */
	private function formatFileSize($bytes) {
		if ($bytes >= 1073741824) {
			return number_format($bytes / 1073741824, 2) . ' GB';
		} elseif ($bytes >= 1048576) {
			return number_format($bytes / 1048576, 2) . ' MB';
		} elseif ($bytes >= 1024) {
			return number_format($bytes / 1024, 2) . ' KB';
		} else {
			return $bytes . ' bytes';
		}
	}
} 