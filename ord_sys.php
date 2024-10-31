<?php
/*
 * Plugin Name:       Ocl Widget
 * Description:       Generate your own contact widget and start gathering data from your clients
 * Version:           1.0.1
 * Author:            Getreve Ltd
 * Author URI:        https://getreve.com/
 */

if (!defined('ABSPATH')) {
    die;
}

require_once __DIR__ . '/includes/items_view.php';
require_once __DIR__ . '/includes/config.php';
require_once __DIR__ . '/includes/menu_or_widget.php';

function ordto_register_assets_is_admin()
{
    wp_register_style('ordto_style', plugins_url('admin/css/style.css', __FILE__), false, time());
}

function ordto_register_assets_isnt_admin()
{
    wp_register_script('ordto_script', plugins_url('admin/js/add-menu-script.js', __FILE__), false, time());
}

function ordto_enqueue_assets_is_admin($hook)
{
    if ($hook != 'toplevel_page_ordto-config') {
        if ($hook != 'ord-to_page_products') {
            if ($hook != 'ord-to_page_orders') {
                wp_deregister_style('ordto_style');

                return;
            }
        }
    }
    wp_enqueue_style('ordto_style');
}

function ordto_enqueue_assets_isnt_admin()
{
    wp_enqueue_script('ordto_script');
}

function ordto_show_new_items()
{
    $title = 'Ocl widget configuration';
    if (current_user_can('manage_options')) {
        add_menu_page(
            esc_html__($title),
            esc_html__('Ocl widget'),
            'manage_options',
            'ordto-config',
            'ordto_add_config',
            'dashicons-clipboard',
            3
        );
    }
}

if (is_admin()) {
    add_action('admin_enqueue_scripts', 'ordto_register_assets_is_admin');
    add_action('admin_enqueue_scripts', 'ordto_enqueue_assets_is_admin');
    add_action('admin_menu', 'ordto_show_new_items');
}

if (!is_admin()) {
    add_action('wp_enqueue_scripts', 'ordto_register_assets_isnt_admin');
    ordto_view_public();
}
