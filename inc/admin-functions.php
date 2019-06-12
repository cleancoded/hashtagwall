<?php
function HW_register_settings() {
	add_option( 'HW_Twitter_OAT', '');
	add_option( 'HW_Twitter_OATS', '');
	add_option( 'HW_Twitter_CK', '');
	add_option( 'HW_Twitter_CS', '');
	add_option( 'HW_default_hashtag', 'ihatecancer');
	add_option( 'HW_debug_mode', 'false');

	register_setting( 'HW_options_group', 'HW_Twitter_OAT' );
	register_setting( 'HW_options_group', 'HW_Twitter_OATS' );
	register_setting( 'HW_options_group', 'HW_Twitter_CK' );
	register_setting( 'HW_options_group', 'HW_Twitter_CS' );
	register_setting( 'HW_options_group', 'HW_default_hashtag' );
	register_setting( 'HW_options_group', 'HW_debug_mode' );
}
add_action( 'admin_init', 'HW_register_settings' );

function HW_register_options_page() {
	//add_options_page('Hashtag Wall Settings', 'Hashtag Wall', 'manage_options', 'hashtag-wall', 'HW_options_page');
	add_menu_page('Hashtag Wall Settings', 'Hashtag Wall', 'manage_options', 'hashtag-wall', 'HW_options_page');
}
add_action('admin_menu', 'HW_register_options_page');

function HW_options_page(){ ?>
	<style>
		.form-table tr input[type=text]{
			width: 100%;
		}
	</style>
	<div class="wrap">
		<?php screen_icon(); ?>
		<h2>Hashtag Wall Settings</h2>
		<form method="post" action="options.php" novalidate="novalidate">
			<?php settings_fields( 'HW_options_group' ); ?>
			<h3>Please enter Twitter settings below</h3>
			<table  class="form-table">
				<tr valign="top">
					<th scope="row"><label for="HW_Twitter_OAT">Oauth access token</label></th>
					<td><input type="text" id="HW_Twitter_OAT" name="HW_Twitter_OAT" value="<?php echo get_option('HW_Twitter_OAT'); ?>" required/></td>
					<td width="33%"></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="HW_Twitter_OATS">Oauth access token secret</label></th>
					<td><input type="text" id="HW_Twitter_OATS" name="HW_Twitter_OATS" value="<?php echo get_option('HW_Twitter_OATS'); ?>" required/></td>
					<td></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="HW_Twitter_CK">Consumer key</label></th>
					<td><input type="text" id="HW_Twitter_CK" name="HW_Twitter_CK" value="<?php echo get_option('HW_Twitter_CK'); ?>" required/></td>
					<td></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="HW_Twitter_CS">Consumer secret</label></th>
					<td><input type="text" id="HW_Twitter_CS" name="HW_Twitter_CS" value="<?php echo get_option('HW_Twitter_CS'); ?>" required/></td>
					<td></td>
				</tr>
				<tr valign="top">
					<th scope="row"><label for="HW_default_hashtag">Default Hashtag</label></th>
					<td><input type="text" id="HW_default_hashtag" name="HW_default_hashtag" value="<?php echo get_option('HW_default_hashtag'); ?>" required/></td>
					<td></td>
				</tr>
				<?php if (HW_fs()->can_use_premium_code__premium_only()): ?>
					<tr valign="top">
						<th scope="row"><label>Debugging</label></th>
						<td>
							<label for="HW_debug_mode_on">ON</label> <input type="radio" id="HW_debug_mode_on" name="HW_debug_mode" value="true" <?=get_option('HW_debug_mode') == 'true' ? 'checked' : '' ?> required/>
							<label for="HW_debug_mode_off">OFF</label> <input type="radio" id="HW_debug_mode_off" name="HW_debug_mode" value="false" <?=get_option('HW_debug_mode') == 'false' ? 'checked' : '' ?> />
						</td>
						<td></td>
					</tr>
				<?php endif ?>
			</table>
			<?php  submit_button(); ?>
		</form>
	</div>
<?php }