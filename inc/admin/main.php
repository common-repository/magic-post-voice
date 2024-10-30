<?php
if ( ! function_exists( 'add_filter' ) ) {
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
		exit();
}
?>
<div class="wrap">
	
	<h2 >Magic Post Voice : <?php _e( 'Settings', 'mpv' ); ?></h2>
	
	<?php
		if ( ( ! empty( $_POST['mpv'] ) || ! empty( $_REQUEST['ids'] ) ) && ( empty( $_REQUEST['settings-updated'] ) || $_REQUEST['settings-updated'] != 'true' ) ) { ?>
				<div id="ids" style="display:none;"><?php echo $_REQUEST['ids']; ?></div>
				<div id="hide-before-import" style="display:none">
					<div id="progressbar"></div>
					<div id="results" ></div>
				</div>
	<?php } ?>
	
	<form method="post" action="options.php" >

		<?php 
			settings_fields( 'MPT-plugin-main-settings' );
			$options = wp_parse_args( get_option( 'MPV_plugin_main_settings' ), default_options_main_settings( FALSE ) );
		?>
		
		<table id="general-options" class="form-table">
			<tbody>
				
				<tr valign="top">
					<td colspan="2">
						<div class="update-nag">
							<?php _e('From now on, it\'s required to provide your own <b>ResponsiveVoice API key</b>. You must <a target="_blank" href="https://responsivevoice.org/register">register your website</a> and get your <strong>API Key</strong>', 'mpv' ); ?>
						</div>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row">
						<?php _e( 'ResponsiveVoice API Key', 'mpv' ); ?>
					</th>
					<td>
						<input type="text" name="MPV_plugin_main_settings[responsiveVoiceApiKey]" value="<?php echo( isset( $options['responsiveVoiceApiKey'] ) && !empty( $options['responsiveVoiceApiKey'] ) )? $options['responsiveVoiceApiKey']: ''; ?>">
					</td>
				</tr>
			
				<tr valign="top">
					<th scope="row">
						<label for="hseparator"><?php _e( 'Language', 'mpv' ); ?></label>
					</th>
					<td class="based_on">
						<select name="MPV_plugin_main_settings[language]" >
							<?php
								$selected = $options['language'];
								$country_choose = array(
									'Autodetect'                          => __( 'Autodetect (Detect browser language)', 'mpv' ),
									'UK English Female'                   => __( 'UK English Female', 'mpv' ),
									'UK English Male'                     => __( 'UK English Male', 'mpv' ),
                                    'US English Female'                   => __( 'US English Female', 'mpv' ),
									'US English Male'                     => __( 'US English Male', 'mpv' ),
									'Spanish Female'                      => __( 'Spanish Female', 'mpv' ),
                                    'Spanish Male'                        => __( 'Spanish Male', 'mpv' ),
									'French Female'                       => __( 'French Female', 'mpv' ),
                                    'French Male'                         => __( 'French Male', 'mpv' ),
									'Deutsch Female'                      => __( 'Deutsch Female', 'mpv' ),
                                    'Deutsch Male'                        => __( 'Deutsch Male', 'mpv' ),
									'Italian Female'                      => __( 'Italian Female', 'mpv' ),
                                    'Italian Male'                        => __( 'Italian Male', 'mpv' ),
									'Greek Female'                        => __( 'Greek Female', 'mpv' ),
                                    'Greek Male'                          => __( 'Greek Male', 'mpv' ),
									'Hungarian Female'                    => __( 'Hungarian Female', 'mpv' ),
                                    'Hungarian Male'                      => __( 'Hungarian Male', 'mpv' ),
									'Turkish Female'                      => __( 'Turkish Female', 'mpv' ),
                                    'Turkish Male'                        => __( 'Turkish Male', 'mpv' ),
									'Russian Female'                      => __( 'Russian Female', 'mpv' ),
                                    'Russian Male'                        => __( 'Russian Male', 'mpv' ),
									'Dutch Female'                        => __( 'Dutch Female', 'mpv' ),
                                    'Dutch Male'                          => __( 'Dutch Male', 'mpv' ),
									'Swedish Female'                      => __( 'Swedish Female', 'mpv' ),
                                    'Swedish Male'                        => __( 'Swedish Male', 'mpv' ),
									'Norwegian Female'                    => __( 'Norwegian Female', 'mpv' ),
                                    'Norwegian Male'                      => __( 'Norwegian Male', 'mpv' ),
									'Japanese Female'                     => __( 'Japanese Female', 'mpv' ),
                                    'Japanese Male'                       => __( 'Japanese Male', 'mpv' ),
									'Korean Female'                       => __( 'Korean Female', 'mpv' ),
                                    'Korean Male'                         => __( 'Korean Male', 'mpv' ),
									'Chinese Female'                      => __( 'Chinese Female', 'mpv' ),
                                    'Chinese Male'                        => __( 'Chinese Male', 'mpv' ),
									'Hindi Female'                        => __( 'Hindi Female', 'mpv' ),
                                    'Hindi Male'                          => __( 'Hindi Male', 'mpv' ),
                                    'Serbian Female'                      => __( 'Serbian FeMale', 'mpv' ),
									'Serbian Male'                        => __( 'Serbian Male', 'mpv' ),
									'Croatian Female'                     => __( 'Croatian Female', 'mpv' ),
                                    'Croatian Male'                       => __( 'Croatian Male', 'mpv' ),
									'Bosnian Female'                      => __( 'Bosnian Female', 'mpv' ),
                                    'Bosnian Male'                        => __( 'Bosnian Male', 'mpv' ),
									'Romanian Female'                     => __( 'Romanian Female', 'mpv' ),
                                    'Romanian Male'                       => __( 'Romanian Male', 'mpv' ),
									'Catalan Male'                        => __( 'Catalan Male', 'mpv' ),
									'Australian Female'                   => __( 'Australian Female', 'mpv' ),
                                    'Australian Male'                     => __( 'Australian Male', 'mpv' ),
									'Finnish Female'                      => __( 'Finnish Female', 'mpv' ),
                                    'Finnish Male'                        => __( 'Finnish Male', 'mpv' ),
									'Afrikaans Male'                      => __( 'Afrikaans Male', 'mpv' ),
									'Albanian Male'                       => __( 'Albanian Male', 'mpv' ),
									'Arabic Female'                       => __( 'Arabic Female', 'mpv' ),
                                    'Arabic Male'                         => __( 'Arabic Male', 'mpv' ),
									'Armenian Male'                       => __( 'Armenian Male', 'mpv' ),
									'Czech Female'                        => __( 'Czech Female', 'mpv' ),
                                    'Czech Male'                          => __( 'Czech Male', 'mpv' ),
									'Danish Female'                       => __( 'Danish Female', 'mpv' ),
                                    'Danish Male'                         => __( 'Danish Male', 'mpv' ),
									'Esperanto Male'                      => __( 'Esperanto Male', 'mpv' ),
									'Icelandic Male'                      => __( 'Icelandic Male', 'mpv' ),
									'Indonesian Female'                   => __( 'Indonesian Female', 'mpv' ),
                                    'Indonesian Male'                     => __( 'Indonesian Male', 'mpv' ),
									'Latin Female'                        => __( 'Latin Female', 'mpv' ),
                                    'Latin Male'                          => __( 'Latin Male', 'mpv' ),
									'Latvian Male'                        => __( 'Latvian Male', 'mpv' ),
									'Macedonian Male'                     => __( 'Macedonian Male', 'mpv' ),
									'Moldavian Male'                      => __( 'Moldavian Male', 'mpv' ),
									'Montenegrin Male'                    => __( 'Montenegrin Male', 'mpv' ),
									'Polish Female'                       => __( 'Polish Female', 'mpv' ),
                                    'Polish Male'                         => __( 'Polish Male', 'mpv' ),
									'Brazilian Portuguese Female'         => __( 'Brazilian Portuguese Female', 'mpv' ),
                                    'Brazilian Portuguese Male'           => __( 'Brazilian Portuguese Male', 'mpv' ),
									'Portuguese Female'                   => __( 'Portuguese Female', 'mpv' ),
                                    'Portuguese Male'                     => __( 'Portuguese Male', 'mpv' ),
									'Serbo-Croatian Male'                 => __( 'Serbo-Croatian Male', 'mpv' ),
									'Slovak Female'                       => __( 'Slovak Female', 'mpv' ),
									'Spanish Latin American Female'       => __( 'Spanish Latin American Female', 'mpv' ),
                                    'Spanish Latin American Male'         => __( 'Spanish Latin American Male', 'mpv' ),
									'Swahili Male'                        => __( 'Swahili Male', 'mpv' ),
									'Tamil Male'                          => __( 'Tamil Male', 'mpv' ),
									'Thai Female'                         => __( 'Thai Female', 'mpv' ),
									'Vietnamese Female'                   => __( 'Vietnamese Female', 'mpv' ),
                                    'Vietnamese Male'                     => __( 'Vietnamese Male', 'mpv' ),
									'Welsh Male'                          => __( 'Welsh Male', 'mpv' )
								);
								
								foreach( $country_choose as $name_country_key => $name_country ) {
									$choose = ( $selected == $name_country_key) ? 'selected="selected"': '';
									echo '<option '. $choose .' value="'. $name_country_key .'">'. $name_country .'</option>';
								}
							?>
						</select>
					</td>
				</tr>
				
				<tr valign="top">
					<th scope="row">
						<?php _e( 'Add Voice to', 'mpv' ); ?>
					</th>
					<td>
						<?php
							$post_types_default = get_post_types( '', 'objects' );
							unset( $post_types_default['attachment'], $post_types_default['revision'], $post_types_default['nav_menu_item'] );

							foreach ($post_types_default  as $post_type ) {
								if( post_type_supports( $post_type->name, 'thumbnail' ) == 'true' ) {
									$checked= ( isset( $options['choosed_post_type'][$post_type->name ] ) )? 'checked' : '';
									echo '<label>
										<input '. $checked .' name="MPV_plugin_main_settings[choosed_post_type]['. $post_type->name .']" type="checkbox" value="'. $post_type->name .'"> '. $post_type->labels->name .'
									</label><br/>';
								}
							}
						?>
					</td>
				</tr>
				
				
				
				<tr valign="top" class="section_position">
					<th scope="row">
						<label for="hseparator"><?php _e( 'Location', 'mpv' ); ?></label>
					</th>
					<td class="location">
						<label><input value="header" name="MPV_plugin_main_settings[position] " type="radio" <?php echo( !empty( $options['position']) && $options['position'] == 'header' )? 'checked': ''; ?> > <?php _e( 'Header', 'mpv' ); ?></label><br/>
						<label><input value="footer" name="MPV_plugin_main_settings[position] " type="radio" <?php echo( !empty( $options['position']) && $options['position'] == 'footer' )? 'checked': ''; ?>> <?php _e( 'Footer', 'mpv' ); ?></label><br/>
					</td>
				</tr>
                                
                                
                                <tr valign="top" class="section_position">
					<th scope="row">
						<label for="hseparator"><?php _e( 'Pitch', 'mpv' ); ?></label>
					</th>
					<td class="pitch">
						<select name="MPV_plugin_main_settings[pitch]" >
							<?php
								$selected_pitch = $options['pitch'];
								$pitch_array = array( 
                                                                    0, 0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9, 1, 1.1, 1.2, 1.3, 1.4, 1.5, 1.6, 1.7, 1.8, 1.9, 2
                                                                );
								
								foreach( $pitch_array as $pitch ) {
									$choose = ( $selected_pitch == $pitch ) ? 'selected="selected"': '';
									echo '<option '. $choose .' value="'. $pitch .'">'. $pitch .'</option>';
								}
							?>
                                                </select>
					</td>
				</tr>
                                
                                
                                <tr valign="top" class="section_position">
					<th scope="row">
						<label for="hseparator"><?php _e( 'Rate', 'mpv' ); ?></label>
					</th>
					<td class="rate">
						<select name="MPV_plugin_main_settings[rate]" >
							<?php
								$selected_rate = $options['rate'];
								$rate_array = array( 
                                                                    0, 0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9, 1, 1.1, 1.2, 1.3, 1.4, 1.5
                                                                );
								
								foreach( $rate_array as $rate ) {
									$choose = ( $selected_rate == $rate ) ? 'selected="selected"': '';
									echo '<option '. $choose .' value="'. $rate .'">'. $rate .'</option>';
								}
							?>
                                                </select>
					</td>
				</tr>
                                
                                
                                
                                <tr valign="top" class="section_position">
					<th scope="row">
						<label for="hseparator"><?php _e( 'Volume', 'mpv' ); ?></label>
					</th>
					<td class="volume">
						<select name="MPV_plugin_main_settings[volume]" >
							<?php
								$selected_volume = $options['volume'];
								$volume_array = array( 
                                                                    0, 0.1, 0.2, 0.3, 0.4, 0.5, 0.6, 0.7, 0.8, 0.9, 1
                                                                );
								
								foreach( $volume_array as $volume ) {
									$choose = ( $selected_volume == $volume ) ? 'selected="selected"': '';
									echo '<option '. $choose .' value="'. $volume .'">'. $volume .'</option>';
								}
							?>
                                                </select>
					</td>
				</tr>
				
				
			</tbody>
		</table>
		

		<p>Shortcode : <code>[mpv]</code><br/></p>
		
		<?php submit_button(); ?>

	</form>
</div>
<div class="clear"></div>