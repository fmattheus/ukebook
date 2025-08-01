<?php

function GetDisplayStyle($value){
	return (strlen($value) > 0) ? 'block' : 'none';
}

$editDlgCssClassName = $model->IsUpdateAllowed ? '' : 'isHidden';

?>
<!DOCTYPE HTML>
<html lang="en">
<head>
<meta charset="utf-8" />
<title><?php echo($model->PageTitle); ?></title>
<script type="text/javascript">var isLegacyIe = false;</script>
<!--[if lt IE 9]>
<script type="text/javascript">isLegacyIe = true;document.getElementsByTagName('html')[0].className='legacyIe';</script>
<script type="text/javascript" src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<script type="text/javascript" src="//explorercanvas.googlecode.com/svn/trunk/excanvas.js"></script>
<link rel="stylesheet" href="<?php echo($model->StaticsPrefix); ?>css/ugsEditorPlus.legacyIe.css" />
<![endif]-->
<link href='https://fonts.googleapis.com/css?family=Peralta|Smokum|Cherry+Cream+Soda|Ranchers|Creepster|Lobster|Permanent+Marker|Architects+Daughter|Bree+Serif' rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="<?php echo($model->StaticsPrefix); ?>css/yuiReset.css" />
<link rel="stylesheet" href="<?php echo($model->StaticsPrefix); ?>css/basic-page-layout.css" />
<link rel="stylesheet" href="<?php echo($model->StaticsPrefix); ?>css/ukeGeeks.music.css" />
<link rel="stylesheet" href="<?php echo($model->StaticsPrefix); ?>css/ukeGeeks.musicPrint.css" media="print" />
<link rel="stylesheet" href="<?php echo($model->StaticsPrefix); ?>css/ugsEditorPlus.merged.css" title="ugsEditorCss" />
<link rel="stylesheet" href="<?php echo($model->StaticsPrefix); ?>css/ugsEditorPlus.print.css" media="print" />
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

.tempo-display {
	font-size: 0.9em;
	color: #888;
	margin-top: 0.2em;
	margin-bottom: 0.5em;
	font-family: Arial, sans-serif;
}

.gema-display {
	font-size: 0.9em;
	color: #888;
	margin-top: 0.2em;
	margin-bottom: 0.5em;
	font-family: Arial, sans-serif;
}

@media print {
	.gema-display, .tempo-display {
		margin-right: 2em;
	}
	.tempo-metronome {
		display: none !important;
	}
}

/* Setlist Navigation Styles */
.setlist-navigation {
	float: right !important;
	margin: 0 0 20px 20px !important;
	width: 240px !important;
	background: rgba(255, 255, 255, 0.95) !important;
	border: 2px solid #007cba !important;
	border-radius: 8px !important;
	padding: 15px !important;
	box-shadow: 0 4px 12px rgba(0,0,0,0.2) !important;
	font-family: Arial, sans-serif !important;
}

@media (max-width: 700px) {
	.setlist-navigation {
		float: none !important;
		margin: 0 0 20px 0 !important;
		width: 100% !important;
	}
}

.setlist-info h4 {
	margin: 0 0 5px 0 !important;
	color: #007cba !important;
	font-size: 14px !important;
	font-weight: bold !important;
}

.setlist-navigation-controls {
	display: flex !important;
	flex-direction: column !important;
	gap: 6px !important;
	margin-bottom: 0 !important;
}

.nav-link {
	display: inline-block !important;
	padding: 0 !important;
	background: none !important;
	color: #007cba !important;
	text-decoration: underline !important;
	border: none !important;
	font-size: 13px !important;
	font-weight: normal !important;
	transition: color 0.2s !important;
	margin-bottom: 2px !important;
}

.nav-link:hover {
	color: #005a87 !important;
}

@media print {
	.setlist-navigation {
		display: none !important;
	}
}

.setlist-navigation strong {
	font-weight: bold !important;
}

<?php if ($model->IsSetlistNavigation): ?>
.tempo-metronome {
	top: 200px !important;
}
@media (max-width: 700px) {
	.tempo-metronome {
		top: 150px !important;
	}
}
<?php endif; ?>
</style>
</head>
<body class="editableSongPage pageWidth_screen<?php if ($model->IsSetlistNavigation) echo ' hasSetlistNav'; ?>">
<div id="tempoMetronomeContainer">
<?php if ($model->Tempo > 0): ?>
<div id="tempoMetronome" class="tempo-metronome" data-tempo="<?php echo($model->Tempo); ?>"><?php echo($model->Tempo); ?></div>
<?php endif; ?>
</div>

<?php if ($model->IsSetlistNavigation): ?>
<div id="setlistNavigationContainer" class="setlist-navigation">
	<div class="setlist-info">
		<h4>Setlist - <?php echo htmlspecialchars($model->SetlistName); ?></h4>
		<?php
		// Show leader of the next song if present
		$nextSong = $model->SetlistSongs[$model->CurrentIndex + 1] ?? null;
		$nextLeader = '';
		if ($nextSong) {
			$nextLeader = $nextSong['Leader'] ?? $nextSong['leader'] ?? '';
		}
		if ($nextLeader) {
			echo '<div style="font-size: 0.97em; color: #444; margin-bottom: 4px;"><strong>' . htmlspecialchars($nextLeader) . '</strong>, you\'re up next. Please tune your instrument and come to the front before the current song finishes</div>';
		}
		?>
	</div>
	<div class="setlist-navigation-controls" style="display: flex; flex-direction: column; gap: 6px;">
		<?php
		// Previous link (if not first song)
		if (!empty($model->PreviousSongId) && $model->CurrentIndex > 0) {
			$prevUrl = $model->PreviousSongId;
			$setlistParam = Config::UseModRewrite ? '?setlist=' : '&setlist=';
			$prevUrl .= $setlistParam . urlencode($_GET['setlist'] ?? '');
			$prevUrl .= '&setlist_index=' . urlencode($model->PreviousSongIndex);
			echo '<a href="' . htmlspecialchars($prevUrl) . '" class="nav-link prev-link">&larr; Previous Song</a>';
		}
		// Next link (if not last song)
		if (!empty($model->NextSongId) && $model->CurrentIndex < count($model->SetlistSongs) - 1) {
			$nextSong = $model->SetlistSongs[$model->CurrentIndex + 1];
			$nextTitle = isset($nextSong['Title']) ? $nextSong['Title'] : (isset($nextSong['title']) ? $nextSong['title'] : '');
			$nextArtist = isset($nextSong['Artist']) ? $nextSong['Artist'] : (isset($nextSong['artist']) ? $nextSong['artist'] : '');
			$nextUrl = $model->NextSongId;
			$setlistParam = Config::UseModRewrite ? '?setlist=' : '&setlist=';
			$nextUrl .= $setlistParam . urlencode($_GET['setlist'] ?? '');
			$nextUrl .= '&setlist_index=' . urlencode($model->NextSongIndex);
			echo '<a href="' . htmlspecialchars($nextUrl) . '" class="nav-link next-link">Next: ' . htmlspecialchars($nextTitle);
			if ($nextArtist) echo ' <span style="color:#888;">by ' . htmlspecialchars($nextArtist) . '</span>';
			echo ' &rarr;</a>';
		}
		?>
	</div>
</div>
<?php endif; ?>
<section id="scalablePrintArea" class="scalablePrintArea">
	<header>
		<div style="display: flex; justify-content: space-between; align-items: flex-start;">
			<div style="flex: 1;">
				<hgroup class="ugs-songInfo">
					<h1 id="songTitle" class="ugs-songTitle"><?php echo($model->SongTitle); ?></h1>
					<h2 id="songSubtitle" class="ugs-songSubtitle" style="display:<?php echo(GetDisplayStyle($model->Subtitle)); ?>;">
						<?php echo($model->Subtitle); ?>
					</h2>
					<h2 id="songArtist" class="ugs-songArtist" style="display:<?php echo(GetDisplayStyle($model->Artist)); ?>;">
						<?php echo($model->Artist); ?>
					</h2>
					<h2 id="songAlbum" class="ugs-songAlbum" style="display:<?php echo(GetDisplayStyle($model->Album)); ?>;">
						<?php echo($model->Album); ?>
					</h2>
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
	<div class="metaInfo" id="songMeta"> </div>
	<article id="ukeSongContainer" class="ugsLayoutTwoColumn ugs-song-wrap">
		<aside id="ukeChordsCanvas" class="ugs-diagrams-wrap ugs-grouped"></aside>
		<article id="ukeSongText" class="ugs-source-wrap">
			<pre><?php echo($model->Body); ?></pre>
		</article>
	</article>
	<footer>
		<p>Note: <span id="footTuningInfo">Standard <strong>GCEA</strong> Soprano Ukulele</span> Tuning. <small>Powered by <a href="http://ukegeeks.com/" title="Uke Geeks for free ukulele JavaScript tools">UkeGeeks' Scriptasaurus</a> &bull; ukegeeks.com</small></p>
	</footer>
</section>
<!-- EDIT SONG (DIALOG) -->
<section id="songSourceDlg" class="overlay <?php echo($editDlgCssClassName); ?>">
	<hgroup>
		<h3>Edit Song</h3>
        <?php if (!$model->IsUpdateAllowed) { ?>
            <h4>WARNING: This song is protected!</h4>
        <?php } ?>
	</hgroup>
	<div>
		<a title="close this" href="#close" class="closeBtn">Close</a>
		<a title="switch to fullscreen editor" href="#resize" class="resizeBtn">Fullscreen</a>
		<p class="btnBar">
			<span id="messageBox" class="updateMessage">
				<em>
					<img src="<?php echo($model->StaticsPrefix); ?>img/editor/busy.gif" id="loadingSpinner" style="display:none;" />
					<span id="sourceFeedback"></span>
				</em>
			</span>
			<?php if ($model->IsUpdateAllowed) { ?>
				<input type="button" id="updateBtn" class="baseBtn blueBtn" value="Update" title="Rebuild digarams and music" />
				<input type="button" id="saveBtn" class="baseBtn orange" value="Save" title="Save" style="margin-right:1.6em;" />
			<?php } ?>
			<a href="#chordBuilder" id="cdBldOpenBtn" data-dialog="cdBldDlg" class="alternateBtn" title="Add custom &amp; alternate chord diagrams">Chord Builder</a>
		</p>
        <textarea id="chordProSource" wrap="off"<?php if (!$model->IsUpdateAllowed) { ?> class="editLocked"<?php } ?>><?php echo($model->Body); ?></textarea>

	</div>
</section>
<!-- APP TOOLBAR -->
<section id="ugsAppToolbar" class="ugsAppMenuBar">
	<ul>
		<li><a href="<?php echo Ugs::MakeUri(Actions::Songbook); ?>" title="Back to song list"><span></span>Home</a></li>
		<li class="navEdit" data-dialog="songSourceDlg"> <a href="#songSourceDlg" title="View &amp; edit the song source"><span></span>Edit</a> </li>
		<li class="navLayout showOptionsBox"> <a href="#layoutOptions" title="Resize fonts &amp; chord diagrams. Customize layout &amp; colors."><span></span>Appearance</a></li>
		<li class="navInstruments showOptionsBox"> <a href="#tuningOptions" title="Transpose song's key &amp; choose your prefered ukulele tuning"><span></span>Transpose</a></li>
		<li class="navOptions showOptionsBox"> <a href="#optionsDlg" title="Advanced options &amp; settings"><span></span>Options</a> </li>
		<li class="showDlgBtn showOptionsBox"> <a href="#helpDlg" title="Help &amp; Quick tips on formatting your song">?</a> </li>
	</ul>
	<h2 class="ugsLogo">Uke Geeks Song-a-Matic</h2>
</section>
<!-- LAYOUT OPTIONS -->
<aside class="arrowBox layoutOptions" id="layoutOptions">
	<fieldset class="arrowBoxContent enablePseudoSelects">
		<dl>
			<dt><label for="fontSizePicker"><span>Font size 12pt</span> <em>&#9658;</em></label></dt>
			<dd id="fontSizePicker" data-action="zoomFonts">
				<ul class="pseudoSelect">
					<li><a href="#6">6 pt </a></li>
					<li><a href="#6.5">6.5 pt </a></li>
					<li><a href="#7">7 pt </a></li>
					<li><a href="#7.5">7.5 pt </a></li>
					<li><a href="#8">8 pt </a></li>
					<li><a href="#8.5">8.5 pt </a></li>
					<li><a href="#9">9 pt </a></li>
					<li><a href="#9.5">9.5 pt </a></li>
					<li><a href="#10">10 pt </a></li>
					<li><a href="#11">11 pt </a></li>
					<li class="checked"><a href="#12">12 pt </a></li>
					<li><a href="#13">13 pt </a></li>
					<li><a href="#14">14 pt </a></li>
				</ul>
			</dd>
			<dt><label for="diagramSizePicker"><span>Stupid Large diagrams</span> <em>&#9658;</em></label></dt>
			<dd id="diagramSizePicker" data-action="zoomDiagrams">
				<ul class="pseudoSelect">
					<li><a href="#35">Tiny </a></li>
					<li><a href="#45">Small </a></li>
					<li><a href="#65">Medium </a></li>
					<li><a href="#80">Large </a></li>
					<li class="checked"><a href="#100">Stupid Large </a></li>
				</ul>
			</dd>
			<dt><label for="diagramPositionPicker"><span>Reference diagrams on left</span> <em>&#9658;</em></label></dt>
			<dd id="diagramPositionPicker" data-action="layout">
				<ul class="pseudoSelect">
					<li class="checked"><a href="#left">On left side (floating)</a></li>
					<li><a href="#right">On right side</a></li>
					<li><a href="#top">At the top</a></li>
					<li><a href="#none">Don't show</a></li>
				</ul>
			</dd>
			<dt><label for="lyricChordsPicker"><span>Chord names above lyrics</span> <em>&#9658;</em></label></dt>
			<dd id="lyricChordsPicker" data-action="placement">
				<ul class="pseudoSelect">
					<li><a href="#inline">Chord names inline </a></li>
					<li class="checked"><a href="#above">Chord names above </a></li>
					<li><a href="#miniDiagrams">Names &amp; diagrams above </a></li>
				</ul>
			</dd>
			<dt><label for="colorPicker"><span>Normal colors (white paper) </span><em>&#9658;</em></label></dt>
			<dd id="colorPicker" data-action="colors">
				<ul class="pseudoSelect"></ul>
			</dd>
			<dt><label for="metronomePicker"><span>Metronome</span> <em>&#9658;</em></label></dt>
			<dd id="metronomePicker" data-action="metronome">
				<ul class="pseudoSelect">
					<li><a href="#start">Start Metronome</a></li>
				</ul>
			</dd>
		</dl>
	</fieldset>
</aside>
<!-- TUNING OPTIONS -->
<aside class="arrowBox tuningOptions" id="tuningOptions">
	<fieldset class="arrowBoxContent enablePseudoSelects">
		<dl>
			<dt><label for="transposePicker"><span>Original key</span> <em>&#9658;</em></label></dt>
			<dd id="transposePicker" data-action="transpose">
				<ul class="pseudoSelect" id="transposeOptions">
					<li><a href="#down_6">-6 <em>F#</em></a></li>
					<li><a href="#down_5">-5 <em>G</em></a></li>
					<li><a href="#down_4">-4 <em>G#</em></a></li>
					<li><a href="#down_3">-3 <em>A</em></a></li>
					<li><a href="#down_2">-2 <em>A#</em></a></li>
					<li><a href="#down_1">-1 <em>B</em></a></li>
					<li class="checked"><a href="#up_0">Original <em>C</em></a></li>
					<li><a href="#up_1">+1 <em>C#</em></a></li>
					<li><a href="#up_2">+2 <em>D</em></a></li>
					<li><a href="#up_3">+3 <em>D#</em></a></li>
					<li><a href="#up_4">+4 <em>E</em></a></li>
					<li><a href="#up_5">+5 <em>F</em></a></li>
					<li><a href="#up_6">+6 <em>F#</em></a></li>
				</ul>
			</dd>
			<dt><label for="tuningPicker"><span>Soprano ukulele tuning</span> <em>&#9658;</em></label></dt>
			<dd id="tuningPicker" data-action="tuning">
				<ul class="pseudoSelect">
					<li class="checked"><a href="#soprano">Soprano</a></li>
					<li><a href="#baritone">Baritone</a></li>
				</ul>
			</dd>
		</dl>
	</fieldset>
</aside>
<!-- OTHER OPTIONS -->
<aside class="arrowBox otherOptions" id="optionsDlg">
	<fieldset class="arrowBoxContent">
		<dl class="enablePseudoSelects">
			<dt><label for="pagePicker"><span>Paper</span> <em>&#9658;</em></label></dt>
			<dd id="pagePicker" data-action="paper">
				<ul class="pseudoSelect" id="pageWidth">
					<li class="checked"><a href="#letter">US Letter (8.5 x 11 in)</a></li>
					<li><a href="#a4">A4 (21 x 29.7 cm)</a></li>
					<li><a href="#screen">full screen</a></li>
				</ul>
			</dd>
		</dl>
	</fieldset>
	<fieldset class="arrowBoxContent">
		<p class="checkboxBlock">
			<input type="checkbox" value="true" id="chkEnclosures" checked="checked" />
			<label for="chkEnclosures">Hide chord enclosures
				<span class="checkBoxFinePrint">don't put [brackets] around chord names</span>
			</label>
		</p>
		<p class="checkboxBlock">
			<input type="checkbox" value="true" id="chkSortAlpha" checked="checked" />
			<label for="chkSortAlpha">Sort reference diagrams alphabetically
				<span class="checkBoxFinePrint">otherwise &ldquo;song order&rdquo; is used</span>
			</label>
		</p>
		<p class="checkboxBlock">
			<input type="checkbox" value="true" id="chkIgnoreCommon" checked="checked" />
			<label for="chkIgnoreCommon">Ignore common chords
				<span class="checkBoxFinePrint">don't create master chord diagrams for these chords:</span>
			</label>
			<input type="text" id="commonChordList" value="" />
		</p>
	</fieldset>
</aside>
<!-- HELP (DIALOG) -->
<aside class="arrowBox helpOptions" id="helpDlg">
	<fieldset class="arrowBoxContent linksList">
		<ul>
			<li><a href="http://blog.ukegeeks.com/users-guide/" target="_blank" title="View the complete documentation including ChordPro tips">User Guide</a></li>
			<li><a href="http://ukegeeks.com/tools/chord-finder.htm" target="_blank" title="Access the UkeGeeks library of common chords">Chord Finder</a></li>
			<li><a href="http://ukegeeks.com/tools/reverse-chord-finder.htm" target="_blank" title="Find chord names by drawing the diagram">Reverse Chord Lookup</a></li>
		</ul>
	</fieldset>
</aside>

<!-- REFORMAT (DIALOG) -->
<section id="reformatDlg" class="reformatDlg overlay isHidden">
	<hgroup>
		<h3>Use Auto-Formated Version?</h3>
	</hgroup>
	<div>
		<!-- <a title="resize this" href="#resize" class="resizeBtn">Resize</a> -->
		<p class="instructions">Whoa! I didn't find any chords in your song -- it's probably not in ChordPro format. Here's the converted version&hellip;</p>
		<p class="btnBar">
			<input type="button" id="reformatYesBtn" class="baseBtn blueBtn" value="OK, Use This!" />
			<a id="reformatNoBtn" href="#noThanks" class="noThanks">No, Thanks!</a>
		</p>
		<textarea id="reformatSource" wrap="off"></textarea>
		<p class="instructions small">Want to make more adjustments? Click &ldquo;No Thanks&rdquo; and try the <a href="http://ukegeeks.com/tools" target="_blank" title="open the reformat tool in a new window">Reformater Tool</a> instead.</p>
		<p class="instructions small"><input type="checkbox" value="true" id="reformatDisable" /> <label for="reformatDisable">Don't perform this check again.</label></p>
	</div>
</section>

<!-- CHORD BUILDER (DIALOG) -->
<section id="cdBldDlg" class="overlay chordBuilderDlg isHidden chordBuilderNarrow">
	<hgroup>
		<h3>Chord Builder</h3>
	</hgroup>
	<div>
		<a title="close this" href="#close" class="closeBtn">Close</a>
		<div id="cdBldChooserPanel">
			<ul id="cdBldPick" class="ugsChordChooser"></ul>
		</div>
		<div id="cdBldBuilderPanel" style="display:none">
			<p class="">
				<label for="cdBldChordName">Chord Name: <input class="chordName" type="text" id="cdBldChordName" value="CHORDNAME" /></label>
			</p>
			<div class="editorSurface" id="cdBldEditorSurface">
				<div class="toolboxEdgeShadow leftEdge"></div>
				<div id="cdBldToolbox" class="chordToolbox leftEdge">
					<div class="chordToolboxInner">
						<a href="#dots" id="cdBldDotsBtn" class="toolChip selected">Add Dots <span class="bigDot"></span></a>
						<a href="#fingers" id="cdBldFingersBtn" class="toolChip">Set Fingers <span id="cdBldBtnDiagram" class="fingerToolImage finger1"><span class="fingerDot"></span></span><span id="cdBldBtnFingerName"></span></a>
					</div>
				</div>
				<div class="toolboxEdgeShadow rightEdge"></div>
				<div class="chordToolbox rightEdge">
					<div class="chordToolboxInner">
						<label for="cdBldStartingFret" class="toolChip">Starting Fret
							<select id="cdBldStartingFret"></select>
						</label>
						<a href="#slide-up" id="toolboxSlideUpBtn" class="toolChip arrowUp" data-direction="up" title="move all dots -1 fret">Slide Up</a>
						<a href="#slide-down" id="toolboxSlideDownBtn" class="toolChip arrowDown" data-direction="down" title="move all dots +1 fret">Slide Down</a>
					</div>
				</div>
				<canvas id="cdBldCursorCanvas" width="462" height="300"></canvas>
				<canvas id="cdBldDiagramCanvas" width="462" height="300"></canvas>
			</div>

			<p class="">
				<label for="cdBldShowOutputBtn"><input id="cdBldShowOutputBtn" type="checkbox" value="0" /> Show ChordPro output</label>
			</p>
			<p class="btnBar">
				<input type="button" value="Add" class="baseBtn blueBtn" id="cdBldSaveBtn">
				<a href="#closeBuilder" id="cdBldCancelBtn" class="noThanks">Cancel</a>
			</p>
			<div id="cdBldOutputBox" class="outputBox collapseOutput" style="clear:right;">
				<pre id="cdBldOutput" class="chordPro-statement" title="Your ChordPro define tag"></pre>
			</div>
		</div>
	</div>
</section>

<!-- SCRIPTS -->
<script type="text/javascript" src="<?php echo($model->StaticsPrefix); ?>js/jquery-1.9.1.min.js"></script>
<script type="text/javascript" src="<?php echo($model->StaticsPrefix); ?>js/jquery.draggable.js"></script>
<script type="text/javascript" src="<?php echo($model->StaticsPrefix); ?>js/ukeGeeks.scriptasaurus.merged.js"></script>
<script type="text/javascript" src="<?php echo($model->StaticsPrefix); ?>js/ugsEditorPlus.merged.js"></script>
<script type="text/javascript" src="<?php echo($model->StaticsPrefix); ?>js/startup.js"></script>
<script type="text/javascript">
var ugs_settings = <?php echo($model->EditorSettingsJson); ?>;
if (ugs_settings && ugs_settings.invalidJson){
	alert(ugs_settings.invalidJson);
	ugs_settings = {};
}
</script>
<script type="text/javascript">
$(function() {
	var ugs_settings = window.ugs_settings || {};
	ugs_settings.useLegacyIe = isLegacyIe;
	ugsEditorPlus.songAmatic.init(ugs_settings);

<?php if ($model->IsUpdateAllowed) {
	?>
	ugsEditorPlus.updateSong.init("<?php echo($model->UpdateAjaxUri); ?>", "<?php echo($model->Id); ?>");
	<?php
	}
?>

<?php if ($model->IsSetlistNavigation && $model->Transpose != 0): ?>
	// Auto-trigger transpose if setlist has a non-zero transpose value
	$(document).ready(function() {
		setTimeout(function() {
			var transposeValue = <?php echo $model->Transpose; ?>;
			var transposeAction = '';
			
			if (transposeValue > 0) {
				transposeAction = 'up_' + transposeValue;
			} else if (transposeValue < 0) {
				transposeAction = 'down_' + Math.abs(transposeValue);
			}
			
			if (transposeAction) {
				// Trigger the transpose action using the jQuery event system
				$.event.trigger('option:click', {
					action: 'transpose',
					value: transposeAction
				});
				
				// Update the UI to show the current transpose state
				var transposePicker = $('#transposePicker');
				if (transposePicker.length) {
					transposePicker.find('li').removeClass('checked');
					transposePicker.find('a[href="#' + transposeAction + '"]').parent().addClass('checked');
					transposePicker.find('span').text('<?php echo ($model->Transpose > 0 ? '+' : '') . $model->Transpose; ?> semitones');
				}
			}
		}, 500); // Small delay to ensure the editor is fully initialized
	});
<?php endif; ?>
});
</script>
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
