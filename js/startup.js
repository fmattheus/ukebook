/**
 * For demo purposes allows one to turn on/off the inlineDiagrams setting. 
 * @method checkUrlOpts
 * @return {void}
 */
function checkUrlOpts(){
	var re = new RegExp("[?&]inline=([^&]*)", "i");
	var m = ('' + window.location).match(re);
	if (!m || m.length < 1){
		return;
	}
	ukeGeeks.settings.inlineDiagrams = true;
}

/**
 * Initialize metronome functionality
 * @method initMetronome
 * @return {void}
 */
function initMetronome() {
	var metronome = document.getElementById('bpmMetronome');
	if (!metronome) return;
	
	var bpm = parseInt(metronome.getAttribute('data-bpm'));
	if (bpm <= 0) return;
	
	// Get metronome timeout from settings, default to 15 seconds
	var metronomeTimeout = 15; // default
	if (window.ugs_settings && window.ugs_settings.metronomeTimeout) {
		metronomeTimeout = parseInt(window.ugs_settings.metronomeTimeout);
	}
	
	var isRunning = false;
	var intervalId = null;
	var timeoutId = null;
	
	function startMetronome() {
		if (isRunning) return;
		isRunning = true;
		
		// Calculate animation duration based on BPM
		var beatInterval = 60000 / bpm; // milliseconds per beat
		var animationDuration = beatInterval / 1000; // convert to seconds
		
		// Set the animation duration dynamically with !important
		metronome.style.setProperty('animation-duration', animationDuration + 's', 'important');
		
		// Remove hidden class to show the metronome
		metronome.classList.remove('hidden');
		
		// Start the bouncing animation
		metronome.classList.add('bouncing');
	}
	
	function stopMetronome() {
		if (!isRunning) return;
		isRunning = false;
		
		// Stop the bouncing animation and hide the element completely
		metronome.classList.remove('bouncing');
		metronome.classList.add('hidden');
		
		if (intervalId) {
			clearInterval(intervalId);
			intervalId = null;
		}
		
		if (timeoutId) {
			clearTimeout(timeoutId);
			timeoutId = null;
		}
	}
	
	function restartMetronome() {
		stopMetronome();
		startMetronome();
		
		// Stop metronome after configured timeout
		timeoutId = setTimeout(function() {
			stopMetronome();
		}, metronomeTimeout * 1000);
	}
	
	// Start metronome when page loads
	startMetronome();
	
	// Stop metronome after configured timeout
	timeoutId = setTimeout(function() {
		stopMetronome();
	}, metronomeTimeout * 1000);
	
	// Hide metronome when clicked
	metronome.addEventListener('click', function() {
		stopMetronome();
	});
	
	// Handle metronome menu action (for editable view)
	document.addEventListener('click', function(e) {
		if (e.target && e.target.getAttribute('href') === '#start' && 
			e.target.closest('#metronomePicker')) {
			restartMetronome();
		}
	});
	
	// Stop when page becomes hidden (user switches tabs)
	document.addEventListener('visibilitychange', function() {
		if (document.hidden) {
			stopMetronome();
		} else {
			startMetronome();
		}
	});
}

/**
 * Here we've added a call to checkUrlOpts in what's otherwise a 
 * very "standard" way to run Scriptasaurus.
 */
if (isLegacyIe){
	window.attachEvent('onload',function(){
		checkUrlOpts();
		ukeGeeks.scriptasaurus.init(true);
		ukeGeeks.scriptasaurus.run();
		initMetronome();
	});
}
else{
	(function(){
		checkUrlOpts();
		ukeGeeks.scriptasaurus.init(false);
		ukeGeeks.scriptasaurus.run();
		initMetronome();
	})();
}