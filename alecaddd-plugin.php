<?php 
/**
* Plugin Name: Alecaddd plugin
* Plugin URI: https://github.com/lucassdantas
* Description: test plugin
* Version: 0.1
* Author: Lucas Dantas 
* Author URI: linkedin.com/in/lucas-de-sousa-dantas/
**/

defined('ABSPATH') or die;
if( file_exists(dirname(__FILE__). '/vendor/autoload.php')){
    require_once dirname(__FILE__). '/vendor/autoload.php';
}
use Inc\Activate;
class AleccadddPlugin
{
    public $plugin_name;
    
    function __construct(){
        add_action('init', array( $this, 'cpt'));
        $this->plugin_name = plugin_basename(__FILE__);
    }
    function register(){
        add_action("admin_enqueue_scripts", array($this, 'enqueue'));
        add_action('admin_menu', array($this, 'add_admin_pages'));
        add_Filter("plugin_action_links_$this->plugin_name", array($this, 'settings_link'));
    }

    function settings_link($links){
        $settings_links = '<a href="admin.php?page=alecaddd_plugin">Settings</a>';
        array_push($links, $settings_links);
        return $links;
    }
    function add_admin_pages() {
        add_menu_page('Alecaddd page title', 'Alecaddd menu title', 'manage_options', 'alecaddd_plugin', array($this, 'admin_index'), 'adhicons-store', 110);
    }

    function admin_index(){
        require_once plugin_dir_path(__FILE__).'templates/admin.php';
    }
    function activate(){
        Activate::activate();
    }
    function deactivate(){
        flush_rewrite_rules();
    }
    function cpt(){
        register_post_type('book', ['public' => true, 'label' => "nome"]);
    }

    function enqueue(){
        wp_enqueue_style("mypluginstyle", plugins_url('/assets/al_style.css', __FILE__));
    }
    function uninstall(){
        require_once plugin_dir_path( __FILE__ ) . 'uninstall.php';
    }
}

if (class_exists('AleccadddPlugin')){
    $alecadddPlugin = new AleccadddPlugin();
    register_activation_hook( __FILE__, array($alecadddPlugin, 'activate') );
    register_deactivation_hook( __FILE__, array($alecadddPlugin, 'deactivate') );
    register_uninstall_hook( __FILE__, array($alecadddPlugin, 'uninstall') );
    
    $alecadddPlugin->register();
}
