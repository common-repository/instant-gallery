<?php


    /*
     Plugin Name: Insta-Gallery
     Plugin URI: http://elbuntu.com
     Description: Insta-Gallery is a plugin that allows you to display your Instagram Photos on your website. Also uses lightbox.
     Author: Ashley Johnson
     Author URI: http://elbuntu.com
     License: GNU GENERAL PUBLIC LICENSE 3.0 http://www.gnu.org/licenses/gpl.txt
     Version: 1.2
     Text-Domain: elbuntu-instantgallery
     Site Wide Only: true
    */

    /********************************
     * Activate the plugin for use! *
     *******************************/

    function ig_activate() {

        //Activate the plugin and install the tables

        global $wpdb;

        $wpdb->query("CREATE TABLE ig_plugin_settings (
            id int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
            option_name varchar(255),
            option_value varchar(255));");

        $wpdb->query(sprintf("INSERT INTO ig_plugin_settings (option_name, option_value) VALUES ('%s', '%s')", "userid", "615362320"));
        $wpdb->query(sprintf("INSERT INTO ig_plugin_settings (option_name, option_value) VALUES ('%s', '%s')", "token", "615362320.ab103e5.733d6360e475488394b08a6de1269609"));
        $wpdb->query(sprintf("INSERT INTO ig_plugin_settings (option_name, option_value) VALUES ('%s', '%s')", "igcolumns", "3"));
        $wpdb->query(sprintf("INSERT INTO ig_plugin_settings (option_name, option_value) VALUES ('%s', '%s')", "igborder", "yes"));
        $wpdb->query(sprintf("INSERT INTO ig_plugin_settings (option_name, option_value) VALUES ('%s', '%s')", "details", "no"));
    
    }

    register_activation_hook( __FILE__, 'ig_activate' );

    function ig_deactivate() {

        //Remove tables
        global $wpdb;

        $wpdb->query("DROP TABLE ig_plugin_settings");

    }

    register_deactivation_hook( __FILE__, 'ig_deactivate');

    //Build the backend menu

    function ig_admin_menu() {

        if(!is_super_admin()):
            return false;
        endif;

        require ( dirname( __FILE__ ) . '/admin/admin.php' );

        add_menu_page('Elbuntu Instant Gallery', 'Instant Gallery', 'manage_options', 'instantgallery-menu', 'init_instantgallery');

    }

    add_action( 'admin_menu', 'ig_admin_menu' );

    //INCLUDE FRONT END 
    require( dirname( __FILE__ ) . '/instantgallery-engine.php' );

?>