<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    leave_management
 * @subpackage leave_management/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    leave_management
 * @subpackage leave_management/includes
 * @author     Your Name <email@example.com>
 */
class leave_management_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		global $wpdb;
		$leave =  $wpdb->prefix. 'leave'; 
		$leave_products =  $wpdb->prefix. 'leave_products';

		// $wpdb->query( "DROP TABLE IF EXISTS $leave" );
		// $wpdb->query( "DROP TABLE IF EXISTS $leave_products" );
		// delete_option("leave_management_db_version");
		self::user_remove_role();
	}

	private static function	user_remove_role(){
		remove_role( 'leave-admin' );
		remove_role( 'product-manager' );
		remove_role( 'order-manager' );
		remove_role( 'normal-user' );
	}

}
