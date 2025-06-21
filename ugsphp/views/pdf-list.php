<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PDF Files - <?php echo Config::SongbookHeadline; ?></title>
	<style>
		body {
			font-family: Arial, sans-serif;
			margin: 0;
			padding: 20px;
			background: #f5f5f5;
		}
		
		.container {
			max-width: 1200px;
			margin: 0 auto;
			background: white;
			border-radius: 8px;
			box-shadow: 0 2px 10px rgba(0,0,0,0.1);
			overflow: hidden;
		}
		
		.header {
			background: #007cba;
			color: white;
			padding: 20px;
			display: flex;
			justify-content: space-between;
			align-items: center;
		}
		
		.header h1 {
			margin: 0;
			font-size: 24px;
		}
		
		.back-btn {
			background: rgba(255,255,255,0.2);
			color: white;
			border: none;
			padding: 8px 16px;
			border-radius: 4px;
			cursor: pointer;
			text-decoration: none;
			font-size: 14px;
		}
		
		.back-btn:hover {
			background: rgba(255,255,255,0.3);
		}
		
		.content {
			padding: 20px;
		}
		
		.stats {
			margin-bottom: 20px;
			color: #666;
		}
		
		.pdf-table {
			width: 100%;
			border-collapse: collapse;
			margin-top: 20px;
		}
		
		.pdf-table th {
			background: #f8f9fa;
			padding: 12px;
			text-align: left;
			border-bottom: 2px solid #dee2e6;
			cursor: pointer;
			user-select: none;
			position: relative;
		}
		
		.pdf-table th:hover {
			background: #e9ecef;
		}
		
		.pdf-table th.sortable::after {
			content: '↕';
			position: absolute;
			right: 8px;
			color: #999;
		}
		
		.pdf-table th.sort-asc::after {
			content: '↑';
			color: #007cba;
		}
		
		.pdf-table th.sort-desc::after {
			content: '↓';
			color: #007cba;
		}
		
		.pdf-table td {
			padding: 12px;
			border-bottom: 1px solid #dee2e6;
			vertical-align: middle;
		}
		
		.pdf-table tr:hover {
			background: #f8f9fa;
		}
		
		.file-type {
			display: inline-block;
			padding: 4px 8px;
			border-radius: 4px;
			font-size: 12px;
			font-weight: bold;
			text-transform: uppercase;
		}
		
		.file-type.print {
			background: #d4edda;
			color: #155724;
		}
		
		.file-type.tablet {
			background: #d1ecf1;
			color: #0c5460;
		}
		
		.download-btn {
			background: #28a745;
			color: white;
			border: none;
			padding: 6px 12px;
			border-radius: 4px;
			cursor: pointer;
			text-decoration: none;
			font-size: 12px;
		}
		
		.download-btn:hover {
			background: #218838;
		}
		
		.no-pdfs {
			text-align: center;
			padding: 40px;
			color: #666;
			font-style: italic;
		}
		
		.setlist-name {
			font-weight: bold;
			color: #333;
		}
		
		.file-size {
			color: #666;
			font-size: 14px;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="header">
			<h1>📄 PDF Files</h1>
			<a href="<?php echo Ugs::MakeUri(Actions::ListSetlists); ?>" class="back-btn">← Back to Setlists</a>
		</div>
		
		<div class="content">
			<div class="stats">
				<?php echo $model->TotalCount; ?> PDF file<?php echo $model->TotalCount != 1 ? 's' : ''; ?> found
			</div>
			
			<?php if (empty($model->PDFs)): ?>
				<div class="no-pdfs">
					<h3>No PDF files found</h3>
					<p>Create PDFs from your setlists to see them here!</p>
				</div>
			<?php else: ?>
				<table class="pdf-table" id="pdfTable">
					<thead>
						<tr>
							<th class="sortable" data-sort="filename">Filename</th>
							<th class="sortable" data-sort="setlist">Setlist</th>
							<th class="sortable" data-sort="type">Type</th>
							<th class="sortable" data-sort="size">Size</th>
							<th class="sortable" data-sort="date">Date Created</th>
							<th>Actions</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($model->PDFs as $pdf): ?>
							<tr data-filename="<?php echo htmlspecialchars($pdf['filename']); ?>"
								data-setlist="<?php echo htmlspecialchars(strtolower($pdf['setlist_name'])); ?>"
								data-type="<?php echo htmlspecialchars(strtolower($pdf['filetype'])); ?>"
								data-size="<?php echo $pdf['filesize']; ?>"
								data-date="<?php echo $pdf['filetime']; ?>">
								<td>
									<a href="<?php echo Ugs::MakeUri(Actions::DownloadPDF) . '?file=' . urlencode($pdf['filename']) . '&view=1'; ?>" class="setlist-name" target="_blank">
										<?php echo htmlspecialchars($pdf['filename']); ?>
									</a>
								</td>
								<td><?php echo htmlspecialchars($pdf['setlist_name']); ?></td>
								<td>
									<span class="file-type <?php echo strtolower($pdf['filetype']); ?>">
										<?php echo htmlspecialchars($pdf['filetype']); ?>
									</span>
								</td>
								<td class="file-size"><?php echo htmlspecialchars($pdf['filesize_formatted']); ?></td>
								<td><?php echo htmlspecialchars($pdf['filedate']); ?></td>
								<td>
									<a href="<?php echo Ugs::MakeUri(Actions::DownloadPDF) . '?file=' . urlencode($pdf['filename']); ?>" class="download-btn" download>
										📥 Download
									</a>
								</td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif; ?>
		</div>
	</div>

	<script>
		let currentSort = { column: 'date', direction: 'desc' };
		
		// Initialize sorting
		document.addEventListener('DOMContentLoaded', function() {
			// Set initial sort indicator
			updateSortIndicator('date', 'desc');
			
			// Add click handlers to sortable headers
			document.querySelectorAll('.sortable').forEach(header => {
				header.addEventListener('click', function() {
					const column = this.getAttribute('data-sort');
					const direction = (currentSort.column === column && currentSort.direction === 'asc') ? 'desc' : 'asc';
					sortTable(column, direction);
				});
			});
		});
		
		// Sort table function
		function sortTable(column, direction) {
			const tbody = document.querySelector('#pdfTable tbody');
			const rows = Array.from(tbody.querySelectorAll('tr'));
			
			rows.sort((a, b) => {
				let aValue = a.getAttribute('data-' + column);
				let bValue = b.getAttribute('data-' + column);
				
				// Handle different data types
				if (column === 'size' || column === 'date') {
					aValue = parseInt(aValue);
					bValue = parseInt(bValue);
				} else {
					aValue = aValue.toLowerCase();
					bValue = bValue.toLowerCase();
				}
				
				if (direction === 'asc') {
					return aValue > bValue ? 1 : -1;
				} else {
					return aValue < bValue ? 1 : -1;
				}
			});
			
			// Reorder rows
			rows.forEach(row => tbody.appendChild(row));
			
			// Update sort indicator
			updateSortIndicator(column, direction);
			currentSort = { column, direction };
		}
		
		// Update sort indicator
		function updateSortIndicator(column, direction) {
			// Remove all sort indicators
			document.querySelectorAll('.sortable').forEach(header => {
				header.classList.remove('sort-asc', 'sort-desc');
			});
			
			// Add indicator to current column
			const currentHeader = document.querySelector(`[data-sort="${column}"]`);
			if (currentHeader) {
				currentHeader.classList.add('sort-' + direction);
			}
		}
	</script>
</body>
</html> 