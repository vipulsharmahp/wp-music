<?php

/*
* Creating a function to create our CPT
*/
 
function wp_music_register_music_cpt() {
 
    // Set UI labels for Custom Post Type
        $labels = array(
            'name'                => __( 'Music', 'wp-music' ),
            'singular_name'       => __( 'Music', 'wp-music' ),
            'menu_name'           => __( 'Music', 'wp-music' ),
            'parent_item_colon'   => __( 'Parent Music', 'wp-music' ),
            'all_items'           => __( 'All Music', 'wp-music' ),
            'view_item'           => __( 'View Music', 'wp-music' ),
            'add_new_item'        => __( 'Add New Music', 'wp-music' ),
            'add_new'             => __( 'Add New', 'wp-music' ),
            'edit_item'           => __( 'Edit Music', 'wp-music' ),
            'update_item'         => __( 'Update Music', 'wp-music' ),
            'search_items'        => __( 'Search Music', 'wp-music' ),
            'not_found'           => __( 'Not Found', 'wp-music' ),
            'not_found_in_trash'  => __( 'Not found in Trash', 'wp-music' ),
        );
         
        $args = array(
            'label'               => __( 'Music', 'wp-music' ),
            'description'         => __( 'Music', 'wp-music' ),
            'labels'              => $labels,
            'supports'            => array( 'title', 'editor' ),             
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'show_in_nav_menus'   => true,
            'show_in_admin_bar'   => true,
            'menu_position'       => 5,
            'can_export'          => true,
            'has_archive'         => true,
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'post',
            'menu_icon'           => 'dashicons-format-audio',
            'show_in_rest' => true,
     
        );
         
        // Registering your Custom Post Type
        register_post_type( 'music', $args );


        $genre_labels = array(
            'name'                          => __('Genre', 'wp-music'),
            'singular_name'                 => __('Genre', 'wp-music'),
            'search_items'                  => __('Search Genres', 'wp-music'),
            'popular_items'                 => __('Popular Genres', 'wp-music'),
            'all_items'                     => __('All Genres', 'wp-music'),
            'parent_item'                   => __('Parent Genre', 'wp-music'),
            'edit_item'                     => __('Edit Genre', 'wp-music'),
            'update_item'                   => __('Update Genre', 'wp-music'),
            'add_new_item'                  => __('Add New Genre', 'wp-music'),
            'new_item_name'                 => __('New Genre', 'wp-music'),
            'separate_items_with_commas'    => __('Separate Genres with commas', 'wp-music'),
            'add_or_remove_items'           => __('Add or remove Genres', 'wp-music'),
            'choose_from_most_used'         => __('Choose from most used Genres', 'wp-music')
            );
        
        $genre_args = array(
            'label'                         => __('Genres', 'wp-music'),
            'labels'                        => $genre_labels,
            'public'                        => true,
            'hierarchical'                  => true,
            'show_ui'                       => true,
            'show_in_nav_menus'             => true,
            'args'                          => array( 'orderby' => 'term_order' ),
            'rewrite'                       => array( 'slug' => 'genres' ),
            'query_var'                     => true
        );
        
        register_taxonomy( 'genres', 'music', $genre_args );

        $tag_labels = array(
            'name'                          => __('Music Tag', 'wp-music'),
            'singular_name'                 => __('Music Tag', 'wp-music'),
            'search_items'                  => __('Search Music Tags', 'wp-music'),
            'popular_items'                 => __('Popular Music Tags', 'wp-music'),
            'all_items'                     => __('All Music Tags', 'wp-music'),
            'parent_item'                   => __('Parent Music Tag', 'wp-music'),
            'edit_item'                     => __('Edit Music Tag', 'wp-music'),
            'update_item'                   => __('Update Music Tag', 'wp-music'),
            'add_new_item'                  => __('Add New Music Tag', 'wp-music'),
            'new_item_name'                 => __('New Music Tag', 'wp-music'),
            'separate_items_with_commas'    => __('Separate Music Tags with commas', 'wp-music'),
            'add_or_remove_items'           => __('Add or remove Music Tags', 'wp-music'),
            'choose_from_most_used'         => __('Choose from most used Music Tags', 'wp-music')
            );
        
        $music_args = array(
            'label'                         => __('Music Tags', 'wp-music'),
            'labels'                        => $tag_labels,
            'public'                        => true,
            'hierarchical'                  => false,
            'show_ui'                       => true,
            'show_in_nav_menus'             => true,
            'args'                          => array( 'orderby' => 'term_order' ),
            'rewrite'                       => array( 'slug' => 'music_tags' ),
            'query_var'                     => true
        );
        
        register_taxonomy( 'music_tags', 'music', $music_args );


     
    }
     
    /* Hook into the 'init' action so that the function
    * Containing our post type registration is not 
    * unnecessarily executed. 
    */
     
    add_action( 'init', 'wp_music_register_music_cpt', 0 );


    add_action('admin_menu', 'wp_music_settings_submenu');

    //admin_menu callback function

    function wp_music_settings_submenu(){

        add_submenu_page(
                        'edit.php?post_type=music', //$parent_slug
                        __('Music Settongs', 'wp-music'),  //$page_title
                        __('Music Settings', 'wp-music'),        //$menu_title
                        'manage_options',           //$capability
                        'music_settings',//$menu_slug
                        'wp_music_settings_submenu_callback'//$function
        );

    }

    //add_submenu_page callback function

    function wp_music_settings_submenu_callback() {

        include_once 'music-settings.php';

    }


    function wp_music_get_music_detail_by_id($music_id){

        global $wpdb;

        $table_name = $wpdb->prefix.'music_meta_data';

        $music_query = "select * from $table_name where post_id = $music_id";

        $get_row = $wpdb->get_row($music_query);

        if($get_row){

            return $get_row;

        }else{

            return;

        }

    }


    function wp_music_music_shortcode($attr){

        global $wpdb;
        $table_name = $wpdb->prefix.'music_meta_data';

        $currency = get_option('wp_music_currency');

        $posts_per_page = 10;
        
        $musics_per_page = get_option('wp_music_music_per_page');

        if($musics_per_page)
            $posts_per_page = $musics_per_page;
 
        $args = shortcode_atts( array(         
                'year' => '',
                'genre' => '',     
            ), $attr );

        $year  = $args['year'];
        $genre = $args['genre'];

        $music_args = array('post_type' => 'music', 'posts_per_page' => $posts_per_page);

        if($genre) {

            $music_args['tax_query'] = array(array('taxonomy' => 'genres', 'field' => 'name', 'terms' => $genre));

        }

        if($year) {

            $year_query = "select * from $table_name where recording_year = $year";

            $music_results = $wpdb->get_results($year_query);

            if($music_results){

                $music_ids = array();

                foreach ($music_results as $music){
                    $music_ids[] = $music->post_id;
                }

                $music_args['post__in'] = $music_ids;

            }

        }

        $output = '<div class="music-listing">';

            $music_query = new WP_Query($music_args);

            if($music_query->have_posts()){

                while ($music_query->have_posts()){

                    $music_query->the_post();
                    $music_id = get_the_ID();
                    $music_title = get_the_title();

                    $music_data = wp_music_get_music_detail_by_id($music_id);

                    $output .= '<div class="music-list">';

                        $output .= '<h2>'.__('Title: ', 'wp-music'). $music_title.'</h2>';
                        $output .= '<div class="meta-data">';

                            if($music_data){

                                $output .= '<p>'.__('Composer Name: ', 'wp-music') . $music_data->composer_name.'</p>';
                                $output .= '<p>'.__('Publisher Name: ', 'wp-music'). $music_data->publisher.'</p>';
                                $output .= '<p>'.__('Recording Year: ', 'wp-music'). $music_data->recording_year.'</p>';
                                $output .= '<p>'.__('Additional Contributors: ', 'wp-music'). $music_data->add_contributors.'</p>';
                                $output .= '<p>'.__('URL: ', 'wp-music'). $music_data->url.'</p>';
                                $output .= '<p>'.__('Price: ', 'wp-music'). $currency.' '.$music_data->price.'</p>';

                            }

                        $output .= '</div>';

                    $output .= '</div>';

                }

                wp_reset_query();

            }

        $output .= '</div>';


        return $output;
     
    }
     
    add_shortcode( 'music' , 'wp_music_music_shortcode' );
    