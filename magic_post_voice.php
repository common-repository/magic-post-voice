<?php
/*
Plugin Name: Magic Post Voice
Plugin URI: http://wordpress.org/plugins/magic-post-voice/
Description: Add automatically a voice to your page content
Version: 1.2
Author: Magic Post Voice
Text Domain: 'mpv'
Domain Path: /languages


Copyright 2020 Magic Post Voice

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

*/

class MagicPostVoice {

	public function __construct() {
		
		if( is_admin() ) {
			
			add_action( 'admin_menu', array( &$this, 'MPV_menu' ) );
			
			register_activation_hook( __FILE__, array( &$this, 'MPV_default_values' ) );
			
			add_filter('plugin_action_links', array( &$this, 'MPV_add_settings_link'), 10, 2 );
			
			load_plugin_textdomain( 'mpv', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		}
		
		add_shortcode( 'magic_post_voice', array( &$this, 'MPV_show_voice' ) );
		
		add_action( 'wp_head', array( &$this, 'MPV_head_singular_check') );
		add_action( 'wp_enqueue_scripts', array( &$this, 'MPV_add_scripts') );
		
	}
	
	function MPV_menu() {
		add_options_page( 'Magic Post Voice Options', 'Magic Post Voice', 'manage_options', 'mpv', array( &$this, 'MPV_options' ) );
		
		require_once( dirname( ( __FILE__ ) ) . '/inc/default_values.php' );
		register_setting('MPT-plugin-main-settings', 'MPV_plugin_main_settings');
		
		/* Generate options on Custom post type */
		$post_type_availables = get_option( 'MPV_plugin_main_settings' );
		
		if( empty( $post_type_availables['choosed_post_type'] ) ) {
			return false;
		}
	}
	
	/* Display MPV Options */
	public function MPV_options() {
	
		if ( !current_user_can( 'manage_options' ) ) {
			wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
		}
		
		require_once( dirname( ( __FILE__ ) ) . '/inc/admin/main.php' );
		
	}
	
	/* Set Default value when activated and never configured */
	public function MPV_default_values() {
		$main_options  = get_option( 'MPV_plugin_main_settings' );
		
		/* Options Never set */
		if( !$main_options && !$banks_options && !$cron_options ) {
			require_once( dirname( ( __FILE__ ) ) . '/inc/default_values.php' );
			$options_main_default  = default_options_main_settings( TRUE );
			update_option( 'MPV_plugin_main_settings', $options_main_default );
		}
	}
	
	/* Add Settings link to plugins */
	function MPV_add_settings_link( $links, $file ) {
		static $this_plugin;
		if ( !$this_plugin )
			$this_plugin = plugin_basename(__FILE__);
		 
		if ( $file == $this_plugin ){
			$settings_link .= '<a href="options-general.php?page=mpv">'.__("Settings", "mpv").'</a>';
			array_unshift( $links, $settings_link );
		}

		return $links;
	}
	
	/* Head : Check if it's singular page */
	function MPV_head_singular_check() {
		require_once( dirname( ( __FILE__ ) ) . '/inc/default_values.php' );
		$options = wp_parse_args( get_option( 'MPV_plugin_main_settings' ), default_options_main_settings( FALSE ) );
		$api_key = sanitize_text_field( $options['responsiveVoiceApiKey'] );
		
		if( is_singular( $options['choosed_post_type'] ) && !empty( $api_key ) ) {
			add_filter( 'the_content', array( &$this, 'MPV_voice' ) );
		} else {
			return false;
		}
	}
	
	/* Add scripts */
	function MPV_add_scripts() {
		
		require_once( dirname( ( __FILE__ ) ) . '/inc/default_values.php' );
		$options = wp_parse_args( get_option( 'MPV_plugin_main_settings' ), default_options_main_settings( FALSE ) );
		
		// Autodetect language
		if( $options['language'] == 'Autodetect' ) {
			require_once( dirname( ( __FILE__ ) ) . '/inc/detect_language.php' );
			$options['language'] = get_browser_language();
		}
		
		$api_key = sanitize_text_field( $options['responsiveVoiceApiKey'] );
		
		// Stop if no API key
		if( empty( $api_key ) )
			return false;
		
		/* Check if it's singular page or Shortcode */
		if( is_singular( $options['choosed_post_type'] ) || shortcode_exists( 'magic_post_voice' ) ) {
			
			wp_enqueue_script( 'responsive-voice', 'https://code.responsivevoice.org/responsivevoice.js?key='.$api_key, array(), '1.0' );
			wp_enqueue_script( 'voice-trigger', plugins_url( 'assets/js/voicetrigger.js', __FILE__ ), array( 'jquery', 'responsive-voice' ), '1.0' );
			wp_enqueue_style( 'style-voice', plugins_url( 'assets/css/style-voice.css', __FILE__ ) );
			
			$content_post = get_post( get_the_ID() );
			$content      = strip_shortcodes( $content_post->post_content );
			$voice_values = array ( 
				'content'    => strip_tags( $content ),
				'voice_lang' => $options['language'],
				'pitch'      => $options['pitch'],
				'rate'       => $options['rate'],
				'volume'     => $options['volume']
			);
			wp_localize_script( 'voice-trigger', 'voice_values', $voice_values );
			
		} else {
			return false;
		}
	}
	
	/* Add Voice to content */
	function MPV_voice( $content ) {
			
		$content_voice = '<span href="#" class="webreader-button webreader-image"><img src="' .  plugins_url( 'assets/img/play.png', __FILE__ ) . '" title="' . __("Voice Reader", "mpv") . '"/></span> 
		<span href="#" class="webreader-button webreader-image-off"><img src="' .  plugins_url( 'assets/img/stop.png', __FILE__ ) . '" title="' . __("Stop Voice Reader", "mpv") . '"/></span>
		<span href="#" class="webreader-button webreader-image-pause"><img src="' .  plugins_url( 'assets/img/pause.png', __FILE__ ) . '" title="' . __("Pause", "mpv") . '"/></span>
		<span href="#" class="webreader-button webreader-image-resume"><img src="' .  plugins_url( 'assets/img/play.png', __FILE__ ) . '" title="' . __("Resume", "mpv") . '"/></span>';
		
		require_once( dirname( ( __FILE__ ) ) . '/inc/default_values.php' );
		$options = wp_parse_args( get_option( 'MPV_plugin_main_settings' ), default_options_main_settings( FALSE ) );
		
		if(  $options['position'] == 'footer' ) {
			$content = $content . $content_voice;
		} else {
			$content = $content_voice . $content;
		}
		
		return $content;
	}

	// Function for shortcode
	function MPV_show_voice( $atts, $content ) {
		add_action( 'wp_enqueue_scripts', array( &$this, 'MPV_add_scripts') );
		
		if( shortcode_exists( 'magic_post_voice' ) ) {
			$content_voice = '<span href="#" class="webreader-button webreader-image"><img src="' .  plugins_url( 'assets/img/play.png', __FILE__ ) . '" title="' . __("Voice Reader", "mpv") . '"/></span> 
			<span href="#" class="webreader-button webreader-image-off"><img src="' .  plugins_url( 'assets/img/stop.png', __FILE__ ) . '" title="' . __("Stop Voice Reader", "mpv") . '"/></span>
			<span href="#" class="webreader-button webreader-image-pause"><img src="' .  plugins_url( 'assets/img/pause.png', __FILE__ ) . '" title="' . __("Pause", "mpv") . '"/></span>
			<span href="#" class="webreader-button webreader-image-resume"><img src="' .  plugins_url( 'assets/img/play.png', __FILE__ ) . '" title="' . __("Resume", "mpv") . '"/></span>';
			
			return $content_voice;
		}
	}
	
}


$MPV = new MagicPostVoice();


?>