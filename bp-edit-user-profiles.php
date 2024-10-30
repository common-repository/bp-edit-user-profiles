<?php
/*
Plugin Name: BuddyPress Edit User Profiles
Plugin URI: http://seannewby.ca#plugins
Description: Adds a "Edit BuddyPress Profile" link to the users page in the dashboard if current user is an administrator.
Version: 1.3.1
Author: Sean Newby
Author URI: http://seannewby.ca
Text Domain: bp-edit-user-profiles
Domain Path: /languages
License: GPL2

Copyright 2016 Sean Newby (email : sean@seannewby.ca)

This program is free software; you can redistribute it and/or modify
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

if( !class_exists( 'bpEditProfile' ) ){
	class bpEditProfile{
		function __construct() {
      add_action( 'plugins_loaded', array( &$this, 'load_plugin_textdomain' ) );
			add_action( 'init' , array( &$this, 'init' ) );
		}

		function load_plugin_textdomain() {
			// localization
			load_plugin_textdomain( 'bp-edit-user-profiles', false, basename( dirname( __FILE__ ) ) . '/languages' );
		}

		function init(){
			// check for buddypress and in the dashboard before we add the filter
			if( function_exists( 'bp_core_get_user_domain' ) && is_admin() ) {
				add_filter ( 'user_row_actions' , array( &$this , 'add_edit_profile' ), 20, 2 );
			}
		}

		function add_edit_profile( $actions , $user_object ){
			// Add "Edit BuddyPress Profile" to $actions array if current user is an admin
			if( current_user_can( 'delete_users' ) ) {
				$actions['edit_profiles'] = '<a href="' . bp_core_get_user_domain( $user_object->ID ) . 'profile/edit/" title="' . __( 'Edit BuddyPress Profile' , 'bp-edit-user-profiles' ) . '">' . __( 'Edit BuddyPress Profile' , 'bp-edit-user-profiles' ) . '</a>';
			}
			return $actions;
		}
	}
}

// Instantiate the class
if ( class_exists( 'bpEditProfile' ) ) {
	$bp_edit_profile = new bpEditProfile;
}
