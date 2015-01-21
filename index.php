<?php
/*
Plugin Name: CC Lexicon Lite
Plugin URI: http://cclexiconlite.ccplugins.co.uk/
Description: Provides a simple way to maintain and organise dictionary/glossary/FAQ type entries. Display is via an easy to use shortcode. 
Author: Caterham Computing
Version: 1.0.1
Author URI: http://www.caterhamcomputing.net/
*/
include_once('includes/cclexiconlite.php');

/* Register custom post types */
add_action('init', 'cclexiconlite::register_post_types');

/* Shortcode */
add_shortcode( 'lexicon', 'cclexiconlite::shortcode' );

/* Queue any CSS and JavaScript */
add_action( 'wp_enqueue_scripts', 'cclexiconlite::enqueue_styles' );

/* Load text domain for translations ... */
add_action( 'plugins_loaded', 'cclexiconlite::load_plugin_textdomain' );

// Add action links for plugin
add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'cclexiconlite::plugin_action_links' );

// Add links to plugin meta
add_filter( 'plugin_row_meta', 'cclexiconlite::plugin_row_meta', 10, 4 );

/* Modify default sort order for Lexicon entries */
add_action( 'pre_get_posts', 'cclexiconlite::admin_sort_order' );

/*EOF*/