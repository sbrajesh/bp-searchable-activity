<?php
/*
 * Plugin Name: BP Searchable Activity
 * Author: Brajesh Singh
 * Version: 1.0.2
 * Author URI: http://buddydev.com/members/sbrajesh
 * Plugin URI: http://buddydev.com/plugins/bp-searchable-activity/
 * License: GPL
 * Last Modified: November 26, 2013
 */
/**
 * My special thanks to @imath<http://imath.owni.fr/> for the javascript code and the code to avoid dependence on bp-default javascript code
 */
/**

 * A class to include all the functionality to allow activity search

 */
class BPDevSearchableActivityHelper {

    private static $instance;

    private function __construct() {

        add_filter( 'bp_search_form_type_select_options', array( $this, 'include_activity_in_seach_option' ) );

        add_filter( 'bp_core_search_site', array( $this, 'search_activity_url' ), 10, 2 );

        add_filter( 'bp_dtheme_ajax_querystring', array( $this, 'add_activity_search_to_query' ), 10, 7 );
        
        //include javascript
        add_action( 'wp_print_scripts', array( $this, 'include_js' ) );
    }

    public static function get_instance() {

        if ( ! isset( self::$instance ) )
            self::$instance = new self();

        return self::$instance;
    }

    /* Inject Activity in the Search drop down */

    function include_activity_in_seach_option( $options ) {

        if ( bp_is_active( 'activity' ) )
            $options['activity'] = __( 'Activity' );

        return $options;
    }
    //where to redirect on activity search, obviously activity directory
    function search_activity_url( $url, $search_terms ) {

        $search_which = $_POST['search-which']; //what is being searched?

        if ( $search_which != 'activity' )//is it activity? if not, let us return
            return $url;

        $slug = bp_get_activity_root_slug();

        $url = home_url( $slug . '/?s=' . urlencode( $search_terms ) );

        return $url;
    }
    //filter on query string and append search term
    function add_activity_search_to_query( $qs, $object, $object_filter, $object_scope, $object_page, $object_search_terms, $object_extras ) {

        if ( $object != 'activity' )
            return $qs;
        //thanks to @imath <http://imath.owni.fr/> for the below code, it avoids the dependence on modifying bp-default javascript file
        $_BP_COOKIE = &$_COOKIE;
        
        if ( isset( $_BP_COOKIE['bp-activity-search-terms'] ) && !empty( $_BP_COOKIE['bp-activity-search-terms'] ) ) {

            if ( empty( $qs ) )
                $qs = "search_terms=" . $_BP_COOKIE['bp-activity-search-terms'];

            else
                $qs .= "&search_terms=" . $_BP_COOKIE['bp-activity-search-terms'];
        }
        return $qs;
    }
    
    //include javascript file

    function include_js() {
        //if(bp_is_activity_component()&&!bp_is_user())
            wp_enqueue_script( 'activity-search', plugin_dir_url( __FILE__ ) . 'searchable.js' );
    }

}

//Instantiate the singleton helper object
BPDevSearchableActivityHelper::get_instance();
