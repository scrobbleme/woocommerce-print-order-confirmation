<?php

/**
 * Plugin Name: WooCommerce Print Order Confirmation
 * Plugin URI: http://git.githost.de/wordpress/woocommerce-print-order-confirmation
 * Description: This plugin allows administrators to print order confirmations. It requires the plugin "WooCommerce Print Invoices & Delivery Notes" to work.
 * Author: Adrian Moerchen
 * Author URI: http://demo.moewe-studio.com/wp/
 * Version: 1.1
 *
 * License: GNU General Public License v3.0
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 */

if (!defined('ABSPATH')) {
    exit;
}

final class WooCommerce_Print_Order_Confirmation
{

    public function __construct()
    {

        add_action('init', array($this, 'plugin_init'));

        add_action('wcdn_template_registration', array($this, 'add_template_type'), 100, 1);
        add_filter('wcdn_document_title', array($this, 'get_document_title'), 100);

        add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts'));
    }

    function admin_enqueue_scripts()
    {
        wp_enqueue_style('woocommerce-print-order-confirmation-css', plugins_url('styles.css', __FILE__), false, '1.1');
    }

    function plugin_init()
    {
        load_plugin_textdomain('woocommerce-print-order-confirmation', false, dirname(plugin_basename(__FILE__)) . '/languages');
    }

    public function add_template_type($templates)
    {
        $templates[] = array(
            'type' => 'order-confirmation',
            'labels' => array(
                'name' => __('Order Confirmation', 'woocommerce-print-order-confirmation'),
                'name_plural' => __('Order Confirmations', 'woocommerce-print-order-confirmation'),
                'print' => __('Print Order Confirmation', 'woocommerce-print-order-confirmation'),
                'print_plural' => __('Print Order Confirmations', 'woocommerce-print-order-confirmation'),
                'message' => __('Order Confirmation created.', 'woocommerce-print-order-confirmation'),
                'message_plural' => __('Order Confirmation created.', 'woocommerce-print-order-confirmation'),
                'setting' => __('Enable Order Confirmations', 'woocommerce-print-order-confirmation')
            )
        );
        return $templates;
    }

    function get_document_title($title)
    {
        if (wcdn_get_template_type() == 'order-confirmation') {
            return __('Order Confirmation', 'woocommerce-print-order-confirmation');
        }
        return $title;
    }
}

new WooCommerce_Print_Order_Confirmation();
