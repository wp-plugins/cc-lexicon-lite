<?php
/**
* cclexiconlite
*
*/

class cclexiconlite {

	// Used to uniquely identify this plugin's menu page in the WP manager
	const admin_menu_slug = 'cclexiconlite';
	
	// Plugin name
	const plugin_name = 'CC Lexicon Lite';

	// Plugin version
	const plugin_version = '1.0.1';

	// ID Count
	protected static $cc_id_counter;
	
	// Initialise class
	public static function init($value=0) { self::$cc_id_counter = $value; }
	
	// Get unique ID
	public static function get_unique_id() {
		self::$cc_id_counter++;
		return self::$cc_id_counter;
	}


	public static function load_plugin_textdomain() {
		load_plugin_textdomain( 'cc-lexicon-lite', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
	}
	
	public static function register_post_types() {
		
		// Register Lexicon post type
		$cc_labels = array(
			'name'					=> __( 'Lexicon Entries', 'cc-lexicon-lite' ),
			'singular_name'			=> __( 'Lexicon Entry', 'cc-lexicon-lite' ),
			'add_new'				=> __( 'Add New Lexicon Entry', 'cc-lexicon-lite' ),
			'add_new_item'			=> __( 'Add New Lexicon Entry', 'cc-lexicon-lite' ),
			'edit'					=> __( 'Edit', 'cc-lexicon-lite' ),
			'edit_item'				=> __( 'Edit Lexicon Entry', 'cc-lexicon-lite' ),
			'new_item'				=> __( 'New Lexicon Entry', 'cc-lexicon-lite' ),
			'view'					=> __( 'View Lexicon Entry', 'cc-lexicon-lite' ),
			'view_item'				=> __( 'View Lexicon Entry', 'cc-lexicon-lite' ),
			'search_items'			=> __( 'Search Lexicon Entries', 'cc-lexicon-lite' ),
			'not_found'				=> __( 'No Lexicon Entries', 'cc-lexicon-lite' ),
			'not_found_in_trash'	=> __( 'No Lexicon Entries in the Trash', 'cc-lexicon-lite' )
		);
		
		$cc_args = array(
			'labels' => apply_filters( 'cclexicon_post_type_labels', $cc_labels ),
			'hierarchical' => false,
			'public' => false,
			'show_ui' => true,
			'show_in_menu' => true,
			'menu_position' => 25,
			'menu_icon' => 'dashicons-book-alt',
			'has_archive' => 'lexicons',
			'rewrite' => array( 'slug' => 'lexicons' ),
			'supports' => array( 'title', 'editor', 'revisions' ),
			'description' => __( 'Description and details of a Lexicon Entry', 'cc-lexicon-lite' )
		);
			
		register_post_type(
			'lexicon',
			apply_filters( 'cclexicon_post_type_args', $cc_args )
		);
	
		// Register Lexicon Category taxonomy
		$cc_labels = array(
			'singular_name'		=> __( 'Lexicon Category', 'cc-lexicon-lite' ),
			'search_items'		=> __( 'Search Lexicon Categories', 'cc-lexicon-lite' ),
			'popular_items'		=> __( 'Popular Lexicon Categories', 'cc-lexicon-lite' ),
			'all_items'			=> __( 'All Lexicon Categories', 'cc-lexicon-lite' ),
			'parent_item'		=> __( 'Parent Lexicon Category', 'cc-lexicon-lite' ),
			'parent_item_colon' => __( 'Parent Lexicon Category:', 'cc-lexicon-lite' ),
			'edit_item' 		=> __( 'Edit Lexicon Category', 'cc-lexicon-lite' ),
			'update_item' 		=> __( 'Update Lexicon Category', 'cc-lexicon-lite' ),
			'add_new_item' 		=> __( 'Add New Lexicon Category', 'cc-lexicon-lite' ),
			'new_item_name' 	=> __( 'New Lexicon Category', 'cc-lexicon-lite' ),
			'menu_name' 		=> __( 'Lexicon Category', 'cc-lexicon-lite' )
		);
		
		$cc_args = array(
			'label' => __( 'Lexicon Categories', 'cc-lexicon-lite' ),
			'labels' => apply_filters( 'cclexicon_taxonomy_labels', $cc_labels ),
			'hierarchical' => true,
			'public' => false,
			'show_ui' => true
		);
		
		register_taxonomy( 'lexicon_category',
			'lexicon',
			apply_filters( 'cclexicon_taxonomy_args', $cc_args )
		);
	}

	public static function shortcode( $atts ) {
		$cc_defaults = array(
			'before_heading'	=> '<h4>',
			'after_heading'		=> '</h4>',
			'before_title'		=> '<h5>',
			'after_title'		=> '</h5>',
			'class'				=> '',
			'skin'				=> 'simple',
			'category'			=> NULL,
			'before_instructions'		=> '<h5>',
			'after_instructions'		=> '</h5>',
			'instructions'		=> __( 'Click on any term below to reveal the description.', 'cc-lexicon-lite' )
		);
		
		$a = shortcode_atts( apply_filters( 'cclexicon_defaults', $cc_defaults ) , $atts );
		
		$query = array(
			'post_type'			=> 'lexicon',
			'orderby'			=> 'title',
			'order'				=> 'ASC',
			'nopaging'			=> 'true'
		);
		
		$tax_query = NULL;
		
		$before_title = html_entity_decode($a['before_title']);
		$after_title = html_entity_decode($a['after_title']);
		$before_heading = html_entity_decode($a['before_heading']);
		$after_heading = html_entity_decode($a['after_heading']);
		$before_instructions = html_entity_decode($a['before_instructions']);
		$after_instructions = html_entity_decode($a['after_instructions']);
		
		$instructions = $a['instructions'];
		
		if ( $a['category'] != NULL ){
			$tax_query = array (
				array(
					'taxonomy'	=> 'lexicon_category',
					'field'		=> 'slug',
					'terms'		=> explode(',',trim($a['category']))
				)
			);
		}
		
		if ( is_array($tax_query) ) {
			$query['tax_query'] = $tax_query;
		}
		
		$return_html = '';
		$class = $a['class'];
		
		switch ( $a['skin'] ) {
			case 'red':
				$skin = 'ccred';
				break;
			case 'green':
				$skin = 'ccgreen';
				break;
			case 'blue':
				$skin = 'ccblue';
				break;
			default:
				$skin = 'simple';
		}
		
		// The Query
		$the_query = new WP_Query( apply_filters( 'cclexicon_query', $query ) );
		
		$post_count = 0;

		// The Loop
		if ( $the_query->have_posts() ) {
			
			// if class is specified, substitue value for skin class
			if ( $a['class'] != '' ) $skin = trim(esc_html($a['class']));
			
			// get unique ID for this lexicon
			$unique_id = self::get_unique_id();
			
			$return_html .= '<div id="cclexicon-' . $unique_id . '" class="cclexicon ' . $class .' ccclearfix">';

			$return_html .= apply_filters( 'cclexicon_instructions', $before_instructions . $instructions . $after_instructions );
			
			$lexicon_index = '';
			
			$lexicon_index_list = '<div id="cclexicon-filters-' . $unique_id . '" class="cclexicon-filters">' . __( 'Filter', 'cc-lexicon-lite' ) . ': <span id="cclexicon-filter-' . $unique_id . '-all" class="cclexicon-filter">' . __( 'Show All', 'cc-lexicon-lite' ) . '</span>';
			
			while ( $the_query->have_posts() ) {
				$the_query->the_post();
				
				$post_count++;

				$id = get_the_ID();
				
				$post_class = '';
								
				if ( $post_count%2 == 0  ) {
					$post_class .= ' cceven';
				}
				else {
					$post_class .= ' ccodd';
				}
				
				$post_class .= ' cclexicon-count-' . $post_count;
				$post_class .= ' cclexicon-id-' . $id;
				$post_class .= ' cclexicon-' . self::the_slug($id);
				
				$new_index = strtoupper( substr( html_entity_decode(get_the_title()),0,1) );
				
				if ( $new_index != $lexicon_index && preg_match('/[a-z0-9]/i', $new_index) ) {
					$lexicon_index_list .= ' <span id="cclexicon-filter-' . $unique_id . '-' . $new_index . '" class="cclexicon-filter"><a href="#cclexicon-anchor-' . $unique_id . '-' . $new_index. '">' . $new_index . '</a></span>';
					
					$return_html .= '<a id="cclexicon-anchor-' . $unique_id . '-' . $new_index. '"></a><div class="cclexicon-anchor-heading">' . $before_heading . $new_index. $after_heading . '</div>';
				}

				$lexicon_index = $new_index;
				$post_class .= ' cclexicon-index-all cclexicon-index-' . $lexicon_index;
			
				$link = get_permalink($id);
			
				$return_html .= '<div id="cclexicon-term-' . $unique_id . '-' . $id .'" class="cclexicon-term' . $post_class . '">';
			
				$return_html .= '<div id="cclexicon-title-' . $unique_id . '-' . $id . '" class="cclexicon-title">' . apply_filters( 'cclexicon_before_title', $before_title ) . get_the_title() . apply_filters( 'cclexicon_after_title', $after_title ) . '</div>';
			
				$return_html .= '<div id="cclexicon-description-' . $unique_id . '-' . $id .'" class="cclexicon-description">' . apply_filters( 'cclexicon_entry_content', get_the_content() ) . '</div>';
						
				$return_html .= '</div>';
			}
			
			$return_html .= '</div>';
			
			$lexicon_index_list .= '</div>';
			
			$return_html = apply_filters( 'cclexicon_index', $lexicon_index_list ) . $return_html;
			
			$return_html = '<div class="cclexicon-container ' . $skin . ' ccclearfix" id="cclexicon-container-' . $unique_id . '">' . $return_html . '</div>';
		}
		else {
			// no posts found
		}
		/* Restore original Post Data */
		wp_reset_postdata();
		
		return apply_filters( 'cclexicon_shortcode_html', $return_html );
	}	

	public static function enqueue_styles() {
		$css_file = apply_filters( 'cclexicon_css_file', plugins_url( 'css/styles.css' , __FILE__ ) );
		$js_file = apply_filters( 'cclexicon_js_file', plugins_url( 'js/cclexicon.js' , __FILE__ ) );
		if ( !is_admin() ) { 
			wp_register_style(
				'cclexiconlitecss',
				$css_file,
				false,
				self::plugin_version
			);
			wp_enqueue_style( 'cclexiconlitecss' );
			
			wp_enqueue_script(
				'cclexiconlitejs',
				$js_file,
				array( 'jquery' )
			);
		}
	}

	public static function admin_sort_order( $query ){
		if( !is_admin() )
			return;

		$screen = get_current_screen();
		if( (!empty($screen->base)) && 'edit' == $screen->base
			&& 'lexicon' == $screen->post_type
			&& !isset( $_GET['orderby'] ) ) {
				$query->set( 'orderby', 'title' );
				$query->set( 'order', 'ASC' );
		}
	}

	/*
	 * Show plugin links
	 */
	public static function plugin_action_links( $links ) {
		$links[] = '<a href="https://wordpress.org/support/view/plugin-reviews/cc-lexicon-lite" target="_blank">' . __('Rate this plugin...', 'cc-lexicon-lite') . '</a>';
//		$links[] = '<a href="http://www.ccplugins.co.uk" target="_blank">More from CC Plugins</a>';
		return $links;
	}

	public static function plugin_row_meta( $links, $file ) {
		$current_plugin = basename(dirname($file));
		
		if ( $current_plugin =='cc-lexicon-lite' ) {
			$links[] = '<a href="https://wordpress.org/support/view/plugin-reviews/cc-lexicon-lite" target="_blank">' . __('Rate this plugin...', 'cc-lexicon-lite') . '</a>';
			$links[] = '<a href="http://cclexiconlite.ccplugins.co.uk/donate/" target="_blank">' . __('Donate...', 'cc-lexicon-lite') . '</a> ' . __('(Your donations keep this plugin free &amp; supported)', 'cc-lexicon-lite');
		}
		
		return $links;
	}

	private static function the_slug($id) {
		$post_data = get_post($id, ARRAY_A);
		$slug = $post_data['post_name'];
		return $slug; 
	}

}

/*EOF*/