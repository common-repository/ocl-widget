<?php

if ( ! defined('ABSPATH')) {
    die;
}

function ordto_config_view()
{
    $api_key   = "";
    $site_url  = "";
    $view_mode = "";

    ordto_post_config();
    ordto_config_values($api_key, $site_url, $view_mode);

        ?>
        <div class="ordto-banner ordto-info-banner">
        Here you can change your widget
        </div>

        <div class="ordto-banner ordto-attention-banner">
            <div>
            1. Register your account at
            <a href="https://cloud.clientlist.io/register" target="_blank">https://cloud.clientlist.io/register</a>
            </div>
            <div>
            2. Login with your email and password here
            <a href="https://widget.clientlist.io/login" target="_blank">https://widget.clientlist.io/login</a>
            </div>
            <div>
            3. Generate your contact widget url and enter it to the form below
            </div>
        </div>

    <form method='post'>
        <label for="ordto-inp_api">
            <p> Input your widget url from widget.clientlist.io here:</p>
        </label>
        <input type="text" id="ordto-inp_api" name='widget_code' size="40" placeholder="Widget Url" autofocus style="width:400px;" value="<?php if (!empty($api_key)){echo stripslashes(wp_specialchars_decode($api_key));}?>">
        <br>
        <p> Here you can turn on/off your widget:</p>
        <input id="ordto-menu" type="radio" name="ordto-menu/widget" value="off"
            <?php if (!empty($view_mode)) {
                if ($view_mode == 'off') {
                    ?> checked <?php
                }
            } ?> > <label for="ordto-menu"> Off</label>
        <br>
        <input id="ordto-widget" type="radio" name="ordto-menu/widget" value="on"
            <?php if (!empty($view_mode)) {
                if ($view_mode != 'off') {
                    ?> checked <?php
                }
            } ?> > <label for="ordto-widget"> On</label>
        <br>
        <br>
        <input class='ordto-but ordto-save-but' type='submit' name='sub1' value="Confirm">
    </form>
    <?php
}

function ordto_post_config()
{
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        global $wpdb;

        $wpdb->insert($wpdb->options, ['option_name' => 'widget_code']);
        $wpdb->insert($wpdb->options, ['option_name' => 'ordto_view_mode']);

        if( ! empty($_POST['widget_code']) && ! empty($_POST['ordto-menu/widget'])) {
            if(filter_var($_POST['widget_code'], FILTER_VALIDATE_URL)){
                $wpdb->update($wpdb->options, ['option_value' => esc_url_raw($_POST['widget_code'])], ['option_name' => 'widget_code']);
                $wpdb->update($wpdb->options, ['option_value' => sanitize_text_field($_POST['ordto-menu/widget'])], ['option_name' => 'ordto_view_mode']);
                
                echo "<h3 class='ordto-h3'>All configuration is set!</h3>";
            }else{
                echo "<h3 class='ordto-h3'>Invalid widget url!</h3>";
            }
        } elseif ( ! empty($_POST['widget_code']) && empty($_POST['ordto-menu/widget'])) {
            $wpdb->update($wpdb->options, ['option_value' => esc_url_raw($_POST['widget_code'])], ['option_name' => 'widget_code']);
            echo "<h3 class='ordto-h3'>Widget code is set!</h3>";

        } else {

            return;
        }
    }
}

function ordto_config_values(&$api, &$url, &$wm)
{
    global $wpdb;

    $api = $wpdb->get_var("select option_value from $wpdb->options where option_name = 'widget_code'");
    $wm  = $wpdb->get_var("select option_value from $wpdb->options where option_name = 'ordto_view_mode'");
}

?>