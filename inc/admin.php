
	<br><br>
        <form  method="post">
		<table>
			<tr>
				<td><input type="text" name="sportscribe_apikey" value="<?php echo get_option( 'sportscribe_apikey' ); ?>"></td>
				<td>API KEY</td>
			</tr>
			<tr>
				<td><input type="text" name="sportscribe_endpoint" value="<?php echo get_option( 'sportscribe_endpoint' ); ?>"></td>
				<td>API ENDPOINT</td>
			</tr>
		</table>
        <?php submit_button('Save') ?>
	</form>

	<br><br>
        <form  method="post">
	<input type="hidden" name="ss_settings" value="1">

		<table>
			<tr>
				<td><input type="text" name="sportscribe_grab_days" value="<?php echo get_option( 'sportscribe_grab_days' ); ?>"></td>
				<td>Number of Days in advance to grab data <i>max is 10</i></td>
			</tr>
			<tr>
				<td><input type="checkbox" name="front_page" <?php if(get_option( 'sportscribe_front_page' )) echo 'checked'; ?>></td>
				<td>Display on Front Page ?</td>
			</tr>
			<tr>
				<td><input type="checkbox" name="use_header_img" <?php if(get_option( 'sportscribe_use_header_img' )) echo 'checked'; ?>></td>
				<td>Use header images in post ?</td>
			</tr>
			<tr>
				<td><select name='sportscribe_language'>
				<option value='ar' <?php if(get_option( 'sportscribe_language') == 'ar') echo 'selected'; ?>>Arabic</option>
				<option value='bg' <?php if(get_option( 'sportscribe_language') == 'bg') echo 'selected'; ?>>Bulgarian</option>
				<option value='zh' <?php if(get_option( 'sportscribe_language') == 'zh') echo 'selected'; ?>>Chinese</option>
				<option value='cs' <?php if(get_option( 'sportscribe_language') == 'cs') echo 'selected'; ?>>Czech</option>
				<option value='da' <?php if(get_option( 'sportscribe_language') == 'da') echo 'selected'; ?>>Danish</option>
				<option value='nl' <?php if(get_option( 'sportscribe_language') == 'nl') echo 'selected'; ?>>Dutch</option>
				<option value='en' <?php if(get_option( 'sportscribe_language', 'en' ) == 'en') echo 'selected'; ?>>English</option>
				<option value='et' <?php if(get_option( 'sportscribe_language') == 'et') echo 'selected'; ?>>Estonian</option>
				<option value='tl' <?php if(get_option( 'sportscribe_language') == 'tl') echo 'selected'; ?>>Filipino / Tagalog</option>
				<option value='fi' <?php if(get_option( 'sportscribe_language') == 'fi') echo 'selected'; ?>>Finnish</option>
				<option value='fr' <?php if(get_option( 'sportscribe_language') == 'fr') echo 'selected'; ?>>French</option>
				<option value='de' <?php if(get_option( 'sportscribe_language') == 'de') echo 'selected'; ?>>German</option>
				<option value='el' <?php if(get_option( 'sportscribe_language') == 'el') echo 'selected'; ?>>Greek</option>
				<option value='he' <?php if(get_option( 'sportscribe_language') == 'he') echo 'selected'; ?>>Hebrew</option>
				<option value='hi' <?php if(get_option( 'sportscribe_language') == 'hi') echo 'selected'; ?>>Hindi</option>
				<option value='hu' <?php if(get_option( 'sportscribe_language') == 'hu') echo 'selected'; ?>>Hungarian</option>
				<option value='it' <?php if(get_option( 'sportscribe_language') == 'it') echo 'selected'; ?>>Italian</option>
				<option value='ja' <?php if(get_option( 'sportscribe_language') == 'ja') echo 'selected'; ?>>Japanese</option>
				<option value='ko' <?php if(get_option( 'sportscribe_language') == 'ko') echo 'selected'; ?>>Korean</option>
				<option value='lv' <?php if(get_option( 'sportscribe_language') == 'lv') echo 'selected'; ?>>Latvian</option>
				<option value='lt' <?php if(get_option( 'sportscribe_language') == 'lt') echo 'selected'; ?>>Lithuanian</option>
				<option value='mt' <?php if(get_option( 'sportscribe_language') == 'mt') echo 'selected'; ?>>Maltese</option>
				<option value='no' <?php if(get_option( 'sportscribe_language') == 'no') echo 'selected'; ?>>Norwegian</option>
				<option value='pl' <?php if(get_option( 'sportscribe_language') == 'pl') echo 'selected'; ?>>Polish</option>
				<option value='pt' <?php if(get_option( 'sportscribe_language') == 'pt') echo 'selected'; ?>>Portuguese</option>
				<option value='ro' <?php if(get_option( 'sportscribe_language') == 'ro') echo 'selected'; ?>>Romanian</option>
				<option value='ru' <?php if(get_option( 'sportscribe_language') == 'ru') echo 'selected'; ?>>Russian</option>
				<option value='sr' <?php if(get_option( 'sportscribe_language') == 'sr') echo 'selected'; ?>>Serbian</option>
				<option value='sk' <?php if(get_option( 'sportscribe_language') == 'sk') echo 'selected'; ?>>Slovak</option>
				<option value='es' <?php if(get_option( 'sportscribe_language') == 'es') echo 'selected'; ?>>Spanish</option>
				<option value='sv' <?php if(get_option( 'sportscribe_language') == 'sv') echo 'selected'; ?>>Swedish</option>
				<option value='tr' <?php if(get_option( 'sportscribe_language') == 'tr') echo 'selected'; ?>>Turkish</option>
				</td>
				<td>Language</td>
			</tr>
			<tr>
				<td><?php wp_dropdown_users( array( 'name' => 'ss_author' ) ); ?></td>
				<td>New posts will authord by this user</td>
			</tr>
		</table>
        <?php submit_button('Update Settings') ?>
	</form>
	<br><br>

        <form  method="post">
	<input type="hidden" name="test_grab" value="1">

		<table>
			<tr>
				<td><input type="text" name="grab_date" value="<?php echo date('Y-m-d',strtotime("+4 day")); ?>"></td>
				<td>Date to Grab</td>
			</tr>
		</table>
        <?php submit_button('Grab Posts') ?>
	</form>

