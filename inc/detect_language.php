<?php

function get_browser_language() {
	if ( isset( $_SERVER[ 'HTTP_ACCEPT_LANGUAGE' ] ) ) {
		$langs = explode( ',', $_SERVER['HTTP_ACCEPT_LANGUAGE'] );
		
		$browser_lang = substr( $langs[ 0 ], 0, 2 );
	} else {
		$browser_lang = 'en';
	}


	switch ( $browser_lang ) {
		case 'de':
			$voice = "Deutsch Female";
			break;
		case 'fr':
			$voice = "French Female";
			break;
		case 'es':
			$voice = "Spanish Female";
			break;
		case 'it':
			$voice = "Italian Female";
			break;
		case 'gr':
			$voice = "Greek Female";
			break;
		case 'hu':
			$voice = "Hungarian Female";
			break;
		case 'tr':
			$voice = "Turkish Female";
			break;
		case 'ru':
			$voice = "Russian Female";
			break;
		case 'tr':
			$voice = "Turkish Female";
			break;
		case 'nl':
			$voice = "Dutch Female";
			break;
		case 'sv':
			$voice = "Swedish Female";
			break;
		case 'no':
			$voice = "Norwegian Female";
			break;
		case 'jp':
			$voice = "Japanese Female";
			break;
		case 'kr':
			$voice = "Korean Female";
			break;
		case 'cn':
			$voice = "Chinese Female";
			break;
		case 'rs':
			$voice = "Serbian Male";
			break;
		case 'hr':
			$voice = "Croatian Male";
			break;
		case 'ba':
			$voice = "Bosnian Male";
			break;
		case 'ro':
			$voice = "Romanian Male";
			break;
		case 'au':
			$voice = "Australian Female";
			break;
		case 'fi':
			$voice = "Finnish Female";
			break;
		case 'al':
			$voice = "Albanian Male";
			break;
		case 'am':
			$voice = "Armenian Male";
			break;
		case 'cz':
			$voice = "Czech Female";
			break;
		case 'dk':
			$voice = "Danish Female";
			break;
		case 'is':
			$voice = "Icelandic Male";
			break;
		case 'id':
			$voice = "Indonesian Female";
			break;
		case 'lv':
			$voice = "Latvian Male";
			break;
		case 'mk':
			$voice = "Macedonian Male";
			break;
		case 'md':
			$voice = "Moldavian Male";
			break;
		case 'me':
			$voice = "Montenegrin Male";
			break;
		case 'pl':
			$voice = "Polish Female";
			break;
		case 'br':
			$voice = "Brazilian Portuguese Female";
			break;
		case 'pt':
			$voice = "Portuguese Female";
			break;
		case 'sk':
			$voice = "Slovak Female";
			break;
		case 'th':
			$voice = "Thai Female";
			break;
		case 'vn':
			$voice = "Vietnamese Male";
			break;
		 default:
			$voice = "UK English Female";
			break;
	}
	
	return $voice;

}

?>