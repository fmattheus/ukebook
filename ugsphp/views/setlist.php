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
		
		.drag-handle {
			cursor: grab;
			padding: 4px 8px;
			margin-right: 8px;
			color: #666;
			font-size: 14px;
			user-select: none;
		}
		
		.drag-handle:active {
			cursor: grabbing;
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
			<div class="drag-instructions" id="dragInstructions" style="display: none;">💡 Drag songs to reorder your setlist</div>
			
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

			if (setlistSongs.some(song => song.Uri === uri)) {
				alert('Song is already in the setlist!');
				return;
			}
			
			setlistSongs.push({ Title: title, Uri: uri, Artist: artist });
			updateSetlistDisplay();
		}
		
		// Remove song from setlist
		function removeFromSetlist(uri) {
			setlistSongs = setlistSongs.filter(song => song.Uri !== uri);
			updateSetlistDisplay();
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
			
			let html = '';
			setlistSongs.forEach((song, index) => {
				html += `
					<div class="setlist-song-item" draggable="true">
						<div class="drag-handle">⋮⋮</div>
						<div class="song-info">
							<a href="${song.Uri}" class="song-title" target="_blank">${song.Title}</a>
							${song.Artist ? `<div class="song-artist">${song.Artist}</div>` : ''}
						</div>
						<button class="remove-btn" onclick="removeFromSetlist('${song.Uri}')">Remove</button>
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
		});
	</script>
</body>
</html> 