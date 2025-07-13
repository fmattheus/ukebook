<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title><?php echo($model->PageTitle); ?></title>
	<meta name="generator" content="<?php echo($model->PoweredBy) ?>" />
	<link rel="stylesheet" href="<?php echo($model->StaticsPrefix); ?>css/ugsEditorPlus.merged.css" title="ugsEditorCss" />
	<link rel="stylesheet" href="<?php echo($model->StaticsPrefix); ?>css/ugsphp.css" />
	<style>
		.import-container {
			max-width: 1200px;
			margin: 0 auto;
			padding: 20px;
		}
		
		.header-controls {
			display: flex;
			justify-content: space-between;
			align-items: center;
			margin-bottom: 30px;
		}
		
		.step-indicator {
			display: flex;
			justify-content: center;
			margin-bottom: 30px;
		}
		
		.step {
			display: flex;
			align-items: center;
			margin: 0 20px;
		}
		
		.step-number {
			width: 30px;
			height: 30px;
			border-radius: 50%;
			background: #ccc;
			color: white;
			display: flex;
			align-items: center;
			justify-content: center;
			font-weight: bold;
			margin-right: 10px;
		}
		
		.step.active .step-number {
			background: #007cba;
		}
		
		.step.completed .step-number {
			background: #28a745;
		}
		
		.step-content {
			background: white;
			border-radius: 8px;
			padding: 30px;
			box-shadow: 0 2px 8px rgba(0,0,0,0.1);
		}
		
		.form-group {
			margin-bottom: 20px;
		}
		
		.form-group label {
			display: block;
			margin-bottom: 5px;
			font-weight: 600;
			color: #333;
		}
		
		.form-group input,
		.form-group textarea {
			width: 100%;
			padding: 10px;
			border: 1px solid #ccc;
			border-radius: 4px;
			font-size: 14px;
		}
		
		.form-group textarea {
			min-height: 200px;
			font-family: monospace;
		}
		
		.btn {
			padding: 10px 20px;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			text-decoration: none;
			display: inline-block;
			font-size: 14px;
			transition: opacity 0.2s;
			margin-right: 10px;
		}
		
		.btn:hover {
			opacity: 0.8;
		}
		
		.btn-primary {
			background: #007cba;
			color: white;
		}
		
		.btn-secondary {
			background: #6c757d;
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
		
		.song-match-item {
			border: 1px solid #ddd;
			border-radius: 4px;
			padding: 20px;
			margin-bottom: 20px;
			background: #f9f9f9;
		}
		
		.song-match-header {
			display: flex;
			justify-content: space-between;
			align-items: flex-start;
			margin-bottom: 15px;
		}
		
		.song-match-original {
			flex: 1;
		}
		
		.song-match-title {
			font-weight: 600;
			color: #333;
			font-size: 16px;
			margin-bottom: 5px;
		}
		
		.song-match-artist {
			color: #666;
			font-style: italic;
			margin-bottom: 5px;
		}
		
		.song-match-meta {
			color: #999;
			font-size: 0.9em;
		}
		
		.song-match-status {
			margin-left: 15px;
			padding: 5px 10px;
			border-radius: 4px;
			font-size: 12px;
			font-weight: 600;
		}
		
		.song-match-status.pending {
			background: #fff3cd;
			color: #856404;
		}
		
		.song-match-status.matched {
			background: #d4edda;
			color: #155724;
		}
		
		.song-match-status.skipped {
			background: #f8d7da;
			color: #721c24;
		}
		
		.song-match-results {
			margin-top: 15px;
		}
		
		.song-match-result {
			padding: 10px 15px;
			border: 1px solid #ddd;
			border-radius: 4px;
			margin-bottom: 8px;
			cursor: pointer;
			background: white;
			transition: all 0.2s;
		}
		
		.song-match-result:hover {
			background: #f0f0f0;
			border-color: #007cba;
		}
		
		.song-match-result.selected {
			background: #007cba;
			color: white;
			border-color: #007cba;
		}
		
		.song-match-result .song-title {
			font-weight: 600;
			margin-bottom: 3px;
		}
		
		.song-match-result .song-artist {
			font-size: 0.9em;
			opacity: 0.8;
		}
		
		.song-match-result .song-artist.selected {
			opacity: 1;
		}
		
		.song-match-result .song-match-header {
			display: flex;
			justify-content: space-between;
			align-items: center;
		}
		
		.song-match-result .song-match-info {
			flex: 1;
		}
		
		.song-match-result .song-match-score {
			text-align: right;
			margin-left: 15px;
		}
		
		.song-match-result .score-percentage {
			font-size: 18px;
			font-weight: bold;
			color: #007cba;
		}
		
		.song-match-result .score-label {
			font-size: 10px;
			color: #666;
			text-transform: uppercase;
		}
		
		.song-match-result.selected .score-percentage {
			color: white;
		}
		
		.song-match-result.selected .score-label {
			color: rgba(255, 255, 255, 0.8);
		}
		
		.no-matches {
			padding: 15px;
			text-align: center;
			color: #666;
			font-style: italic;
			background: #f8f9fa;
			border-radius: 4px;
		}
		
		.song-match-actions {
			margin-top: 10px;
			display: flex;
			gap: 10px;
		}
		
		.song-match-actions .btn {
			padding: 6px 12px;
			font-size: 12px;
		}
		
		.final-setlist {
			border: 1px solid #ddd;
			border-radius: 4px;
			padding: 20px;
			background: #f9f9f9;
		}
		
		.final-setlist h3 {
			margin-top: 0;
			color: #333;
		}
		
		.final-setlist-item {
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding: 8px 0;
			border-bottom: 1px solid #eee;
		}
		
		.final-setlist-item:last-child {
			border-bottom: none;
		}
		
		.final-setlist-info {
			flex: 1;
		}
		
		.final-setlist-title {
			font-weight: 600;
			color: #333;
		}
		
		.final-setlist-artist {
			color: #666;
			font-size: 0.9em;
		}
		
		.final-setlist-original {
			color: #999;
			font-size: 0.8em;
			font-style: italic;
		}
		
		.instructions {
			background: #e7f3ff;
			border: 1px solid #b3d9ff;
			border-radius: 4px;
			padding: 15px;
			margin-bottom: 20px;
		}
		
		.instructions h4 {
			margin-top: 0;
			color: #005a87;
		}
		
		.instructions ol {
			margin: 10px 0;
			padding-left: 20px;
		}
		
		.instructions li {
			margin-bottom: 5px;
		}
		
		.progress-info {
			background: #f8f9fa;
			border: 1px solid #dee2e6;
			border-radius: 4px;
			padding: 15px;
			margin-bottom: 20px;
		}
		
		.progress-info h4 {
			margin-top: 0;
			color: #495057;
		}
		
		.progress-stats {
			display: flex;
			gap: 20px;
			margin-top: 10px;
		}
		
		.progress-stat {
			text-align: center;
		}
		
		.progress-stat .number {
			font-size: 24px;
			font-weight: bold;
			color: #007cba;
		}
		
		.progress-stat .label {
			font-size: 12px;
			color: #666;
			text-transform: uppercase;
		}
	</style>
</head>
<body>
	<div class="import-container">
		<div class="header-controls">
			<button onclick="window.location.href='<?php echo Ugs::MakeUri(Actions::ListSetlists); ?>'" class="btn btn-secondary">← Back to Setlists</button>
			<h1 style="margin: 0;">Import Spreadsheet</h1>
		</div>
		
		<div class="step-indicator">
			<div class="step <?php echo $model->CurrentStep >= 1 ? 'completed' : ''; ?>">
				<div class="step-number">1</div>
				<span>Paste Data</span>
			</div>
			<div class="step <?php echo $model->CurrentStep >= 2 ? 'completed' : ''; ?>">
				<div class="step-number">2</div>
				<span>Match Songs</span>
			</div>
			<div class="step <?php echo $model->CurrentStep >= 3 ? 'completed' : ''; ?>">
				<div class="step-number">3</div>
				<span>Save Setlist</span>
			</div>
		</div>
		
		<div class="step-content">
			<?php if ($model->CurrentStep === 1): ?>
				<!-- Step 1: Paste Spreadsheet Data -->
				<div class="instructions">
					<h4>How to import from Google Docs:</h4>
					<ol>
						<li>Open your Google Docs spreadsheet</li>
						<li>Select the cells from the four relevant columns</li>
						<li>Copy the data (Ctrl+C or Cmd+C)</li>
						<li>Paste it in the textarea below</li>
					</ol>
					<p><strong>Expected columns:</strong> Song Title, Artist, GEMA (optional), Leader</p>
					<p><strong>Note:</strong> Empty titles and "Break" entries will be skipped automatically.</p>
				</div>
				
				<form method="post" action="">
					<input type="hidden" name="step" value="1">
					
					<div class="form-group">
						<label for="setlist_name">Setlist Name:</label>
						<input type="text" id="setlist_name" name="setlist_name" value="Imported Setlist" required>
					</div>
					
					<div class="form-group">
						<label for="spreadsheet_data">Paste your spreadsheet data here:</label>
						<textarea id="spreadsheet_data" name="spreadsheet_data" placeholder="Paste your Google Docs spreadsheet data here..." required></textarea>
					</div>
					
					<div class="form-group">
						<button type="submit" class="btn btn-primary">Continue →</button>
						<button type="button" onclick="window.location.href='<?php echo Ugs::MakeUri(Actions::ListSetlists); ?>'" class="btn btn-secondary">Cancel</button>
					</div>
				</form>
				
			<?php elseif ($model->CurrentStep === 2): ?>
				<!-- Step 2: Match Songs -->
				<h2>Review and Match Songs</h2>
				<p>We've automatically searched for matches for each song. Please review and select the best match for each song, or skip songs that don't have good matches.</p>
				
				<div class="progress-info">
					<h4>Progress</h4>
					<div class="progress-stats">
						<div class="progress-stat">
							<div class="number" id="totalSongs"><?php echo count($model->ImportedSongs); ?></div>
							<div class="label">Total Songs</div>
						</div>
						<div class="progress-stat">
							<div class="number" id="matchedSongs">0</div>
							<div class="label">Matched</div>
						</div>
						<div class="progress-stat">
							<div class="number" id="skippedSongs">0</div>
							<div class="label">Skipped</div>
						</div>
					</div>
				</div>
				
				<form method="post" action="" id="matchForm">
					<input type="hidden" name="step" value="2">
					<input type="hidden" name="setlist_name" value="<?php echo htmlspecialchars($model->SetlistName); ?>">
					<input type="hidden" name="matched_songs" id="matched_songs" value="">
					
					<?php foreach($model->ImportedSongs as $index => $song): ?>
						<?php 
						// Auto-search for matches using the song title and artist
						$searchQuery = array(
							'title' => $song['title'],
							'artist' => $song['artist']
						);
						$matches = $model->FilterSongs($searchQuery);
						?>
						
						<div class="song-match-item" data-index="<?php echo $index; ?>">
							<div class="song-match-header">
								<div class="song-match-original">
									<div class="song-match-title"><?php echo htmlspecialchars($song['title']); ?></div>
									<?php if (!empty($song['artist'])): ?>
										<div class="song-match-artist"><?php echo htmlspecialchars($song['artist']); ?></div>
									<?php endif; ?>
									<div class="song-match-meta">
										<?php if (!empty($song['leader'])): ?>Leader: <?php echo htmlspecialchars($song['leader']); ?><?php endif; ?>
									</div>
								</div>
								<div class="song-match-status pending" id="status-<?php echo $index; ?>">Pending</div>
							</div>
							
							<div class="song-match-results" id="results-<?php echo $index; ?>">
								<?php if (empty($matches)): ?>
									<div class="no-matches">
										No matches found for "<?php echo htmlspecialchars($searchTerm); ?>"
									</div>
								<?php else: ?>
									<?php foreach($matches as $match): ?>
										<div class="song-match-result" 
											 data-song-index="<?php echo $index; ?>"
											 data-song='<?php echo json_encode($match['song']); ?>'
											 onclick="selectSongFromData(this)">
											<div class="song-match-header">
												<div class="song-match-info">
													<div class="song-title"><?php echo htmlspecialchars($match['song']->Title); ?></div>
													<?php if (!empty($match['song']->Artist)): ?>
														<div class="song-artist"><?php echo htmlspecialchars($match['song']->Artist); ?></div>
													<?php endif; ?>
												</div>
												<div class="song-match-score">
													<div class="score-percentage"><?php echo round($match['score']); ?>%</div>
													<div class="score-label">match</div>
												</div>
											</div>
										</div>
									<?php endforeach; ?>
								<?php endif; ?>
							</div>
							
							<div class="song-match-actions">
								<button type="button" class="btn btn-secondary" onclick="skipSong(<?php echo $index; ?>)">Skip This Song</button>
							</div>
							
							<input type="hidden" name="song_<?php echo $index; ?>" id="selected-song-<?php echo $index; ?>" value="">
						</div>
					<?php endforeach; ?>
					
					<div class="form-group">
						<button type="submit" class="btn btn-primary" onclick="prepareFormData()">Continue →</button>
						<button type="button" onclick="window.location.href='<?php echo Ugs::MakeUri(Actions::ImportSpreadsheet); ?>'" class="btn btn-secondary">Back</button>
					</div>
				</form>
				
			<?php elseif ($model->CurrentStep === 3): ?>
				<!-- Step 3: Save Setlist -->
				<h2>Review and Save Setlist</h2>
				
				<div class="final-setlist">
					<h3><?php echo htmlspecialchars($model->SetlistName); ?></h3>
					<?php foreach($model->ImportedSongs as $song): ?>
						<?php if (isset($song['matched_song']) && $song['matched_song']): ?>
							<div class="final-setlist-item">
								<div class="final-setlist-info">
									<div class="final-setlist-title"><?php echo htmlspecialchars($song['matched_song']['Title']); ?></div>
									<?php if (!empty($song['matched_song']['Artist'])): ?>
										<div class="final-setlist-artist"><?php echo htmlspecialchars($song['matched_song']['Artist']); ?></div>
									<?php endif; ?>
									<div class="final-setlist-original">Original: <?php echo htmlspecialchars($song['title']); ?></div>
									<?php if (!empty($song['leader'])): ?>
										<div class="final-setlist-meta">Leader: <?php echo htmlspecialchars($song['leader']); ?></div>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>
					<?php endforeach; ?>
				</div>
				
				<div class="form-group">
					<button type="button" class="btn btn-success" onclick="saveSetlist()">Create Setlist</button>
					<button type="button" onclick="window.location.href='<?php echo Ugs::MakeUri(Actions::ImportSpreadsheet); ?>'" class="btn btn-secondary">Start Over</button>
				</div>
			<?php endif; ?>
		</div>
	</div>

	<script>
		let selectedSongs = {};
		let matchedCount = 0;
		let skippedCount = 0;
		
		// Auto-select best matches when page loads
		document.addEventListener('DOMContentLoaded', function() {
			<?php if ($model->CurrentStep === 2): ?>
			// Get all song match items and auto-select the first (best) match for each
			const songItems = document.querySelectorAll('.song-match-item');
			songItems.forEach((item, index) => {
				const resultsContainer = item.querySelector('.song-match-results');
				if (resultsContainer) {
					const firstResult = resultsContainer.querySelector('.song-match-result');
					if (firstResult) {
						const scoreElement = firstResult.querySelector('.score-percentage');
						if (scoreElement) {
							const score = parseInt(scoreElement.textContent);
							
							if (score >= 60) {
								setTimeout(() => {
									// Use the new selectSongFromData function
									selectSongFromData(firstResult);
								}, index * 100);
							}
						}
					}
				}
			});
			<?php endif; ?>
		});
		
		// Select a song match from data attributes
		function selectSongFromData(element) {
			const index = parseInt(element.getAttribute('data-song-index'));
			const songData = element.getAttribute('data-song');
			const song = JSON.parse(songData);
			selectSong(index, song);
		}
		
		// Select a song match
		function selectSong(index, song) {
			selectedSongs[index] = song;
			document.getElementById('selected-song-' + index).value = JSON.stringify(song);
			
			// Update the status
			const statusElement = document.getElementById('status-' + index);
			if (statusElement) {
				statusElement.textContent = 'Matched';
				statusElement.className = 'song-match-status matched';
			}
			
			// Update the results to show selected
			const resultsContainer = document.getElementById('results-' + index);
			if (resultsContainer) {
				const resultElements = resultsContainer.querySelectorAll('.song-match-result');
				resultElements.forEach(element => {
					element.classList.remove('selected');
					if (element.querySelector('.song-title').textContent === song.Title) {
						element.classList.add('selected');
					}
				});
			}
			
			updateProgress();
		}
		
		// Skip a song
		function skipSong(index) {
			selectedSongs[index] = null;
			document.getElementById('selected-song-' + index).value = '';
			
			// Update the status
			const statusElement = document.getElementById('status-' + index);
			if (statusElement) {
				statusElement.textContent = 'Skipped';
				statusElement.className = 'song-match-status skipped';
			}
			
			// Remove selected class from all results
			const resultsContainer = document.getElementById('results-' + index);
			if (resultsContainer) {
				const resultElements = resultsContainer.querySelectorAll('.song-match-result');
				resultElements.forEach(element => {
					element.classList.remove('selected');
				});
			}
			
			updateProgress();
		}
		

		
		// Update progress counters
		function updateProgress() {
			matchedCount = 0;
			skippedCount = 0;
			
			Object.values(selectedSongs).forEach(song => {
				if (song === null) {
					skippedCount++;
				} else {
					matchedCount++;
				}
			});
			
			const matchedElement = document.getElementById('matchedSongs');
			const skippedElement = document.getElementById('skippedSongs');
			if (matchedElement) matchedElement.textContent = matchedCount;
			if (skippedElement) skippedElement.textContent = skippedCount;
		}
		
		<?php if ($model->CurrentStep === 2): ?>
		function prepareFormData() {
			const matchedSongs = [];
			<?php foreach($model->ImportedSongs as $index => $song): ?>
				const songData_<?php echo $index; ?> = {
					title: <?php echo json_encode($song['title']); ?>,
					artist: <?php echo json_encode($song['artist']); ?>,
					leader: <?php echo json_encode($song['leader']); ?>,
					matched_song: selectedSongs[<?php echo $index; ?>] || null
				};
				matchedSongs.push(songData_<?php echo $index; ?>);
			<?php endforeach; ?>
			
			document.getElementById('matched_songs').value = JSON.stringify(matchedSongs);
		}
		<?php endif; ?>
		
		<?php if ($model->CurrentStep === 3): ?>
		function saveSetlist() {
			const setlistData = {
				name: <?php echo json_encode($model->SetlistName); ?>,
				created: new Date().toISOString(),
				songs: []
			};
			
			<?php foreach($model->ImportedSongs as $song): ?>
				<?php if (isset($song['matched_song']) && $song['matched_song']): ?>
					setlistData.songs.push({
						Title: <?php echo json_encode($song['matched_song']['Title']); ?>,
						Artist: <?php echo json_encode($song['matched_song']['Artist']); ?>,
						Uri: <?php echo json_encode($song['matched_song']['Uri']); ?>,
						Transpose: '0',
						Leader: <?php echo json_encode($song['leader'] ?? ''); ?>
					});
				<?php endif; ?>
			<?php endforeach; ?>
			
			// Store in localStorage and redirect to setlist manager
			localStorage.setItem('ukeBookSetlist', JSON.stringify(setlistData.songs));
			localStorage.setItem('ukeBookSetlistName', setlistData.name);
			
			window.location.href = '<?php echo Ugs::MakeUri(Actions::Setlist); ?>';
		}
		<?php endif; ?>
		

	</script>
</body>
</html> 
