<?php
/**
 * Plugin Name: Beacon
 * Plugin URI: http://github.com/ryanmarkel/beacon/
 * Description: Very simple podcasting for WordPress.
 * Version: 0.1
 * Author: Ryan Markel
 * Author URI: http://ryanmarkel.com/
 * License: GPL2
 */
 
 /* This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

// Register the podcast post type.

add_action ( 'init', 'podcast_create_post_type' );

function podcast_create_post_type() {
	$labels = array(
		'name'               => _x( 'Podcasts', 'post type general name', 'wp-podcast' ),
		'singular_name'      => _x( 'Podcast', 'post type singular name', 'wp-podcast' ),
		'menu_name'          => _x( 'Podcasts', 'admin menu', 'wp-podcast' ),
		'name_admin_bar'     => _x( 'Podcast', 'add new on admin bar', 'wp-podcast' ),
		'add_new'            => _x( 'Add New', 'book', 'wp-podcast' ),
		'add_new_item'       => __( 'Add New Podcast', 'wp-podcast' ),
		'new_item'           => __( 'New Podcast', 'wp-podcast' ),
		'edit_item'          => __( 'Edit Podcast', 'wp-podcast' ),
		'view_item'          => __( 'View Podcast', 'wp-podcast' ),
		'all_items'          => __( 'All Podcasts', 'wp-podcast' ),
		'search_items'       => __( 'Search Podcasts', 'wp-podcast' ),
		'not_found'          => __( 'No podcasts found.', 'wp-podcast' ),
		'not_found_in_trash' => __( 'No podcasts found in Trash.', 'wp-podcast' )
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'podcast' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'menu_position'      => 5,
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments', 'trackbacks', 'revisions' )
	);

	register_post_type( 'podcast', $args );
}

// Flush rewrites on activation.

function podcast_flush_rewrites() {
	podcast_create_post_type();
	flush_rewrite_rules();
}

register_activation_hook( __FILE__, 'podcast_flush_rewrites' );

// Add the podcast post type to the main loop.

// Add admin options and configuration panel.

add_action( 'admin_menu', 'wp_podcast_menu' );

function wp_podcast_menu() {
	add_options_page( 'WP Podcast Options', 'WP Podcast', 'manage_options', 'wp-podcast', 'wp_podcast_options' );
}

function wp_podcast_options() {
	if ( !current_user_can( 'manage_options' ) ) {
		wp_die( __( 'You do not have sufficient permissions to access this page.') );
	}
	echo '<div class="wrap">';
	echo '<p>Form things.</p>';
	echo '</div>';
}

// Generate the podcast RSS feed.

// TODO: Add manual enclosure support as a post metabox.
