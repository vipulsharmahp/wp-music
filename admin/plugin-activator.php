<?php
class wp_music_plugin_activator {

    public function activate_plugin(){

        global $wpdb;

        $table_name = $wpdb->prefix.'music_meta_data';

        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE IF NOT EXISTS $table_name (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `post_id` bigint(20) NOT NULL,
            `composer_name` varchar(100) NOT NULL,
            `publisher` varchar(100) NOT NULL,
            `recording_year` year(4) NOT NULL,
            `add_contributors` text NOT NULL,
            `url` varchar(100) NOT NULL,
            `price` varchar(10) NOT NULL,
            PRIMARY KEY (`id`)
          ) $charset_collate;";
          
          require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
          dbDelta( $sql );

    }

}