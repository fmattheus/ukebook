<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title><?php echo($model->PageTitle); ?></title>
	<meta name="generator" content="<?php echo($model->PoweredBy) ?>" />
	<link rel="stylesheet" type="text/css" href="css/yuiReset.css" />
	<link rel="stylesheet" type="text/css" href="css/basic-page-layout.css" media="all" />
	<style>
		.setlist-container {
			display: flex;
			gap: 20px;
			max-width: 1200px;
			margin: 0 auto;
			padding: 20px;
		}
		
		.song-list-section {
			flex: 1;
			background: #f5f5f5;
			padding: 20px;
			border-radius: 8px;
		}
		
		.setlist-section {
			flex: 1;
			background: #e8f4f8;
			padding: 20px;
			border-radius: 8px;
		}
		
		.search-box {
			width: 100%;
			padding: 10px;
			margin-bottom: 15px;
			border: 1px solid #ddd;
			border-radius: 4px;
			font-size: 16px;
		}
		
		.song-item {
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding: 8px 12px;
			margin: 5px 0;
			background: white;
			border-radius: 4px;
			border: 1px solid #ddd;
			cursor: default;
		}
		
		.song-item:hover {
			background: #f0f0f0;
		}
		
		.song-info {
			flex: 1;
			display: flex;
			flex-direction: column;
		}
		
		.song-artist {
			font-size: 12px;
			color: #666;
			margin-top: 2px;
		}
		
		/* Drag and drop styles */
		.setlist-song-item {
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding: 8px 12px;
			margin: 5px 0;
			background: white;
			border-radius: 4px;
			border: 1px solid #ddd;
			cursor: grab;
			transition: all 0.2s ease;
			position: relative;
		}
		
		.setlist-song-item:hover {
			background: #f0f0f0;
			box-shadow: 0 2px 4px rgba(0,0,0,0.1);
		}
		
		.setlist-song-item:active {
			cursor: grabbing;
		}
		
		.setlist-song-item.dragging {
			opacity: 0.5;
			transform: rotate(2deg);
			box-shadow: 0 4px 8px rgba(0,0,0,0.2);
		}
		
		.setlist-song-item.drag-over {
			border-top: 3px solid #007cba;
			margin-top: 8px;
		}
		
		.setlist-song-item.selected {
			background-color: #e3f2fd !important;
			border-color: #2196f3 !important;
			box-shadow: 0 0 0 2px rgba(33, 150, 243, 0.2);
		}
		
		.drag-handle {
			cursor: grab;
			padding: 4px 8px;
			margin-right: 8px;
			color: #666;
			font-size: 14px;
			user-select: none;
			background: #f8f9fa;
			border-radius: 3px;
			border: 1px solid #dee2e6;
		}
		
		.drag-handle:hover {
			background: #e9ecef;
			color: #495057;
		}
		
		.drag-handle:active {
			cursor: grabbing;
		}
		
		.song-position {
			font-size: 12px;
			color: #666;
			margin-right: 8px;
			min-width: 20px;
			text-align: center;
			font-weight: bold;
		}
		
		.edit-indicator {
			display: none;
			color: #007cba;
			font-size: 12px;
			margin-right: 8px;
			cursor: pointer;
		}
		
		.setlist-song-item:hover .edit-indicator {
			display: inline;
		}
		
		.setlist-container.edit-mode .edit-indicator {
			display: inline;
		}
		
		.move-controls {
			display: none; /* Hidden by default */
			align-items: center;
			gap: 4px;
			margin-right: 8px;
		}
		
		.move-btn {
			padding: 2px 6px;
			border: 1px solid #ccc;
			background: #f8f9fa;
			color: #666;
			cursor: pointer;
			border-radius: 3px;
			font-size: 10px;
			line-height: 1;
		}
		
		.move-btn:hover {
			background: #e9ecef;
			color: #495057;
		}
		
		.move-btn:disabled {
			opacity: 0.5;
			cursor: not-allowed;
		}
		
		.move-to-position {
			display: none; /* Hidden by default */
			align-items: center;
			gap: 4px;
			margin-right: 8px;
		}
		
		.move-to-input {
			width: 50px;
			padding: 2px 4px;
			border: 1px solid #ccc;
			border-radius: 3px;
			font-size: 12px;
			text-align: center;
		}
		
		.move-to-btn {
			padding: 2px 6px;
			border: 1px solid #007cba;
			background: #007cba;
			color: white;
			cursor: pointer;
			border-radius: 3px;
			font-size: 10px;
			line-height: 1;
		}
		
		.move-to-btn:hover {
			background: #005a87;
		}
		
		.song-title {
			flex: 1;
			text-decoration: none;
			color: #333;
		}
		
		.song-title:hover {
			color: #007cba;
		}
		
		.add-btn, .remove-btn {
			padding: 5px 10px;
			border: none;
			border-radius: 3px;
			cursor: pointer;
			font-size: 12px;
			margin-left: 10px;
		}
		
		.add-btn {
			background: #28a745;
			color: white;
		}
		
		.add-btn:hover {
			background: #218838;
		}
		
		.remove-btn {
			background: #dc3545;
			color: white;
		}
		
		.remove-btn:hover {
			background: #c82333;
		}
		
		.setlist-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 15px;
		}
		
		.setlist-name {
			font-size: 18px;
			font-weight: bold;
			color: #333;
		}
		
		.clear-btn {
			padding: 8px 16px;
			background: #6c757d;
			color: white;
			border: none;
			border-radius: 4px;
			cursor: pointer;
		}
		
		.clear-btn:hover {
			background: #5a6268;
		}
		
		.section-title {
			font-size: 20px;
			font-weight: bold;
			margin-bottom: 15px;
			color: #333;
		}
		
		.song-count {
			font-size: 14px;
			color: #666;
			margin-bottom: 15px;
		}
		
		.no-songs {
			text-align: center;
			color: #666;
			font-style: italic;
			padding: 20px;
		}
		
		.nav-links {
			text-align: center;
			margin-bottom: 20px;
		}
		
		.nav-links a {
			display: inline-block;
			padding: 10px 20px;
			margin: 0 10px;
			background: #007cba;
			color: white;
			text-decoration: none;
			border-radius: 4px;
		}
		
		.nav-links a:hover {
			background: #005a87;
		}
		
		.drag-instructions {
			font-size: 12px;
			color: #666;
			margin-bottom: 10px;
			font-style: italic;
		}
		
		.keyboard-shortcuts {
			font-size: 11px;
			color: #888;
			margin-top: 5px;
			font-style: italic;
		}
		
		/* Show controls when song item is hovered or has show-controls class */
		.setlist-song-item:hover .move-to-position,
		.setlist-song-item.show-controls .move-to-position {
			display: flex;
		}
		
		/* Show controls when in edit mode */
		.setlist-container.edit-mode .move-to-position {
			display: flex;
		}
	</style>
</head>
<body>
	<div class="setlist-container">
		<div class="song-list-section">
			<h2 class="section-title">Available Songs</h2>
			<input type="text" id="searchBox" class="search-box" placeholder="Search songs..." />
			<div class="song-count" id="songCount"><?php echo(count($model->SongList)); ?> songs available</div>
			
			<div id="songList">
				<?php foreach($model->SongList as $song): ?>
					<div class="song-item" data-title="<?php echo htmlspecialchars($song->Title); ?>" data-artist="<?php echo htmlspecialchars($song->Artist); ?>">
						<div class="song-info">
							<a href="<?php echo($song->Uri); ?>" class="song-title" target="_blank"><?php echo htmlspecialchars($song->Title); ?></a>
							<?php if (!empty($song->Artist)): ?>
								<div class="song-artist"><?php echo htmlspecialchars($song->Artist); ?></div>
							<?php endif; ?>
						</div>
						<button class="add-btn" 
							data-title="<?php echo htmlspecialchars($song->Title, ENT_QUOTES, 'UTF-8'); ?>" 
							data-uri="<?php echo htmlspecialchars($song->Uri, ENT_QUOTES, 'UTF-8'); ?>" 
							data-artist="<?php echo htmlspecialchars($song->Artist, ENT_QUOTES, 'UTF-8'); ?>" 
							onclick="addToSetlist(this)">Add</button>
					</div>
				<?php endforeach; ?>
			</div>
		</div>
		
		<div class="setlist-section">
			<div class="setlist-header">
				<div class="setlist-name" id="setlistNameDisplay">My Setlist</div>
				<div class="setlist-actions">
					<input type="text" id="setlistName" placeholder="Enter setlist name..." style="margin-right: 10px; padding: 5px; border: 1px solid #ccc; border-radius: 3px;">
					<button class="save-btn" onclick="saveSetlistToServer()" style="background: #28a745; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; margin-right: 10px; height: 30px;">Save Setlist</button>
					<button class="clear-btn" onclick="clearSetlist()" style="background: #6c757d; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; margin-right: 10px; height: 30px;">Clear All</button>
					<button class="cancel-btn" onclick="window.location.href='<?php echo Ugs::MakeUri(Actions::ListSetlists); ?>'" style="background: #6c757d; color: white; border: none; padding: 5px 10px; border-radius: 3px; cursor: pointer; height: 30px;">Cancel</button>
				</div>
			</div>
			<div class="song-count" id="setlistCount">0 songs in setlist</div>
			<div class="drag-instructions" id="dragInstructions" style="display: none;">
				💡 Drag songs to reorder • Hover over songs to see move controls
				<div class="keyboard-shortcuts">Keyboard: ↑/↓ arrows to move selected song, Enter to move to typed position</div>
			</div>
			
			<div id="quickJump" style="display: none; margin-bottom: 10px;">
				<label for="jumpToPosition">Quick jump to position:</label>
				<input type="number" id="jumpToPosition" min="1" style="width: 60px; margin: 0 5px; padding: 2px 4px;" 
					onkeypress="if(event.key === 'Enter') jumpToPosition(this.value)">
				<button onclick="jumpToPosition(document.getElementById('jumpToPosition').value)" style="padding: 2px 8px; margin-left: 5px;">Go</button>
			</div>
			
			<div id="setlistSongs">
				<div class="no-songs">No songs in setlist yet. Use the search to find songs and add them!</div>
			</div>
		</div>
	</div>

	<script>
		let allSongs = <?php echo json_encode($model->SongList); ?>;
		let setlistSongs = [];
		let draggedElement = null;
		let dragSrcEl = null;
		let selectedSongIndex = -1; // For keyboard navigation
		
		// Search functionality
		document.getElementById('searchBox').addEventListener('input', function() {
			const searchTerm = this.value.toLowerCase();
			const songItems = document.querySelectorAll('#songList .song-item');
			let visibleCount = 0;
			
			songItems.forEach(item => {
				const title = item.getAttribute('data-title').toLowerCase();
				const artist = item.getAttribute('data-artist').toLowerCase();
				if (title.includes(searchTerm) || artist.includes(searchTerm)) {
					item.style.display = 'flex';
					visibleCount++;
				} else {
					item.style.display = 'none';
				}
			});
			
			document.getElementById('songCount').textContent = visibleCount + ' songs found';
		});
		
		// Add song to setlist
		function addToSetlist(button) {
			const title = button.getAttribute('data-title');
			const uri = button.getAttribute('data-uri');
			const artist = button.getAttribute('data-artist');

		
			setlistSongs.push({ Title: title, Uri: uri, Artist: artist });
			updateSetlistDisplay();
		}
		
		// Remove song from setlist
		function removeFromSetlist(index) {
			setlistSongs.splice(index, 1);
			updateSetlistDisplay();
		}
		
		// Move song to specific position
		function moveSongToPosition(fromIndex, toPosition) {
			const toIndex = parseInt(toPosition) - 1; // Convert to 0-based index
			
			if (toIndex >= 0 && toIndex < setlistSongs.length && toIndex !== fromIndex) {
				const [movedSong] = setlistSongs.splice(fromIndex, 1);
				setlistSongs.splice(toIndex, 0, movedSong);
				updateSetlistDisplay();
				
				// Clear the input field after successful move
				const inputs = document.querySelectorAll('.move-to-input');
				inputs.forEach(input => input.value = '');
			}
		}
		
		// Jump to a specific position in the setlist
		function jumpToPosition(position) {
			const pos = parseInt(position) - 1;
			if (pos >= 0 && pos < setlistSongs.length) {
				selectedSongIndex = pos;
				highlightSelectedSong();
				
				// Scroll the selected song into view
				const songItems = document.querySelectorAll('.setlist-song-item');
				if (songItems[pos]) {
					songItems[pos].scrollIntoView({ behavior: 'smooth', block: 'center' });
				}
				
				// Clear the input
				document.getElementById('jumpToPosition').value = '';
			}
		}
		
		// Clear all songs from setlist
		function clearSetlist() {
			if (confirm('Are you sure you want to clear the entire setlist?')) {
				setlistSongs = [];
				updateSetlistDisplay();
			}
		}
		
		// Drag and drop functionality
		function setupDragAndDrop() {
			const setlistContainer = document.getElementById('setlistSongs');
			const songItems = setlistContainer.querySelectorAll('.setlist-song-item');
			
			songItems.forEach(item => {
				item.setAttribute('draggable', true);
				
				item.addEventListener('dragstart', handleDragStart);
				item.addEventListener('dragend', handleDragEnd);
				item.addEventListener('dragover', handleDragOver);
				item.addEventListener('dragenter', handleDragEnter);
				item.addEventListener('dragleave', handleDragLeave);
				item.addEventListener('drop', handleDrop);
				
				// Add click to select functionality
				item.addEventListener('click', function(e) {
					// Don't select if clicking on buttons or inputs
					if (e.target.tagName === 'BUTTON' || e.target.tagName === 'INPUT' || e.target.classList.contains('drag-handle')) {
						return;
					}
					
					const index = parseInt(this.getAttribute('data-index'));
					selectedSongIndex = index;
					highlightSelectedSong();
				});
			});
		}
		
		function handleDragStart(e) {
			draggedElement = this;
			this.classList.add('dragging');
			e.dataTransfer.effectAllowed = 'move';
			e.dataTransfer.setData('text/html', this.outerHTML);
		}
		
		function handleDragEnd(e) {
			this.classList.remove('dragging');
			document.querySelectorAll('.setlist-song-item').forEach(item => {
				item.classList.remove('drag-over');
			});
		}
		
		function handleDragOver(e) {
			if (e.preventDefault) {
				e.preventDefault();
			}
			e.dataTransfer.dropEffect = 'move';
			return false;
		}
		
		function handleDragEnter(e) {
			if (this !== draggedElement) {
				this.classList.add('drag-over');
			}
		}
		
		function handleDragLeave(e) {
			this.classList.remove('drag-over');
		}
		
		function handleDrop(e) {
			if (e.stopPropagation) {
				e.stopPropagation();
			}
			
			if (draggedElement !== this) {
				const allItems = [...document.querySelectorAll('.setlist-song-item')];
				const draggedIndex = allItems.indexOf(draggedElement);
				const droppedIndex = allItems.indexOf(this);
				
				// Reorder the setlistSongs array
				const [draggedSong] = setlistSongs.splice(draggedIndex, 1);
				setlistSongs.splice(droppedIndex, 0, draggedSong);
				
				// Update display
				updateSetlistDisplay();
			}
			
			return false;
		}
		
		// Update the setlist display
		function updateSetlistDisplay() {
			const setlistContainer = document.getElementById('setlistSongs');
			const setlistCount = document.getElementById('setlistCount');
			const dragInstructions = document.getElementById('dragInstructions');
			
			setlistCount.textContent = setlistSongs.length + ' songs in setlist';
			
			if (setlistSongs.length === 0) {
				setlistContainer.innerHTML = '<div class="no-songs">No songs in setlist yet. Use the search to find songs and add them!</div>';
				dragInstructions.style.display = 'none';
				return;
			}
			
			// Show drag instructions if there are multiple songs
			if (setlistSongs.length > 1) {
				dragInstructions.style.display = 'block';
			} else {
				dragInstructions.style.display = 'none';
			}
			
			// Show quick jump for longer setlists
			const quickJump = document.getElementById('quickJump');
			if (setlistSongs.length > 10) {
				quickJump.style.display = 'block';
			} else {
				quickJump.style.display = 'none';
			}
			
			let html = '';
			setlistSongs.forEach((song, index) => {
				// Calculate which instance this is (1st, 2nd, 3rd, etc.)
				let instanceNumber = 1;
				for (let i = 0; i < index; i++) {
					if (setlistSongs[i].Uri === song.Uri) {
						instanceNumber++;
					}
				}
				
				// Check if this song appears multiple times in the setlist
				const totalInstances = setlistSongs.filter(s => s.Uri === song.Uri).length;
				const duplicateIndicator = totalInstances > 1 ? `<span style="background: #ffc107; color: #000; padding: 2px 6px; border-radius: 10px; font-size: 10px; margin-left: 8px;">#${instanceNumber}</span>` : '';
				
				html += `
					<div class="setlist-song-item" draggable="true" data-index="${index}">
						<div class="song-position">${index + 1}</div>
						<div class="drag-handle" title="Drag to reorder">⋮⋮</div>
						<div class="song-info">
							<a href="${song.Uri}" class="song-title" target="_blank">${song.Title}</a>
							${song.Artist ? `<div class="song-artist">${song.Artist}</div>` : ''}
						</div>
						<div style="display: flex; align-items: center;">
							<div class="move-to-position">
								<input type="number" class="move-to-input" placeholder="Pos" min="1" max="${setlistSongs.length}" 
									onkeypress="if(event.key === 'Enter') moveSongToPosition(${index}, this.value)" 
									title="Type position number and press Enter">
								<button class="move-to-btn" onclick="moveSongToPosition(${index}, this.previousElementSibling.value)" title="Move to position">Go</button>
							</div>
							${duplicateIndicator}
							<button class="remove-btn" onclick="removeFromSetlist(${index})">Remove</button>
						</div>
					</div>
				`;
			});
			
			setlistContainer.innerHTML = html;
			
			// Setup drag and drop for new items
			setupDragAndDrop();
			
			// Save to localStorage
			saveSetlist();
		}
		
		// Save setlist to localStorage
		function saveSetlist() {
			localStorage.setItem('ukeBookSetlist', JSON.stringify(setlistSongs));
		}
		
		// Load setlist from localStorage
		function loadSetlist() {
			const saved = localStorage.getItem('ukeBookSetlist');
			const savedName = localStorage.getItem('ukeBookSetlistName');
			
			if (saved) {
				setlistSongs = JSON.parse(saved);
				updateSetlistDisplay();
			}
			
			// Load and display setlist name if available
			if (savedName) {
				document.getElementById('setlistName').value = savedName;
				document.getElementById('setlistNameDisplay').textContent = savedName;
				// Clear the stored name so it doesn't persist on new saves
				localStorage.removeItem('ukeBookSetlistName');
			}
		}
		
		// Save setlist to server
		function saveSetlistToServer() {
			const setlistName = document.getElementById('setlistName').value.trim();
			
			if (!setlistName) {
				alert('Please enter a name for your setlist');
				return;
			}
			
			if (setlistSongs.length === 0) {
				alert('Please add some songs to your setlist before saving');
				return;
			}
			
			// Prepare the data to send
			const data = {
				name: setlistName,
				songs: setlistSongs
			};
			
			// Send AJAX request
			fetch('<?php echo Ugs::MakeUri(Actions::SaveSetlist); ?>', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/json',
				},
				body: JSON.stringify(data)
			})
			.then(response => response.json())
			.then(result => {
				if (result.success) {
					alert('Setlist "' + result.setlistName + '" saved successfully!');
					// Redirect to setlist list page
					window.location.href = '<?php echo Ugs::MakeUri(Actions::ListSetlists); ?>';
				} else {
					alert('Error saving setlist: ' + result.message);
				}
			})
			.catch(error => {
				console.error('Error:', error);
				alert('Error saving setlist. Please try again.');
			});
		}
		
		// Load setlist on page load
		document.addEventListener('DOMContentLoaded', function() {
			loadSetlist();
			
			// Update setlist name display when user types in the name field
			document.getElementById('setlistName').addEventListener('input', function() {
				const name = this.value.trim();
				document.getElementById('setlistNameDisplay').textContent = name || 'My Setlist';
			});
			
			// Add keyboard navigation
			document.addEventListener('keydown', function(e) {
				// Only handle keyboard shortcuts when not typing in input fields
				if (e.target.tagName === 'INPUT' || e.target.tagName === 'TEXTAREA') {
					return;
				}
				
				if (setlistSongs.length === 0) return;
				
				switch(e.key) {
					case 'ArrowUp':
						e.preventDefault();
						if (selectedSongIndex > 0) {
							moveSongToPosition(selectedSongIndex, selectedSongIndex);
							selectedSongIndex--;
						} else if (selectedSongIndex === -1) {
							selectedSongIndex = setlistSongs.length - 1;
						}
						highlightSelectedSong();
						break;
					case 'ArrowDown':
						e.preventDefault();
						if (selectedSongIndex < setlistSongs.length - 1) {
							moveSongToPosition(selectedSongIndex, selectedSongIndex + 2);
							selectedSongIndex++;
						} else if (selectedSongIndex === -1) {
							selectedSongIndex = 0;
						}
						highlightSelectedSong();
						break;
					case 'Enter':
						e.preventDefault();
						if (selectedSongIndex >= 0) {
							const position = prompt(`Move song "${setlistSongs[selectedSongIndex].Title}" to position (1-${setlistSongs.length}):`);
							if (position && !isNaN(position)) {
								moveSongToPosition(selectedSongIndex, position);
							}
						}
						break;
				}
			});
		});
		
		// Highlight the currently selected song
		function highlightSelectedSong() {
			document.querySelectorAll('.setlist-song-item').forEach((item, index) => {
				if (index === selectedSongIndex) {
					item.classList.add('selected');
				} else {
					item.classList.remove('selected');
				}
			});
		}
	</script>
</body>
</html> 