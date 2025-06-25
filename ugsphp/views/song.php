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
</style>
<style>
/* Inline metronome styles for mobile browser compatibility */
.bpm-metronome {
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

.bpm-metronome.bouncing {
	animation-play-state: running !important;
}

.bpm-metronome.hidden {
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
.bpm-display {
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
  .gema-display, .bpm-display {
    margin-right: 2em;
  }
  .bpm-metronome {
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
				<?php if ($model->Bpm > 0): ?>
					<div class="bpm-display" id="bpmDisplay">BPM: <?php echo($model->Bpm); ?></div>
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
	<?php if ($model->Bpm > 0): ?>
	<div id="bpmMetronome" class="bpm-metronome" data-bpm="<?php echo($model->Bpm); ?>"><?php echo($model->Bpm); ?></div>
	<?php endif; ?>
	<div id="ukeSongContainer" class="ugsLayoutTwoColumn ugs-song-wrap">
		<aside id="ukeChordsCanvas" class="ugs-diagrams-wrap ugs-grouped"></aside>
		<article id="ukeSongText" class="ugs-source-wrap"><pre><?php echo($model->Body); ?></pre></article>
	</div>
</section>
<footer>
	<p>Note: Standard <strong>GCEA</strong> Soprano Ukulele Tuning. <small>Powered by UkeGeeks' Scriptasaurus &bull; ukegeeks.com</small></p>
</footer>
<script type="text/javascript" src="<?php echo($model->StaticsPrefix); ?>/js/ukeGeeks.scriptasaurus.min.js"></script>
<script type="text/javascript" src="<?php echo($model->StaticsPrefix); ?>/js/startup.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  var bpmDisplay = document.getElementById('bpmDisplay');
  if (bpmDisplay) {
    bpmDisplay.style.cursor = 'pointer';
    bpmDisplay.title = 'Click to restart metronome';
    bpmDisplay.onclick = function() {
      if (typeof restartMetronome === 'function') {
        restartMetronome();
      }
    };
  }
});
</script>
</body>
</html>