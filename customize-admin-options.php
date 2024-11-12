<?php

if ( ! defined ( 'ABSPATH' ) ) {
	die ( 'Error!' );
}

// Create custom plugin settings menu and register the settings
function ca_create_menu () {
	add_submenu_page ( 'options-general.php', 'Customize Admin', 'Customize Admin', 'manage_options', 'customize-admin/customize-admin-options.php', 'ca_settings_page' );
	add_action ( 'admin_init', 'ca_register_settings' );
}
add_action ( 'admin_menu', 'ca_create_menu' );

// Register the settings
function ca_register_settings () {
	register_setting ( 'customize-admin-settings-group', 'ca_logo_file', 'esc_url_raw' );
	register_setting ( 'customize-admin-settings-group', 'ca_logo_url', 'esc_url_raw' );
	register_setting ( 'customize-admin-settings-group', 'ca_login_background_color', 'ca_sanitize_hex_color' );
	register_setting ( 'customize-admin-settings-group', 'ca_custom_css', 'ca_sanitisation_css' );
	register_setting ( 'customize-admin-settings-group', 'ca_remove_meta_generator', 'ca_sanitisation' );
	register_setting ( 'customize-admin-settings-group', 'ca_remove_meta_rsd', 'ca_sanitisation' );
	register_setting ( 'customize-admin-settings-group', 'ca_remove_meta_wlw', 'ca_sanitisation' );
	register_setting ( 'customize-admin-settings-group', 'ca_remove_rss_links', 'ca_sanitisation' );
	register_setting ( 'customize-admin-settings-group', 'ca_remove_dashboard_site_health_status', 'ca_sanitisation' );
	register_setting ( 'customize-admin-settings-group', 'ca_remove_dashboard_at_a_glance', 'ca_sanitisation' );
	register_setting ( 'customize-admin-settings-group', 'ca_remove_dashboard_activity', 'ca_sanitisation' );
	register_setting ( 'customize-admin-settings-group', 'ca_remove_dashboard_quick_press', 'ca_sanitisation' );
	register_setting ( 'customize-admin-settings-group', 'ca_remove_dashboard_wordpress_news', 'ca_sanitisation' );
}

function ca_sanitisation ( $input ) {
	$input = sanitize_text_field ( $input );
	return $input;
}

function ca_sanitisation_css ( $input ) {
	$ca_sanitisation_allowed_html = array ();
	$input = wp_kses ( $input, $ca_sanitisation_allowed_html );
	return $input;
}

function ca_sanitize_hex_color ( $color ) {
	if ( '' === $color )
		return '';

	// 3 or 6 hex digits, or the empty string.
	if ( preg_match('|^#([A-Fa-f0-9]{3}){1,2}$|', $color ) )
		return $color;

	return null;
}

function ca_settings_page () { ?>
	<div class="wrap">
		<h2><?php esc_attr_e ( 'Customize Admin Options', 'customize-admin' ); ?></h2>
		<form method="post" action="options.php">
			<?php settings_fields ( 'customize-admin-settings-group' ); ?>
			<table class="form-table">
				<tr valign="top">
					<th scope="row"><?php esc_attr_e ( 'Login Page Logo Link', 'customize-admin' ); ?></th>
					<td>
						<label for="ca_logo_url">
							<input type="text" id="ca_logo_url" name="ca_logo_url" value="<?php echo esc_url ( get_option ( 'ca_logo_url' ) ); ?>" />
							<p class="description"><?php esc_attr_e ( 'If not specified, clicking on the logo will return you to the homepage.', 'customize-admin' ); ?></p>
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php esc_attr_e ( 'Login Page Logo Image', 'customize-admin' ); ?></th>
					<td>
						<label for="upload_image">
							<input id="upload_image" type="text" size="36" name="ca_logo_file" value="<?php echo esc_url ( get_option ( 'ca_logo_file' ) ); ?>" />
							<input id="upload_image_button" type="button" value="<?php esc_attr_e ( 'Choose Image', 'customize-admin' ); ?>" class="button" />
							<p class="description"><?php esc_attr_e ( 'Enter a URL or upload logo image. Maximum height: 70px, width: 310px.', 'customize-admin' ); ?></p>
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php esc_attr_e ( 'Login Page Background Color', 'customize-admin' ); ?></th>
					<td>
						<label for="ca_login_background_color">
							<input type="text" id="ca_login_background_color" class="color-picker" name="ca_login_background_color" value="<?php echo esc_html( get_option ( 'ca_login_background_color' ) ); ?>" />
							<p class="description"></p>
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php esc_attr_e ( 'Login Page CSS', 'customize-admin' ); ?></th>
					<td>
						<textarea id="ca_custom_css" name="ca_custom_css" cols="70" rows="5"><?php echo esc_html( get_option ( 'ca_custom_css' ) ); ?></textarea>
						<p class="description"><?php esc_attr_e ( 'Add your own styles to the WordPress Login Page.', 'customize-admin' ); ?></p>
					</td>
				</tr>
				<tr valign="top">
					<th><?php esc_attr_e ( 'Remove metatags from the &lt;head&gt; section', 'customize-admin' ); ?></th>
					<td>
						<label for="ca_remove_meta_generator">
							<input id="ca_remove_meta_generator" type="checkbox" name="ca_remove_meta_generator" value="1" <?php checked ( '1', get_option ( 'ca_remove_meta_generator' ) ); ?> />
							<?php esc_attr_e ( 'Remove Generator Meta Tag', 'customize-admin' ); ?>
							<p class="description"><?php esc_attr_e ( 'Selecting this option removes the generator meta tag from the html source.', 'customize-admin' ); ?></p>
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th></th>
					<td>
						<label for="ca_remove_meta_rsd">
							<input id="ca_remove_meta_rsd" type="checkbox" name="ca_remove_meta_rsd" value="1" <?php checked ( '1', get_option ( 'ca_remove_meta_rsd' ) ); ?> />
							<?php esc_attr_e ( 'Remove RSD Meta Tag', 'customize-admin' ); ?>
							<p class="description"><?php esc_attr_e ( 'Selecting this option removes the RSD meta tag from the html source.', 'customize-admin' ); ?></p>
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th></th>
					<td>
						<label for="ca_remove_meta_wlw">
							<input id="ca_remove_meta_wlw" type="checkbox" name="ca_remove_meta_wlw" value="1" <?php checked ( '1', get_option ( 'ca_remove_meta_wlw' ) ); ?> />
							<?php esc_attr_e ( 'Remove WLW Meta Tag', 'customize-admin' ); ?>
							<p class="description"><?php esc_attr_e ( 'Selecting this option removes the WLW meta tag from the html source. It seems that this tag is no longer included in WP 6.3?', 'customize-admin' ); ?></p>
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th></th>
					<td>
						<label for="ca_remove_rss_links">
							<input id="ca_remove_rss_links" type="checkbox" name="ca_remove_rss_links" value="1" <?php checked ( '1', get_option ( 'ca_remove_rss_links' ) ); ?> />
							<?php esc_attr_e ( 'Remove RSS feed links', 'customize-admin' ); ?>
							<p class="description"><?php esc_attr_e ( 'Selecting this option removes the RSS feed link from the html source.', 'customize-admin' ); ?></p>
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"><?php esc_attr_e ( 'Remove Dashboard Widgets', 'customize-admin' ); ?></th>
					<td>
						<label for="ca_remove_dashboard_site_health_status">
							<input id="ca_remove_dashboard_site_health_status" type="checkbox" name="ca_remove_dashboard_site_health_status" value="1" <?php checked ( '1', get_option ( 'ca_remove_dashboard_site_health_status' ) ); ?> /> <?php esc_attr_e ( 'Site Health Status' ); ?>
							<p class="description"><?php esc_attr_e ( 'Selecting this option removes the WordPress Site Health Status dashboard widget.', 'customize-admin' ); ?></p>
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"></th>
					<td>
						<label for="ca_remove_dashboard_at_a_glance">
							<input id="ca_remove_dashboard_at_a_glance" type="checkbox" name="ca_remove_dashboard_at_a_glance" value="1" <?php checked ( '1', get_option ( 'ca_remove_dashboard_at_a_glance' ) ); ?> /> <?php esc_attr_e ( 'At a Glance' ); ?>
							<p class="description"><?php esc_attr_e ( 'Selecting this option removes the At a Glance dashboard widget.', 'customize-admin' ); ?></p>
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"></th>
					<td>
						<label for="ca_remove_dashboard_activity">
							<input id="ca_remove_dashboard_activity" type="checkbox" name="ca_remove_dashboard_activity" value="1" <?php checked ( '1', get_option ( 'ca_remove_dashboard_activity' ) ); ?> /> <?php esc_attr_e ( 'Activity' ); ?>
							<p class="description"><?php esc_attr_e ( 'Selecting this option removes the Activity dashboard widget.', 'customize-admin' ); ?></p>
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"></th>
					<td>
						<label for="ca_remove_dashboard_quick_press">
							<input id="ca_remove_dashboard_quick_press" type="checkbox" name="ca_remove_dashboard_quick_press" value="1" <?php checked ( '1', get_option ( 'ca_remove_dashboard_quick_press' ) ); ?> /> <?php esc_attr_e ( 'Quick Draft' ); ?>
							<p class="description"><?php esc_attr_e ( 'Selecting this option removes the Quick Draft dashboard widget.', 'customize-admin' ); ?></p>
						</label>
					</td>
				</tr>
				<tr valign="top">
					<th scope="row"></th>
					<td>
						<label for="ca_remove_dashboard_wordpress_news">
							<input id="ca_remove_dashboard_wordpress_news" type="checkbox" name="ca_remove_dashboard_wordpress_news" value="1" <?php checked ( '1', get_option ( 'ca_remove_dashboard_wordpress_news' ) ); ?> /> <?php esc_attr_e ( 'WordPress Events and News' ); ?>
							<p class="description"><?php esc_attr_e ( 'Selecting this option removes the WordPress Events and News dashboard widget.', 'customize-admin' ); ?></p>
						</label>
					</td>
				</tr>
			</table>
			<p class="submit">
				<input type="submit" class="button-primary" value="<?php esc_attr_e ( 'Save Changes', 'customize-admin' ); ?>" />
			</p>
		</form>
	</div>

<?php };