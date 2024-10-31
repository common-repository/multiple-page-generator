<?php
/*
Plugin Name: Multiple Page Generator
Plugin URI: https://wordpress.org/plugins/multiple-page-generator/
Description: Multiple Page Generator is the latest plugin designed to generate multiple pages whilst ensuring that duplicate content is eliminated. Keywords are assigned to pre-set variables which are then replaced during the page generation process. For example, zip, state, city, phone, images, etc). Multiple Page Generator allows keywords to be created and displayed for the users. In turn, this allows SEO experts to select the keywords based on the content being created. Once the page template has been created multiple pages are generated based on the keywords. 
Version: 1.3
Author: VisualWebz LLC
Author URI: https://visualwebz.com/multiple-page-generator
Text Domain: multiple-page-generator
License: GNU General Public License v2 or later
*/

if (!defined('ABSPATH')) exit; //Exit if accessed directly.

//MPG stands for multiple page generator

defined('ABSPATH') or die('No script kiddies please!');

//path of the plugin
define('MPG_PLUGIN_PATH', plugin_dir_path(__FILE__));

//adding menus to the admin menu
add_action('admin_menu', 'mpg_setup_menu');

//function that creates menus
function mpg_setup_menu()
{
    add_menu_page('Multiple Page Generator page', 'Multiple Page Generator', 'manage_options', 'mpg_plugin_menu', 'mpg_pageGenerator', '', 2);
    add_submenu_page('mpg_plugin_menu', 'Single Inserter Page', 'Pages Creator', 'manage_options', 'mpg_single-generator', 'mpg_single_create');
    add_submenu_page('mpg_plugin_menu', 'Upload xlsx Page', 'Excel Sheet Pages Creator', 'manage_options', 'xlsx-page-generator', 'mpg_xlsx_page_create');
    remove_submenu_page('mpg_plugin_menu', 'mpg_plugin_menu');
}

function mpg_check_Yoast() {

    if (('multiple-page-generator_page_single-generator' || 'multiple-page-generator_page_xlsx-page-generator') != $hook) {
        if (!is_plugin_active('wordpress-seo/wp-seo.php')) {
        }
    }
}
add_action( 'admin_init', 'mpg_check_Yoast' );

//main layout of the plugin
function mpg_pageGenerator()
{
    echo "<h1>Welcome to the home page of Plug-in</h1>";
}

//functions that displays error message to install Yoast plugin (if not installed or activated)
function mpg_show_message(){

    if(file_exists(ABSPATH . '/wp-content/plugins/wordpress-seo-premium/wp-seo-premium.php')){
        if(is_plugin_active('wordpress-seo-premium/wp-seo-premium.php')){
            return true;
    }else{
             $url = wp_nonce_url(admin_url('plugins.php?action=activate&plugin=wordpress-seo-premium/wp-seo-premium.php'), 'activate-plugin_wordpress-seo-premium/wp-seo-premium.php');
        echo '<br>
            <div class="notice notice-info is-dismissible">
                <p>Please activate required plugin (Yoast premium) to get better SEO purposes. <a href="'.$url.'">Activate Yoast</a></p>
            </div><br>';
            return false;
        }
    }
    if (!is_plugin_active('wordpress-seo/wp-seo.php')) {
        if(!file_exists(ABSPATH . '/wp-content/plugins/wordpress-seo/wp-seo.php')){
            $url = wp_nonce_url(add_query_arg(array('action' => 'install-plugin','plugin' => 'wordpress-seo'),admin_url( 'update.php' )),'install-plugin_wordpress-seo');
        echo '<br>
            <div class="notice notice-info is-dismissible">
                <p>Please install and activate required plugin (Yoast) to get better SEO purposes. <a href="'.$url.'">Install Yoast</a></p>
            </div><br>';
            return false;
        }else {
            $url = wp_nonce_url(admin_url('plugins.php?action=activate&plugin=wordpress-seo/wp-seo.php'), 'activate-plugin_wordpress-seo/wp-seo.php');
            echo '<br>
                <div class="notice notice-info is-dismissible">
                    <p>Please activate required plugin (Yoast) to get better SEO purposes. <a href="'.$url.'">Activate Yoast</a></p>
                </div><br>';
                return false;
        }

    }
    return true;
}
//function that calls Page Creator Layout
function mpg_single_create()
{
    echo "<h1>Pages Creator</h1>";
    if(mpg_show_message()){
        include MPG_PLUGIN_PATH . 'view/layout2.php';
    }
}

//function that calls Excel Sheet Page Creator Layout
function mpg_xlsx_page_create()
{
    echo "<h1>Excel Sheet Pages Creator</h1>";
    if(mpg_show_message()){
    include MPG_PLUGIN_PATH . 'view/layout3.php';
    }
}

//adding all js scripts and styling to the header
function mpg_enqueue_script($hook)
{
    if (('multiple-page-generator_page_single-generator' || 'multiple-page-generator_page_xlsx-page-generator') != $hook) {
        return;
    }
    if ('multiple-page-generator_page_xlsx-page-generator' === $hook) {
        wp_enqueue_script('jquery');
        wp_enqueue_script('mpg_xls_script', plugins_url('assets/js/library/xls.core.min.js', __FILE__));
        wp_enqueue_script('mpg_xlsx_script', plugins_url('assets/js/library/xlsx.core.min.js', __FILE__));
    }
    wp_enqueue_script('MPG_functions_script', plugins_url('assets/js/mpgFunctions.js', __FILE__));
    wp_enqueue_style('mpg_custom_style', plugins_url('assets/css/styles.css', __FILE__));
}
//adding mpg_enqueue_script to the admin page
add_action('admin_enqueue_scripts', 'mpg_enqueue_script');
