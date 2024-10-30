<?php

if ( ! function_exists( 'add_filter' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
		exit();
}


// Settings Options
if(!function_exists("default_options_main_settings")) {
	function default_options_main_settings( $never_set = FALSE ) {
		
		if( $never_set == TRUE ) {
			$post_types_default = get_post_types( '', 'objects');
			unset( $post_types_default['attachment'], $post_types_default['revision'], $post_types_default['nav_menu_item'] );
			foreach ($post_types_default  as $post_type ) {
				$default_post_types[$post_type->name] = $post_type->name;
			}
		} else {
			$default_post_types = array();
		}
		
		$default_options = array(
		
			// GENERAL
			'responsiveVoiceApiKey'	 => '',
			'language'	        	 => 'UK English Female',
			'choosed_post_type'		 => $default_post_types,
			'position'	       		 => 'header',
			'pitch'	                 => 1,
			'rate'	                 => 1,
			'volume'	      		 => 1,
		);
		
		return $default_options;
	}
}

?>