<?php
/**
 * Plugin Name: SportScribe API <> Wordpress 
 * Plugin URI: https://github.com/sportscribe/sportscribe-wordpress
 * Description: Automatically post SportScribe articles to your Wordpress site.
 * Version: 0.1.3
 * Author: SportScribe
 * Author URI: https://sportscribe.co/
 */

global $sportscribe_db_version;
$sportscribe_db_version = '1.0';

register_activation_hook( __FILE__, 'sportscribe_install' );
register_deactivation_hook( __FILE__, 'sportscribe_uninstall' );
require_once(dirname(__FILE__).'/inc/admin.submit.php');


// Upon deactivation
function sportscribe_uninstall() {

  // Remove the cron hook
  $timestamp = wp_next_scheduled( 'sportscribe_cron_hook' );
  wp_unschedule_event( $timestamp, 'sportscribe_cron_hook', $array() );

}

function sportscribe_install() {

  global $wpdb;
  global $sportscribe_db_version;
  $table_name = $wpdb->prefix . 'sportscribe';

  $charset_collate = $wpdb->get_charset_collate();

  $sql = "CREATE TABLE IF NOT EXISTS $table_name ( fixture_id mediumint unsigned not null primary key, postId mediumint unsigned, data json not null ) $charset_collate;";

  require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
  dbDelta( $sql );

  add_option( 'sportscribe_db_version', $sportscribe_db_version );

  // Set grab_days to default 3
  update_option('sportscribe_grab_days', 3 );
  update_option('sportscribe_endpoint', 'https://api.sportscribe.co/v1_0/');
}

add_action('admin_menu', 'sportscribe_plugin_setup_menu');

function sportscribe_plugin_setup_menu(){
      add_menu_page( 'SportScribe Plugin Page', 'SportScribe Plugin', 'manage_options', 'sportscribe-plugin', 'sportscribe_init' );
}

add_action( 'init', 'create_posttype');
add_action( 'init', 'create_post_tax' );
 

function create_post_tax() {

	// Register Country Taxonomy
	$labels = array(
		'name'		=> __('Country')
		);

	$args = array(
		'hierarchical'  => false,
		'rewrite'	=> false,
		'publicly_queryable'	=> true,
		'show_in_menu'	=> false,

		'labels'	=> $labels
		);

	register_taxonomy( 'country', array( 'preview' ) , $args );

	// Register League Taxonomy
	$labels = array(
		'name'		=> __('League')
		);

	$args = array(
		'hierarchical'  => false,
		'publicly_queryable'	=> true,
		'rewrite'	=> false,
		'show_in_menu'	=> false,
		'labels'	=> $labels
		);

	register_taxonomy( 'league', array( 'preview' ), $args );

}

// Fetch content on a sepcific date ( YYYY-MM-DD )
function sportscribe_fetch($date) {

          // Check date is ok
          list($y,$m,$d) = explode('-',$date);
          if(!checkdate($m,$d,$y))
            return;


  	  $res = ss_api_get('/matchPreview/date/' . $date);
 	  if( ! is_wp_error($res) ) {

	    $j = json_decode( wp_remote_retrieve_body( $res ), true );

	    // Insert all the previews
	    foreach($j as $preview) {
              echo "<p>Spidered Preview " . $preview['fixture_id'] . "</p>";

	      ss_insert_preview($preview,$postId = 0);
	    }

	    ss_post_previews();

	  }


}


// Setup the admin page
function sportscribe_init(){

	sportscribe_doSubmit();
        require_once(dirname(__FILE__).'/inc/admin.php');

}



// Create the custom post type
function create_posttype() {

  register_post_type( 'preview', array	(
					 'labels' => array(
					 'name' => __( 'Match Previews' ),
					 'singular_name' => __( 'Match Preview' )
				 ),
				 'public' => true,
				 'has_archive' => true,
				 'rewrite' => array('slug' => 'match-previews', 'with-front' => false )
		    )
  );

}




// Change the single view template
// TODO
function ss_single_template() {
/*
    global $post;
    if(get_post_type($post) == 'preview' && ( is_single() || is_preview() )) {
//      include( dirname( __FILE__ ) . '/preview-template.php');
    }
*/
}

// add_action('template_redirect','ss_single_template');


// Run an API request
function ss_api_get($path) {

  $apikey = get_option( 'sportscribe_apikey' );
  $endpoint = get_option( 'sportscribe_endpoint' );

  $url = $endpoint . $path;

  return wp_remote_get( $url , array('headers' => array ( 'x-api-key' => $apikey ), 'timeout' => 25 ) );

}


// Run a test API request to the /leagues endpoint to test the API key
function ss_test_api($key,$endpoint) {

  $url = $endpoint . "/leagues";
  $response = wp_remote_get( $url , array('headers' => array ( 'x-api-key' => $key ) ) );
  if( wp_remote_retrieve_response_code($response) == 200 ) {
    return true;
  } else {
    return false;
  }
}

// Insert the preview into the database
function ss_insert_preview($preview) {


  global $wpdb;
  $table_name = $wpdb->prefix . 'sportscribe';
  $wpdb->hide_errors();
  $wpdb->insert( $table_name, array(	'fixture_id' => $preview['fixture_id'],
					'data' => json_encode($preview) )  );
  $wpdb->show_errors();

}


// Post articles from the sportscribe database
function ss_post_previews() {

  global $wpdb;

  // Check which fixtures we have not posted already
  $table_name = $wpdb->prefix . 'sportscribe';
  $res = $wpdb->get_results("SELECT fixture_id,data FROM $table_name WHERE postId is null");

  foreach($res as $r) {

    // The json object
    $j = json_decode($r->data);

    $fixture_id = $r->fixture_id;

    $content = '';

    if(sizeof($j->blurb_split) > 1) {

      foreach($j->blurb_split as $c) {
        $content .= "<p>$c</p>";
      }

    } else {

      $content = $j->blurb_full; 

    }

    $post_arr = array(
      'post_title'   => $j->hometeam_name . " vs " . $j->visitorteam_name . " Match Preview",
      'post_type'    => 'preview',
//      'post_content' => '[ss_header_img]' . "\n<br>\n" . $j->blurb_full,
      'post_content' => '[ss_header_img]' . "\n<br>\n" . $content,
      'post_status'  => 'publish',
      'post_author'  => get_option( 'sportscribe_author_id' , get_current_user_id() ),
      'meta_input'   => array(
	  'ss_meta_league_id'		=> $j->league_id,
	  'ss_meta_league_name'		=> $j->league,
          'ss_meta_hometeam_name' 	=> $j->hometeam_name,
	  'ss_meta_hometeam_id'		=> $j->hometeam_id,
	  'ss_meta_visitorteam_name'	=> $j->visitorteam_name,
	  'ss_meta_visitorteam_id'	=> $j->visitorteam_id,
	  'ss_meta_formation_img'	=> $j->formation_img,
          'ss_meta_fixture_img'		=> $j->fixture_img,
	  'ss_meta_quick_items'		=> $j->quick_items,
	  'ss_meta_stadium_city'	=> $j->venue_city,
	  'ss_meta_stadium_name'	=> $j->venue_name,
	  'ss_meta_fixture_date'	=> $j->date,
	  'ss_meta_match_img'		=> $j->match_img,
	  'ss_meta_match_img_txt'	=> $j->match_img_txt,
	  'ss_meta_headline'		=> $j->headline
       ),
      'tax_input'    => array(
  	'league' => $j->league,
	'country' => $j->country
       )
    );

    // Insert the post
    $postId = wp_insert_post( $post_arr , false);
    echo "<p>Inserted PostId $postId</p>";

    // If the post was inserted, update the sportscribe database with the post's ID
    if (!is_wp_error($postId)) {
      $wpdb->update( $table_name, array( 'postId' => $postId ), array( 'fixture_id' => $fixture_id ) );
    }

  }

}


// Put the previews on the homepage
function custom_posts_in_home_loop( $query ) {
  if ( $query->is_home() && $query->is_main_query() )
  $query->set( 'post_type', array( 'post', 'preview') );
  return $query;
}

// Order the posts by fixture date on the homepage
function order_posts_by_fixture_date( $query ) {

   if ( $query->is_home() && $query->is_main_query() ) {
     $query->set( 'orderby', 'meta_value' );
     $query->set( 'order', 'ASC' );
     $query->set( 'meta_key', 'ss_meta_fixture_date' );

   }

}

// If the option is set, display previews on homepage
if(get_option( 'sportscribe_front_page' )) {

  add_filter( 'pre_get_posts', 'custom_posts_in_home_loop' );
  add_action( 'pre_get_posts', 'order_posts_by_fixture_date' );

}


// Pull the API n days in advance
// where n = get_option('sportscribe_grab_days')
function sportscribe_do_cron_hook() {

  for($i=0;$i<= get_option( 'sportscribe_grab_days' ) ;$i++) {

    $t = mktime(0,0,0,date('m'),date('d')+$i, date('Y'));

    $date = date('Y-m-d',$t);
    sportscribe_fetch($date);

  }

}

// Setup the hook to pull data automatically
add_action( 'sportscribe_cron_hook', 'sportscribe_do_cron_hook' );
if ( ! wp_next_scheduled( 'sportscribe_cron_hook' ) ) {
    wp_schedule_event( strtotime('00:00:00') + random_int(0,3600) , 'daily', 'sportscribe_cron_hook' );
}

flush_rewrite_rules( false );


require_once(dirname(__FILE__).'/custom_code.php');
require_once(dirname(__FILE__).'/custom_shortcode.php');

?>
