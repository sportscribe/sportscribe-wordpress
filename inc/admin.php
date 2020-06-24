
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

