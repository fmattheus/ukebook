<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>Saved Setlists - <?php echo($model->PageTitle); ?></title>
	<meta name="generator" content="<?php echo($model->PoweredBy) ?>" />
	<link rel="stylesheet" href="<?php echo($model->StaticsPrefix); ?>css/ugsEditorPlus.merged.css" title="ugsEditorCss" />
	<link rel="stylesheet" href="<?php echo($model->StaticsPrefix); ?>css/ugsphp.css" />
	<style>
		.setlist-container {
			max-width: 1400px;
			margin: 0 auto;
			padding: 20px;
		}
		
		.setlist-header {
			margin-bottom: 30px;
		}
		
		.header-controls {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 20px;
			flex-wrap: wrap;
			gap: 15px;
		}
		
		.header-left {
			display: flex;
			align-items: center;
			gap: 15px;
		}
		
		.header-right {
			display: flex;
			gap: 10px;
		}
		
		.search-controls {
			display: flex;
			gap: 15px;
			align-items: center;
			margin-bottom: 20px;
			flex-wrap: wrap;
		}
		
		.search-box {
			flex: 1;
			min-width: 300px;
		}
		
		.search-box input {
			width: 100%;
			padding: 10px;
			border: 1px solid #ccc;
			border-radius: 4px;
			font-size: 14px;
		}
		
		.search-options {
			display: flex;
			align-items: center;
			gap: 10px;
			margin-top: 8px;
		}
		
		.toggle-switch {
			position: relative;
			display: inline-block;
			width: 50px;
			height: 24px;
		}
		
		.toggle-switch input {
			opacity: 0;
			width: 0;
			height: 0;
		}
		
		.toggle-slider {
			position: absolute;
			cursor: pointer;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			background-color: #ccc;
			transition: .4s;
			border-radius: 24px;
		}
		
		.toggle-slider:before {
			position: absolute;
			content: "";
			height: 18px;
			width: 18px;
			left: 3px;
			bottom: 3px;
			background-color: white;
			transition: .4s;
			border-radius: 50%;
		}
		
		input:checked + .toggle-slider {
			background-color: #007cba;
		}
		
		input:checked + .toggle-slider:before {
			transform: translateX(26px);
		}
		
		.toggle-label {
			font-size: 12px;
			color: #666;
			white-space: nowrap;
		}
		
		.btn {
			padding: 8px 16px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			text-decoration: none;
			display: inline-block;
			font-size: 14px;
			transition: opacity 0.2s;
		}
		
		.btn:hover {
			opacity: 0.8;
		}
		
		.btn-primary {
			background: #007cba;
			color: white;
		}
		
		.btn-success {
			background: #28a745;
			color: white;
		}
		
		.btn-danger {
			background: #dc3545;
			color: white;
		}
		
		.btn-secondary {
			background: #6c757d;
			color: white;
		}
		
		.setlist-table {
			width: 100%;
			border-collapse: collapse;
			background: white;
			border-radius: 8px;
			overflow: hidden;
			box-shadow: 0 2px 8px rgba(0,0,0,0.1);
		}
		
		.setlist-table th {
			background: #f8f9fa;
			padding: 12px 15px;
			text-align: left;
			font-weight: 600;
			color: #495057;
			border-bottom: 2px solid #dee2e6;
			cursor: pointer;
			user-select: none;
			position: relative;
		}
		
		.setlist-table th:hover {
			background: #e9ecef;
		}
		
		.setlist-table th.sortable::after {
			content: '↕';
			position: absolute;
			right: 8px;
			color: #6c757d;
			font-size: 12px;
		}
		
		.setlist-table th.sort-asc::after {
			content: '↑';
			color: #007cba;
		}
		
		.setlist-table th.sort-desc::after {
			content: '↓';
			color: #007cba;
		}
		
		.setlist-table td {
			padding: 12px 15px;
			border-bottom: 1px solid #dee2e6;
			vertical-align: middle;
		}
		
		.setlist-table tr:hover {
			background: #f8f9fa;
		}
		
		.setlist-table tr:last-child td {
			border-bottom: none;
		}
		
		.setlist-name {
			font-weight: 600;
			color: #333;
		}
		
		.setlist-meta {
			color: #666;
			font-size: 0.9em;
		}
		
		.actions-cell {
			white-space: nowrap;
		}
		
		.actions-cell .btn {
			margin-right: 5px;
			padding: 6px 12px;
			font-size: 12px;
		}
		
		.actions-cell .btn:last-child {
			margin-right: 0;
		}
		
		.no-setlists {
			text-align: center;
			padding: 40px;
			color: #666;
			font-style: italic;
			background: white;
			border-radius: 8px;
			box-shadow: 0 2px 8px rgba(0,0,0,0.1);
		}
		
		.results-info {
			margin-bottom: 15px;
			color: #666;
			font-size: 14px;
		}
		
		@media (max-width: 768px) {
			.setlist-table {
				font-size: 12px;
			}
			
			.setlist-table th,
			.setlist-table td {
				padding: 8px 10px;
			}
			
			.actions-cell .btn {
				padding: 4px 8px;
				font-size: 11px;
			}
			
			.header-controls {
				flex-direction: column;
				align-items: stretch;
			}
			
			.search-controls {
				flex-direction: column;
			}
			
			.search-box {
				min-width: auto;
			}
		}
	</style>
</head>
<body>
	<div class="setlist-container">
		<div class="setlist-header">
			<div class="header-controls">
				<div class="header-left">
					<button onclick="window.location.href='<?php echo Ugs::MakeUri(Actions::Songbook); ?>'" class="btn btn-primary">← Back to Songbook</button>
					<div>
						<h1 style="margin: 0; font-size: 24px;">Saved Setlists</h1>
						<div class="results-info" id="resultsInfo">
							<?php echo count($model->Setlists); ?> setlist<?php echo count($model->Setlists) != 1 ? 's' : ''; ?> found
						</div>
					</div>
				</div>
				<div class="header-right">
					<button onclick="window.location.href='<?php echo Ugs::MakeUri(Actions::Setlist); ?>'" class="btn btn-success">➕ Create New Setlist</button>
					<button onclick="window.location.href='<?php echo Ugs::MakeUri(Actions::ListPDFs); ?>'" class="btn btn-secondary">📄 View PDFs</button>
				</div>
			</div>
			
			<div class="search-controls">
				<div class="search-box">
					<input type="text" id="setlistSearch" placeholder="Search setlist names..." />
					<div class="search-options">
						<label class="toggle-switch">
							<input type="checkbox" id="searchSongsToggle">
							<span class="toggle-slider"></span>
						</label>
						<span class="toggle-label">Also search song & artist names</span>
					</div>
				</div>
			</div>
		</div>
		
		<?php if (empty($model->Setlists)): ?>
			<div class="no-setlists">
				<h3>No saved setlists found</h3>
				<p>Create your first setlist in the <a href="<?php echo Ugs::MakeUri(Actions::Setlist); ?>">Setlist Manager</a>!</p>
			</div>
		<?php else: ?>
			<table class="setlist-table" id="setlistTable">
				<thead>
					<tr>
						<th class="sortable" data-sort="name">Setlist Name</th>
						<th class="sortable" data-sort="songs">Songs</th>
						<th class="sortable" data-sort="date">Created</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody id="setlistTableBody">
					<?php foreach($model->Setlists as $setlist): ?>
						<tr data-name="<?php echo htmlspecialchars(strtolower($setlist['name'])); ?>"
							data-songs="<?php echo $setlist['songCount']; ?>"
							data-created="<?php echo htmlspecialchars($setlist['created']); ?>"
							data-timestamp="<?php echo strtotime($setlist['created']); ?>"
							data-song-artist="<?php echo htmlspecialchars(strtolower(implode(' ', array_map(function($song) { return ($song['Title'] ?? '') . ' ' . ($song['Artist'] ?? ''); }, $setlist['songs'])))); ?>">
							<td class="setlist-name"><?php echo htmlspecialchars($setlist['name']); ?></td>
							<td class="setlist-meta"><?php echo $setlist['songCount']; ?> song<?php echo $setlist['songCount'] != 1 ? 's' : ''; ?></td>
							<td class="setlist-meta"><?php echo htmlspecialchars($setlist['created']); ?></td>
							<td class="actions-cell">
								<button class="btn btn-primary" onclick="loadSetlist(<?php echo htmlspecialchars(json_encode($setlist['songs'])); ?>, '<?php echo htmlspecialchars($setlist['name']); ?>')" title="Edit Setlist">Edit</button>
								<button class="btn btn-success" onclick="startSetlistWithId(<?php echo htmlspecialchars(json_encode($setlist['songs'])); ?>, '<?php echo htmlspecialchars($setlist['filename']); ?>')" title="Start Setlist">Start</button>
								<button class="btn btn-secondary" onclick="createPDF('<?php echo htmlspecialchars($setlist['filename']); ?>', '<?php echo htmlspecialchars($setlist['name']); ?>')" title="Create PDF">PDF</button>
								<?php if ($model->CanEdit): ?>
									<button class="btn btn-danger" onclick="deleteSetlist('<?php echo htmlspecialchars($setlist['filename']); ?>', '<?php echo htmlspecialchars($setlist['name']); ?>')" title="Delete Setlist">Del</button>
								<?php endif; ?>
							</td>
						</tr>
					<?php endforeach; ?>
				</tbody>
			</table>
		<?php endif; ?>
	</div>

	<script>
		let allSetlists = []; // Store all setlists for sorting
		let currentSort = { column: 'date', direction: 'desc' };
		
		// Initialize all setlists array on page load
		document.addEventListener('DOMContentLoaded', function() {
			const setlistRows = document.querySelectorAll('#setlistTableBody tr');
			allSetlists = Array.from(setlistRows);
			
			// Set up sortable column headers
			document.querySelectorAll('.sortable').forEach(header => {
				header.addEventListener('click', function() {
					const column = this.getAttribute('data-sort');
					
					// Update sort direction
					if (currentSort.column === column) {
						currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
					} else {
						currentSort.column = column;
						currentSort.direction = 'asc';
					}
					
					// Update visual indicators
					document.querySelectorAll('.sortable').forEach(h => {
						h.classList.remove('sort-asc', 'sort-desc');
					});
					this.classList.add('sort-' + currentSort.direction);
					
					// Sort the table
					sortSetlists();
				});
			});
			
			// Initial sort by date descending
			document.querySelector('[data-sort="date"]').classList.add('sort-desc');
		});
		
		// Sort functionality
		function sortSetlists() {
			const tbody = document.getElementById('setlistTableBody');
			const visibleSetlists = Array.from(tbody.querySelectorAll('tr:not([style*="display: none"])'));
			
			// Sort the visible setlists
			visibleSetlists.sort((a, b) => {
				let aVal, bVal;
				
				switch(currentSort.column) {
					case 'name':
						aVal = a.getAttribute('data-name');
						bVal = b.getAttribute('data-name');
						return currentSort.direction === 'asc' ? 
							aVal.localeCompare(bVal) : bVal.localeCompare(aVal);
					case 'songs':
						aVal = parseInt(a.getAttribute('data-songs'));
						bVal = parseInt(b.getAttribute('data-songs'));
						return currentSort.direction === 'asc' ? aVal - bVal : bVal - aVal;
					case 'date':
						aVal = parseInt(a.getAttribute('data-timestamp'));
						bVal = parseInt(b.getAttribute('data-timestamp'));
						return currentSort.direction === 'asc' ? aVal - bVal : bVal - aVal;
					default:
						return 0;
				}
			});
			
			// Reorder the DOM elements
			visibleSetlists.forEach(row => {
				tbody.appendChild(row);
			});
		}
		
		// Search functionality
		document.getElementById('setlistSearch').addEventListener('input', function() {
			performSearch();
		});
		
		// Toggle switch functionality
		document.getElementById('searchSongsToggle').addEventListener('change', function() {
			performSearch();
		});
		
		function performSearch() {
			const searchTerm = document.getElementById('setlistSearch').value.toLowerCase().trim();
			const searchSongs = document.getElementById('searchSongsToggle').checked;
			const setlistRows = document.querySelectorAll('#setlistTableBody tr');
			let visibleCount = 0;
			
			setlistRows.forEach(row => {
				const setName = row.getAttribute('data-name');
				let shouldShow = setName.includes(searchTerm);
				
				// If toggle is on, also search through song and artist names
				if (searchSongs && !shouldShow && searchTerm !== '') {
					const songArtistData = row.getAttribute('data-song-artist');
					if (songArtistData && songArtistData.includes(searchTerm)) {
						shouldShow = true;
					}
				}
				
				if (shouldShow) {
					row.style.display = '';
					visibleCount++;
				} else {
					row.style.display = 'none';
				}
			});
			
			// Update the count display
			const resultsInfo = document.getElementById('resultsInfo');
			if (resultsInfo) {
				if (searchTerm === '') {
					resultsInfo.textContent = '<?php echo count($model->Setlists); ?> setlist<?php echo count($model->Setlists) != 1 ? 's' : ''; ?> found';
				} else {
					const searchType = searchSongs ? ' (including songs & artists)' : '';
					resultsInfo.textContent = visibleCount + ' setlist' + (visibleCount != 1 ? 's' : '') + ' found for "' + searchTerm + '"' + searchType;
				}
			}
			
			// Re-sort the visible setlists after search
			setTimeout(sortSetlists, 10);
		}
		
		// Load setlist into the setlist manager
		function loadSetlist(songs, name) {
			// Store the songs in localStorage
			localStorage.setItem('ukeBookSetlist', JSON.stringify(songs));
			
			// Store the setlist name in localStorage
			localStorage.setItem('ukeBookSetlistName', name);
			
			// Redirect to setlist manager
			window.location.href = '<?php echo Ugs::MakeUri(Actions::Setlist); ?>';
		}
		
		// Start a setlist by redirecting to the first song using its id
		function startSetlistWithId(songs, filename) {
			if (!songs || songs.length === 0) {
				alert('No songs in setlist!');
				return;
			}
			var firstSong = songs[0];
			var songId = null;
			
			// Try to get song ID from various possible field formats
			if (firstSong.id) {
				songId = firstSong.id;
			} else if (firstSong.Id) {
				songId = firstSong.Id;
			} else if (firstSong.ID) {
				songId = firstSong.ID;
			} else if (firstSong.Uri) {
				// Extract filename from URI
				var uri = firstSong.Uri;
				var pathParts = uri.split('/');
				var lastPart = pathParts[pathParts.length - 1];
				// Remove any query parameters
				songId = lastPart.split('?')[0];
				// If it doesn't end with .cpm.txt, add it
				if (!songId.endsWith('.cpm.txt')) {
					songId += '.cpm.txt';
				}
			} else if (firstSong.uri) {
				// Extract filename from URI (lowercase)
				var uri = firstSong.uri;
				var pathParts = uri.split('/');
				var lastPart = pathParts[pathParts.length - 1];
				// Remove any query parameters
				songId = lastPart.split('?')[0];
				// If it doesn't end with .cpm.txt, add it
				if (!songId.endsWith('.cpm.txt')) {
					songId += '.cpm.txt';
				}
			}
			
			if (!songId) {
				alert('First song does not have an id or Uri!');
				return;
			}
			
			// For mod_rewrite, the URL should be: /songbook/songId?setlist=filename&setlist_index=0
			// Remove .cpm.txt extension from songId for the URL
			var urlSongId = songId;
			if (urlSongId.endsWith('.cpm.txt')) {
				urlSongId = urlSongId.slice(0, -8); // Remove '.cpm.txt'
			}
			var url = '<?php echo Ugs::MakeUri(Actions::Song, ''); ?>' + encodeURIComponent(urlSongId);
			url += '?setlist=' + encodeURIComponent(filename) + '&setlist_index=0';
			window.location.href = url;
		}
		
		// Delete a setlist
		function deleteSetlist(filename, name) {
			if (confirm('Are you sure you want to delete the setlist "' + name + '"? This action cannot be undone.')) {
				// Send AJAX request to delete the file
				fetch('<?php echo Ugs::MakeUri(Actions::DeleteSetlist); ?>', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
					},
					body: JSON.stringify({
						filename: filename
					})
				})
				.then(response => response.json())
				.then(result => {
					if (result.success) {
						alert('Setlist deleted successfully!');
						location.reload();
					} else {
						alert('Error deleting setlist: ' + result.message);
					}
				})
				.catch(error => {
					console.error('Error:', error);
					alert('Error deleting setlist. Please try again.');
				});
			}
		}
		
		// Create PDF for a setlist
		function createPDF(filename, name) {
			if (confirm('Create PDF files for "' + name + '"? This will generate both print and tablet versions.\n\n⚠️ WARNING: This process may take 10+ minutes. Please be patient and do not close this page.')) {
				// Show loading overlay
				showLoadingOverlay('Creating PDF files...\n\nThis may take 10+ minutes.\nPlease do not close this page.');
				
				// Send AJAX request to create PDF
				fetch('<?php echo Ugs::MakeUri(Actions::CreatePDF); ?>', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json',
					},
					body: JSON.stringify({
						filename: filename,
						name: name
					})
				})
				.then(response => response.json())
				.then(result => {
					hideLoadingOverlay();
					if (result.Success) {
						alert('✅ PDF files created successfully!\n\n📄 Print version: ' + result.PrintFile + '\n📱 Tablet version: ' + result.TabletFile);
					} else {
						alert('❌ Error creating PDF: ' + result.ErrorMessage);
					}
				})
				.catch(error => {
					hideLoadingOverlay();
					console.error('Error:', error);
					alert('❌ Error creating PDF. Please try again.');
				});
			}
		}
		
		// Show loading overlay with message
		function showLoadingOverlay(message) {
			// Create overlay if it doesn't exist
			if (!document.getElementById('loadingOverlay')) {
				const overlay = document.createElement('div');
				overlay.id = 'loadingOverlay';
				overlay.style.cssText = `
					position: fixed;
					top: 0;
					left: 0;
					width: 100%;
					height: 100%;
					background: rgba(0, 0, 0, 0.8);
					z-index: 9999;
					display: flex;
					justify-content: center;
					align-items: center;
					flex-direction: column;
				`;
				
				const spinner = document.createElement('div');
				spinner.style.cssText = `
					width: 50px;
					height: 50px;
					border: 5px solid #f3f3f3;
					border-top: 5px solid #3498db;
					border-radius: 50%;
					animation: spin 1s linear infinite;
					margin-bottom: 20px;
				`;
				
				const messageDiv = document.createElement('div');
				messageDiv.style.cssText = `
					color: white;
					font-size: 18px;
					text-align: center;
					white-space: pre-line;
					max-width: 400px;
					line-height: 1.5;
				`;
				messageDiv.textContent = message;
				
				overlay.appendChild(spinner);
				overlay.appendChild(messageDiv);
				document.body.appendChild(overlay);
				
				// Add CSS animation
				const style = document.createElement('style');
				style.textContent = `
					@keyframes spin {
						0% { transform: rotate(0deg); }
						100% { transform: rotate(360deg); }
					}
				`;
				document.head.appendChild(style);
			} else {
				// Update existing overlay message
				const messageDiv = document.querySelector('#loadingOverlay div:last-child');
				if (messageDiv) {
					messageDiv.textContent = message;
				}
				document.getElementById('loadingOverlay').style.display = 'flex';
			}
		}
		
		// Hide loading overlay
		function hideLoadingOverlay() {
			const overlay = document.getElementById('loadingOverlay');
			if (overlay) {
				overlay.style.display = 'none';
			}
		}
	</script>
</body>
</html>