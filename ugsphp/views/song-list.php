<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<title>List All Songs</title>
	<meta name="generator" content="<?php echo($model->PoweredBy) ?>" />
	<link rel="stylesheet" type="text/css" href="<?php echo($model->StaticsPrefix); ?>css/yuiReset.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo($model->StaticsPrefix); ?>css/basic-page-layout.css" media="all" />
	<style>
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
		
		.song-list {
			max-width: 800px;
			margin: 0 auto;
			padding: 20px;
		}
		
		.song-list ol {
			list-style: none;
			padding: 0;
		}
		
		.song-list li {
			padding: 8px 12px;
			margin: 5px 0;
			background: #f5f5f5;
			border-radius: 4px;
			border: 1px solid #ddd;
		}
		
		.song-list li:hover {
			background: #e9e9e9;
		}
		
		.song-list a {
			text-decoration: none;
			color: #333;
			display: block;
		}
		
		.song-list a:hover {
			color: #007cba;
		}
	</style>
</head>
<body>
	<div class="nav-links">
		<a href="<?php echo Ugs::MakeUri(Actions::Songbook); ?>">All Songs</a>
		<?php if ($model->SiteUser->IsAdmin) { ?>
			<a href="<?php echo Ugs::MakeUri(Actions::Setlist); ?>">Setlist Manager</a>
		<?php } ?>
	</div>
	
	<div class="song-list">
		<h1>List All Songs</h1>
		<p><?php echo(count($model->SongList->SongList)); ?> songs</p>
		<ol>
			<?php
			foreach($model->SongList->SongList as $song){
				echo('<li><a href="' . $song->Uri . '">' . $song->Title . '</a></li>');
			}
			?>
		</ol>
	</div>
</body>
</html>
