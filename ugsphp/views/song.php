<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="utf-8" />
<title><?php echo($model->PageTitle); ?> </title>
<meta name="generator" content="<?php echo($model->PoweredBy) ?>" />
<script type="text/javascript">var isLegacyIe = false;</script>
<!--[if lt IE 9]>
<script type="text/javascript">
isLegacyIe = true;
document.getElementsByTagName('html')[0].className = 'ie';
</script>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<script type="text/javascript" src="<?php echo($model->StaticsPrefix); ?>/js/excanvas.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="<?php echo($model->StaticsPrefix); ?>/css/yuiReset.css" />
<link rel="stylesheet" type="text/css" href="<?php echo($model->StaticsPrefix); ?>/css/basic-page-layout.css" media="all" />
<link rel="stylesheet" type="text/css" href="<?php echo($model->StaticsPrefix); ?>/css/ukeGeeks.music.css" media="all" />
<link rel="stylesheet" href="<?php echo($model->StaticsPrefix); ?>/css/ukeGeeks.musicPrint.css" media="print" />
<style>
header aside a{
	padding-left: 1em;
}
.video-links { font-size: 0.85em; margin-top: 0.3em; }
.video-links a { margin-right: 1em; }
/* Floating video player */
#videoPlayerDlg {
	position: fixed;
	top: 80px;
	left: 50%;
	transform: translateX(-50%);
	width: 640px;
	max-width: 95vw;
	background: #1a1a1a;
	border-radius: 8px;
	box-shadow: 0 8px 32px rgba(0,0,0,0.7);
	z-index: 9999;
	display: none;
}
.vp-header {
	background: #333;
	padding: 8px 12px;
	border-radius: 8px 8px 0 0;
	display: flex;
	justify-content: space-between;
	align-items: center;
	cursor: move;
	user-select: none;
}
.vp-title { color: #fff; font-weight: bold; font-size: 14px; font-family: Arial, sans-serif; }
.vp-close {
	background: none;
	border: none;
	color: #aaa;
	font-size: 22px;
	line-height: 1;
	cursor: pointer;
	padding: 0 2px;
}
.vp-close:hover { color: #fff; }
#videoPlayerDlg video {
	display: block;
	width: 100%;
	border-radius: 0 0 8px 8px;
}
@media print { #videoPlayerDlg, .video-links { display: none !important; } }
</style>
<style>
/* Inline metronome styles for mobile browser compatibility */
.tempo-metronome {
	position: fixed !important;
	top: 150px !important;
	right: 20px !important;
	width: 50px !important;
	height: 50px !important;
	border-radius: 50% !important;
	background: radial-gradient(circle at 30% 30%, #ff6b6b, #ff0000) !important;
	box-shadow: 0 4px 12px rgba(255,0,0,0.4) !important;
	z-index: 1000 !important;
	border: 2px solid #ffffff !important;
	display: flex !important;
	align-items: center !important;
	justify-content: center !important;
	color: white !important;
	font-weight: bold !important;
	font-size: 16px !important;
	font-family: Arial, sans-serif !important;
	animation: bounce 1s cubic-bezier(0.15, 0.15, 0.25, 1) infinite !important;
	animation-play-state: paused !important;
}

.tempo-metronome.bouncing {
	animation-play-state: running !important;
}

.tempo-metronome.hidden {
	display: none !important;
}

@keyframes bounce {
	0% {
		transform: translateY(-20px) scale(1.1);
		box-shadow: 0 8px 20px rgba(255,0,0,0.6);
	}
	50% {
		transform: translateY(0) scale(1);
		box-shadow: 0 4px 12px rgba(255,0,0,0.4);
	}
	100% {
		transform: translateY(-20px) scale(1.1);
		box-shadow: 0 8px 20px rgba(255,0,0,0.6);
	}
}
</style>
<style>
.tempo-display {
  font-size: 0.9em;
  color: #888;
  margin-top: 0.2em;
  margin-bottom: 0.5em;
  font-family: Arial, sans-serif;
}
</style>
<style>
.gema-display {
  font-size: 0.9em;
  color: #888;
  margin-top: 0.2em;
  margin-bottom: 0.5em;
  font-family: Arial, sans-serif;
}
</style>
<style>
@media print {
  .gema-display, .tempo-display {
    margin-right: 2em;
  }
  .tempo-metronome {
    display: none !important;
  }
}
</style>
</head>
<body>
<section>
	<header>
		<div style="display: flex; justify-content: space-between; align-items: flex-start;">
			<div style="flex: 1;">
				<hgroup>
					<aside>
						<a href="<?php echo($model->EditUri); ?>" title="switch to Edit/Customize view (great for Print!)">Customize</a>
						<a href="<?php echo($model->SourceUri); ?>" target="_blank" title="view original song text">Source</a>
					</aside>
					<h1 class="ugsSongTitle"><?php echo($model->SongTitle); ?></h1>
					<?php if (strlen($model->Artist) > 0): ?>
						<h2 class="ugsArtist"><?php echo($model->Artist); ?></h2>
					<?php endif; ?>
					<?php if ($model->HasTutorial || $model->HasPlayalong): ?>
					<div class="video-links">
						<?php if ($model->HasTutorial): ?>
							<a href="#" data-video-type="tutorial" data-song-id="<?php echo htmlspecialchars($model->SongId); ?>">&#9654; Tutorial</a>
						<?php endif; ?>
						<?php if ($model->HasPlayalong): ?>
							<a href="#" data-video-type="playalong" data-song-id="<?php echo htmlspecialchars($model->SongId); ?>">&#9654; Play Along</a>
						<?php endif; ?>
					</div>
					<?php endif; ?>
					<h2 class="ugsSubtitle"><?php echo($model->Subtitle); ?></h2>
					<?php if (strlen($model->Album) > 0): ?>
						<h3 class="ugsAlbum"><?php echo($model->Album); ?></h3>
					<?php endif; ?>
				</hgroup>
			</div>
			<div style="text-align: right; margin-top: 0.5em;">
				<?php if (strlen($model->Gema) > 0): ?>
					<div class="gema-display">GEMA: <?php echo htmlspecialchars($model->Gema); ?></div>
				<?php endif; ?>
				<?php if ($model->Tempo > 0): ?>
					<div class="tempo-display" id="tempoDisplay">Tempo: <?php echo($model->Tempo); ?></div>
				<?php endif; ?>
			</div>
		</div>
	</header>
		<?php
		if ($model->UgsMeta){
			echo('<div class="metaInfo">');
			foreach($model->UgsMeta as $meta){
				echo('<p>' . $meta . '</p>');
			}
			echo('</div><!-- /.metaInfo -->');
		}
		?>
	<?php if ($model->Tempo > 0): ?>
	<div id="tempoMetronome" class="tempo-metronome" data-tempo="<?php echo($model->Tempo); ?>"><?php echo($model->Tempo); ?></div>
	<?php endif; ?>
	<div id="ukeSongContainer" class="ugsLayoutTwoColumn ugs-song-wrap">
		<aside id="ukeChordsCanvas" class="ugs-diagrams-wrap ugs-grouped"></aside>
		<article id="ukeSongText" class="ugs-source-wrap"><pre><?php echo($model->Body); ?></pre></article>
	</div>
</section>
<footer>
	<p>Note: Standard <strong>GCEA</strong> Soprano Ukulele Tuning. <small>Powered by UkeGeeks' Scriptasaurus &bull; ukegeeks.com</small></p>
</footer>
<?php if ($model->HasTutorial || $model->HasPlayalong): ?>
<!-- Floating video player -->
<div id="videoPlayerDlg">
	<div class="vp-header">
		<span class="vp-title" id="videoPlayerTitle">Video</span>
		<button class="vp-close" id="videoPlayerClose" title="Close">&times;</button>
	</div>
	<video id="videoElement" controls preload="metadata"></video>
</div>
<script>
(function() {
	var dlg    = document.getElementById('videoPlayerDlg');
	var video  = document.getElementById('videoElement');
	var title  = document.getElementById('videoPlayerTitle');
	var header = dlg.querySelector('.vp-header');
	var dragging = false, ox, oy;

	document.addEventListener('click', function(e) {
		var btn = e.target;
		while (btn && !btn.getAttribute('data-video-type')) btn = btn.parentElement;
		if (!btn) return;
		e.preventDefault();
		var type   = btn.getAttribute('data-video-type');
		var songId = btn.getAttribute('data-song-id');
		title.textContent = type === 'tutorial' ? 'Tutorial' : 'Play Along';
		video.src = 'music.php?action=video&song=' + encodeURIComponent(songId) + '&type=' + type;
		video.load();
		video.play();
		dlg.style.display = 'block';
	});

	document.getElementById('videoPlayerClose').addEventListener('click', function() {
		video.pause();
		video.removeAttribute('src');
		video.load();
		dlg.style.display = 'none';
	});

	header.addEventListener('mousedown', function(e) {
		dragging = true;
		var r = dlg.getBoundingClientRect();
		// Switch from transform-based centering to absolute positioning
		dlg.style.transform = 'none';
		dlg.style.left = r.left + 'px';
		dlg.style.top  = r.top  + 'px';
		ox = e.clientX - r.left;
		oy = e.clientY - r.top;
		e.preventDefault();
	});
	document.addEventListener('mousemove', function(e) {
		if (!dragging) return;
		dlg.style.left = (e.clientX - ox) + 'px';
		dlg.style.top  = (e.clientY - oy) + 'px';
	});
	document.addEventListener('mouseup', function() { dragging = false; });
})();
</script>
<?php endif; ?>
<script type="text/javascript" src="<?php echo($model->StaticsPrefix); ?>/js/ukeGeeks.scriptasaurus.min.js"></script>
<script type="text/javascript" src="<?php echo($model->StaticsPrefix); ?>/js/startup.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  var tempoDisplay = document.getElementById('tempoDisplay');
  if (tempoDisplay) {
    tempoDisplay.style.cursor = 'pointer';
    tempoDisplay.title = 'Click to restart metronome';
    tempoDisplay.onclick = function() {
      if (typeof restartMetronome === 'function') {
        restartMetronome();
      }
    };
  }
});
</script>
</body>
</html>