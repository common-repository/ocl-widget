<?php

if ( ! defined('ABSPATH')) {
    die;
}

function ordto_add_widget()
{
    global $wpdb;
    $url = $wpdb->get_var("select option_value from $wpdb->options where option_name = 'widget_code';");

    wp_enqueue_script('widget_script',"https://widget.clientlist.io/js/widget.min.js");
    
    ?>
    <div id="ocl-widget-wrapper" ><div data-ocl-widget-url="<?php echo esc_attr($url); ?>" data-ocl-widget-id="4" onclick="event.preventDefault(); oclStartWidget();" id="ocl-widget-tab"><a id="ocl-widget-tab-name" href="#"></a></div><iframe id="ocl-iframe" width="0" height="0"></iframe><div id="ocl-widget-close" onclick="event.preventDefault(); oclStartWidget();"></div></div>
    
    <?php

}

function ordto_view_public()
{
    global $wpdb;
    $code = $wpdb->get_var("select option_value from $wpdb->options where option_name = 'widget_code';");
    $wm  = $wpdb->get_var("select option_value from $wpdb->options where option_name = 'ordto_view_mode'");

    if ( ! empty($wm)) {

        if ($wm === 'on' && ! empty($code)) {

            add_action('wp_footer', 'ordto_add_widget');

        }
    }
}

?>