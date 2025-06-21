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
			max-width: 1200px;
			margin: 0 auto;
			padding: 20px;
		}
		
		.setlist-header {
			text-align: center;
			margin-bottom: 30px;
		}
		
		.setlist-grid {
			display: grid;
			grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
			gap: 20px;
		}
		
		.setlist-card {
			border: 1px solid #ddd;
			border-radius: 8px;
			padding: 20px;
			background: white;
			box-shadow: 0 2px 4px rgba(0,0,0,0.1);
		}
		
		.setlist-card h3 {
			margin: 0 0 10px 0;
			color: #333;
			font-size: 1.2em;
		}
		
		.setlist-meta {
			color: #666;
			font-size: 0.9em;
			margin-bottom: 15px;
		}
		
		.setlist-songs {
			max-height: 200px;
			overflow-y: auto;
			margin-bottom: 15px;
			border: 1px solid #eee;
			border-radius: 4px;
			padding: 10px;
			background: #f9f9f9;
		}
		
		.setlist-song {
			padding: 5px 0;
			border-bottom: 1px solid #eee;
		}
		
		.setlist-song:last-child {
			border-bottom: none;
		}
		
		.setlist-actions {
			display: flex;
			gap: 10px;
			flex-wrap: wrap;
		}
		
		.btn {
			padding: 8px 12px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			text-decoration: none;
			display: inline-block;
			font-size: 0.9em;
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
		
		.btn:hover {
			opacity: 0.8;
		}
		
		.no-setlists {
			text-align: center;
			padding: 40px;
			color: #666;
			font-style: italic;
		}
		
		.navigation {
			text-align: center;
			margin-bottom: 20px;
		}
		
		.navigation a {
			display: inline-block;
			padding: 10px 20px;
			margin: 0 10px;
			background: #007cba;
			color: white;
			text-decoration: none;
			border-radius: 4px;
		}
		
		.navigation a:hover {
			background: #005a87;
		}
	</style>
</head>
<body>
	<div class="setlist-container">
		<div class="setlist-header">
			<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
				<button onclick="window.location.href='<?php echo Ugs::MakeUri(Actions::Songbook); ?>'" style="background: #007cba; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; font-size: 14px;">← Back to Songbook</button>
				<div style="text-align: center;">
					<h1>Saved Setlists</h1>
					<p><?php echo count($model->Setlists); ?> setlist<?php echo count($model->Setlists) != 1 ? 's' : ''; ?> found</p>
				</div>
				<div style="display: flex; gap: 10px;">
					<button onclick="window.location.href='<?php echo Ugs::MakeUri(Actions::Setlist); ?>'" style="background: #28a745; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; font-size: 14px;">➕ Create New Setlist</button>
					<button onclick="window.location.href='<?php echo Ugs::MakeUri(Actions::ListPDFs); ?>'" style="background: #6f42c1; color: white; border: none; padding: 8px 16px; border-radius: 4px; cursor: pointer; font-size: 14px;">📄 View PDFs</button>
				</div>
			</div>
			
			<div class="search-container" style="margin: 20px 0;">
				<div style="display: flex; gap: 15px; align-items: center; justify-content: center; flex-wrap: wrap;">
					<input type="text" id="setlistSearch" placeholder="Search setlist names or song names..." style="width: 100%; max-width: 400px; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 16px;">
					<select id="sortSelect" style="padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-size: 16px; background: white;">
						<option value="date-desc">Newest First</option>
						<option value="date-asc">Oldest First</option>
						<option value="name-asc">Name A-Z</option>
						<option value="name-desc">Name Z-A</option>
					</select>
				</div>
			</div>
		</div>
		
		<?php if (empty($model->Setlists)): ?>
			<div class="no-setlists">
				<h3>No saved setlists found</h3>
				<p>Create your first setlist in the <a href="<?php echo Ugs::MakeUri(Actions::Setlist); ?>">Setlist Manager</a>!</p>
			</div>
		<?php else: ?>
			<div class="setlist-grid" id="setlistGrid">
				<?php foreach($model->Setlists as $setlist): ?>
					<div class="setlist-card" 
						 data-name="<?php echo htmlspecialchars(strtolower($setlist['name'])); ?>"
						 data-songs="<?php echo htmlspecialchars(strtolower(implode(' ', array_map(function($song) { return $song['Title'] . ' ' . $song['Artist']; }, $setlist['songs'])))); ?>"
						 data-created="<?php echo htmlspecialchars($setlist['created']); ?>"
						 data-timestamp="<?php echo strtotime($setlist['created']); ?>">
						<h3><?php echo htmlspecialchars($setlist['name']); ?></h3>
						<div class="setlist-meta">
							<strong><?php echo $setlist['songCount']; ?> song<?php echo $setlist['songCount'] != 1 ? 's' : ''; ?></strong><br>
							Created: <?php echo htmlspecialchars($setlist['created']); ?>
						</div>
						
						<div class="setlist-songs">
							<?php foreach($setlist['songs'] as $song): ?>
								<div class="setlist-song">
									<strong><?php echo htmlspecialchars($song['Title']); ?></strong>
									<?php if (!empty($song['Artist'])): ?>
										<br><em><?php echo htmlspecialchars($song['Artist']); ?></em>
									<?php endif; ?>
								</div>
							<?php endforeach; ?>
						</div>
						
						<div class="setlist-actions">
							<button class="btn btn-primary" onclick="loadSetlist(<?php echo htmlspecialchars(json_encode($setlist['songs'])); ?>, '<?php echo htmlspecialchars($setlist['name']); ?>')">Edit Setlist</button>
							<button class="btn btn-success" onclick="createPDF('<?php echo htmlspecialchars($setlist['filename']); ?>', '<?php echo htmlspecialchars($setlist['name']); ?>')">Create PDFs</button>
							<?php if ($model->CanEdit): ?>
								<button class="btn btn-danger" onclick="deleteSetlist('<?php echo htmlspecialchars($setlist['filename']); ?>', '<?php echo htmlspecialchars($setlist['name']); ?>')">Delete</button>
							<?php endif; ?>
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>

	<script>
		let allSetlists = []; // Store all setlists for sorting
		
		// Initialize all setlists array on page load
		document.addEventListener('DOMContentLoaded', function() {
			const setlistCards = document.querySelectorAll('#setlistGrid .setlist-card');
			allSetlists = Array.from(setlistCards);
		});
		
		// Sort functionality
		function sortSetlists() {
			const sortValue = document.getElementById('sortSelect').value;
			const setlistGrid = document.getElementById('setlistGrid');
			const visibleSetlists = Array.from(setlistGrid.querySelectorAll('.setlist-card:not([style*="display: none"])'));
			
			// Sort the visible setlists
			visibleSetlists.sort((a, b) => {
				switch(sortValue) {
					case 'date-desc':
						return parseInt(b.getAttribute('data-timestamp')) - parseInt(a.getAttribute('data-timestamp'));
					case 'date-asc':
						return parseInt(a.getAttribute('data-timestamp')) - parseInt(b.getAttribute('data-timestamp'));
					case 'name-asc':
						return a.getAttribute('data-name').localeCompare(b.getAttribute('data-name'));
					case 'name-desc':
						return b.getAttribute('data-name').localeCompare(a.getAttribute('data-name'));
					default:
						return 0;
				}
			});
			
			// Reorder the DOM elements
			visibleSetlists.forEach(card => {
				setlistGrid.appendChild(card);
			});
		}
		
		// Search functionality
		document.getElementById('setlistSearch').addEventListener('input', function() {
			const searchTerm = this.value.toLowerCase().trim();
			const setlistCards = document.querySelectorAll('#setlistGrid .setlist-card');
			let visibleCount = 0;
			
			setlistCards.forEach(card => {
				const setName = card.getAttribute('data-name');
				const setSongs = card.getAttribute('data-songs');
				
				// Search in both setlist name and song names/artists
				if (setName.includes(searchTerm) || setSongs.includes(searchTerm)) {
					card.style.display = 'block';
					visibleCount++;
				} else {
					card.style.display = 'none';
				}
			});
			
			// Update the count display
			const countElement = document.querySelector('.setlist-header p');
			if (countElement) {
				if (searchTerm === '') {
					countElement.textContent = '<?php echo count($model->Setlists); ?> setlist<?php echo count($model->Setlists) != 1 ? 's' : ''; ?> found';
				} else {
					countElement.textContent = visibleCount + ' setlist' + (visibleCount != 1 ? 's' : '') + ' found for "' + searchTerm + '"';
				}
			}
			
			// Re-sort the visible setlists after search
			setTimeout(sortSetlists, 10);
		});
		
		// Sort event listener
		document.getElementById('sortSelect').addEventListener('change', sortSetlists);
		
		// Load setlist into the setlist manager
		function loadSetlist(songs, name) {
			// Store the songs in localStorage
			localStorage.setItem('ukeBookSetlist', JSON.stringify(songs));
			
			// Store the setlist name in localStorage
			localStorage.setItem('ukeBookSetlistName', name);
			
			// Redirect to setlist manager
			window.location.href = '<?php echo Ugs::MakeUri(Actions::Setlist); ?>';
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