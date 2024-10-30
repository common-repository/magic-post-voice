jQuery(document).ready(function($) {
	
	$(document).on( 'click', '.webreader-image',function(e) {
		e.preventDefault();
		if(responsiveVoice.voiceSupport()) {
			$( ".webreader-image" ).hide( "slow", function() {});
			$( ".webreader-image-off" ).show( "fast", function() {});
			$( ".webreader-image-pause" ).show( "fast", function() {});
			responsiveVoice.setDefaultVoice( voice_values.voice_lang );
			responsiveVoice.speak( 
				voice_values.content.toLowerCase(), voice_values.voice_lang, {
					pitch: voice_values.pitch, rate: voice_values.rate, volume: voice_values.volume
				} 
			);
		}
	});
	$(document).on( 'click', '.webreader-image-off',function(e) {
		e.preventDefault();
		responsiveVoice.cancel();
		$( ".webreader-image" ).show( "fast", function() {});
		$( ".webreader-image-off" ).hide( "slow", function() {});
		$( ".webreader-image-pause" ).hide( "fast", function() {});
		$( ".webreader-image-resume" ).hide( "fast", function() {});
	});
	
	$(document).on( 'click', '.webreader-image-pause',function(e) {
		e.preventDefault();
		responsiveVoice.pause();
		$( ".webreader-image-pause" ).hide( "slow", function() {});
		$( ".webreader-image-resume" ).show( "fast", function() {});
	});
	
	$(document).on( 'click', '.webreader-image-resume',function(e) {
		e.preventDefault();
		responsiveVoice.resume();
		$( ".webreader-image-pause" ).show( "fast", function() {});
		$( ".webreader-image-resume" ).hide( "slow", function() {});
	});
});