<?php
function wp_music_meta_box() {
    add_meta_box(
        'wp_music_feilds',       // $id
        __('Music Details', 'wp-music'),                  // $title
        'wp_music_meta_box_callback',  // $callback
        'music',                 // $page
        'normal',                  // $context
        'high'                     // $priority
    );
 }
 add_action('add_meta_boxes', 'wp_music_meta_box');


 function wp_music_meta_box_callback($post) {
    
    global $wpdb;
    $music_id = $post->ID;

    $table_name = $wpdb->prefix.'music_meta_data';

    $wp_music_composer_name = '';
    $wp_music_publisher = '';
    $wp_music_recording_year = '';
    $wp_music_add_contributors = '';
    $wp_music_url = '';
    $wp_music_price = '';

    $music_query = "select * from $table_name where post_id = $music_id";

    $get_row = $wpdb->get_row($music_query);

    if($get_row){

        $wp_music_composer_name = $get_row->composer_name;
        $wp_music_publisher = $get_row->publisher;
        $wp_music_recording_year = $get_row->recording_year;
        $wp_music_add_contributors = $get_row->add_contributors;
        $wp_music_url = $get_row->url;
        $wp_music_price = $get_row->price;

    }

    ?>
    <table class="form-table">
		<tr>
			<th><label for="wp_music_composer_name"><?php _e('Composer Name', 'wp-music') ?></label></th>
			<td><input type="text" name="wp_music_composer_name" id="wp_music_composer_name" class="regular-text" value="<?php echo $wp_music_composer_name; ?>"></td>
		</tr>

        <tr>
			<th><label for="wp_music_publisher"><?php _e('Publisher', 'wp-music') ?></label></th>
			<td><input type="text" name="wp_music_publisher" id="wp_music_publisher" class="regular-text" value="<?php echo $wp_music_publisher; ?>"></td>
		</tr>

        <tr>
			<th><label for="wp_music_recording_year"><?php _e('Year of Recording', 'wp-music') ?></label></th>
			<td><input type="number" name="wp_music_recording_year" id="wp_music_recording_year" class="regular-text" value="<?php echo $wp_music_recording_year; ?>"></td>
		</tr>

        <tr>
			<th><label for="wp_music_add_contributors"><?php _e('Additional Contributors', 'wp-music') ?></label></th>
			<td><input type="text" name="wp_music_add_contributors" id="wp_music_add_contributors" class="regular-text" value="<?php echo $wp_music_add_contributors; ?>"></td>
		</tr>

        <tr>
			<th><label for="wp_music_url"><?php _e('URL', 'wp-music') ?></label></th>
			<td><input type="text" name="wp_music_url" id="wp_music_url" class="regular-text" value="<?php echo $wp_music_url; ?>"></td>
		</tr>

        <tr>
			<th><label for="wp_music_price"><?php _e('Price', 'wp-music') ?></label></th>
			<td><input type="text" name="wp_music_price" id="wp_music_price" class="regular-text" value="<?php echo $wp_music_price; ?>"></td>
		</tr>
		
    </table>
    <?php  

}


add_action('save_post', 'wp_music_save_meta_data');

function wp_music_save_meta_data( $post_id ){

    global $wpdb;

    $table_name = $wpdb->prefix.'music_meta_data';

    $post_type = get_post_type( $post_id );


    if($post_type == 'music') {

        $wp_music_composer_name = $_POST['wp_music_composer_name'];
        $wp_music_publisher = $_POST['wp_music_publisher'];
        $wp_music_recording_year = $_POST['wp_music_recording_year'];
        $wp_music_add_contributors = $_POST['wp_music_add_contributors'];
        $wp_music_url = $_POST['wp_music_url'];
        $wp_music_price = $_POST['wp_music_price'];

        $music_query = "select * from $table_name where post_id = $post_id";

        $get_row = $wpdb->get_row($music_query);

        if($get_row){

            $meta_data = array('composer_name' => $wp_music_composer_name, 'publisher' => $wp_music_publisher, 'recording_year' => $wp_music_recording_year, 'add_contributors' => $wp_music_add_contributors, 'url' => $wp_music_url, 'price' => $wp_music_price);

            $where = ['post_id' => $post_id];

            $wpdb->update($table_name, $meta_data, $where);

        }else{

            $meta_data = array('post_id' => $post_id, 'composer_name' => $wp_music_composer_name, 'publisher' => $wp_music_publisher, 'recording_year' => $wp_music_recording_year, 'add_contributors' => $wp_music_add_contributors, 'url' => $wp_music_url, 'price' => $wp_music_price);

            $wpdb->insert($table_name, $meta_data);

        }

    }

}