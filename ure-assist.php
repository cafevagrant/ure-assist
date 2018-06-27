<?php

/*
  Plugin Name: URE Assist
  Plugin URI: https://www.cafevagrant.com
  Description: Helps URE with certain role permission
  Author: Cafe Vagrant
  Version: 1.0
  Author URI: https://www.cafevagrant.com
 */
 
if ( is_admin() ) {
    add_action('plugins_loaded', 'ure_loaded');
    function ure_loaded() {

        if ( defined('URE_VERSION') ) {
          global $pagenow;
          $user = wp_get_current_user();

          if (!in_array('webmaster', $user->roles)){
            
            add_filter('ure_show_additional_capabilities_section', 'ure_show_additional_capabilities_section');
            add_filter('ure_bulk_grant_roles',  'ure_show_additional_capabilities_section');
             
            function ure_show_additional_capabilities_section($show) {
                if (in_array('admin', $user->roles) || in_array('administrator', $user->roles)) {
                    $show = false;
                }

                return $show; 
            }

            add_filter('ure_supress_administrators_protection', 'remove_ure_administrator_protection', 10, 1);
            function remove_ure_administrator_protection($supress_protection) {

                $supress_protection = true;
                
                return $supress_protection;
            }
            if ($pagenow == 'users.php') {
              add_action('admin_enqueue_scripts', 'load_admin_style');
              function load_admin_style() {
                wp_register_style('ure-styles', plugins_url( '/css/admin.css', __FILE__ ) );
                wp_enqueue_style('ure-styles');
              }
            }
          }
        }
    }
}
