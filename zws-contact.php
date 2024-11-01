<?php
/*
 * Plugin Name: ZWS Contact
 * Description: A simple contact form Plugin for wordpress
 * Version: 1.1
 * Author: Zia Web Solutions
 * Author URI: http://ziawebsolutions.com/
 */
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

    
//Include Plugins own style
wp_enqueue_style('zwscontact-styles', plugins_url('/css/zwscontact_styles.css', __FILE__));

register_activation_hook(__FILE__, 'zws_create_table');
require_once( plugin_dir_path(__FILE__) . 'include/zws-create-table.php' );
require_once( plugin_dir_path(__FILE__) . 'include/zws-form-configuration.php' );
require_once( plugin_dir_path(__FILE__) . 'include/zws-message-list.php' );

//adding plugin menu to admin menu
add_action('admin_menu', 'zwscontact_menu');

function zwscontact_menu()
{
    add_menu_page(__('ZWS Contact Inbox', 'zwscontact'), __('ZWS Contact', 'zwscontact'), 'activate_plugins', 'zwscontact-inbox', 'zws_display_messages', 'dashicons-email');
    add_submenu_page('zwscontact-inbox', __('ZWS Contact Inbox', 'zwscontact'), __('Inbox', 'zwscontact'), 'activate_plugins', 'zwscontact-inbox', 'zws_display_messages');
    add_submenu_page('zwscontact-inbox', __('Form Configuration', 'zwscontact'), __('Form Configuration', 'zwscontact'), 'activate_plugins', 'zwscontact_form_configuration', 'zws_form_configuration');
}

function zws_display_messages()
{
    global $wpdb;

    $table = new ZWS_Message_List();
    $table->prepare_items();

    $message = '';
    if ('delete' === $table->current_action()) {
        $message = '<div class="updated below-h2" id="message"><p>' . sprintf(__('Items deleted: %d', 'zwscontact'), count($_REQUEST['id'])) . '</p></div>';
    }
    ?>
    <div class="wrap">
        <h2><?php _e('ZWS Contact Inbox', 'zwscontact') ?></h2>
    <?php echo $message; ?>

        <form method="GET">
            <input type="hidden" name="page" value="<?php echo $_REQUEST['page'] ?>"/>
    <?php $table->display(); ?>
        </form>
    </div>
    <?php
}

function zws_send_email()
{
    $error_msg_name = '';
    $error_msg_email = '';
    $error_msg_phone = '';
    $error_msg_website = '';
    $error_msg_subject = '';
    $error_msg_message = '';

    if (isset($_POST['zwsc-submitted'])) {

        if ($_POST['zwsc-name'] != '') {
            if (!preg_match("/^[a-zA-Z ]*$/", $_POST['zwsc-name'])) {
                $error_msg .= "This is not a valid name.<br/>";
                $error_msg_name = "This is not a valid name.<br/>";
            }
            $name_filed_value = $_POST['zwsc-name'];
        }
        if ($_POST['zwsc-email'] != '') {
            $email_validation = filter_var($_POST['zwsc-email'], FILTER_SANITIZE_EMAIL);
            if ($email_validation == '') {
                $error_msg .= "Email filed is required.<br/>";
                $error_msg_email = "Email filed is required.<br/>";
            } else if (!filter_var($email_validation, FILTER_VALIDATE_EMAIL)) {
                $error_msg .= "This is not a valid email address.<br/>";
                $error_msg_email = "This is not a valid email address.<br/>";
            }
            $email_filed_value = $_POST['zwsc-email'];
        }
        if ($_POST['zwsc-phone'] != '') {
            $phone_validation = filter_var($_POST['zwsc-phone'], FILTER_SANITIZE_NUMBER_INT);
            if ($phone_validation == '') {
                $error_msg .= "This is not a valid phone number.<br/>";
                $error_msg_phone = "This is not a valid phone number.<br/>";
            }
            $phone_filed_value = $_POST['zwsc-phone'];
        }
        if ($_POST['zwsc-website'] != '') {
            $website_validation = filter_var($_POST['zwsc-website'], FILTER_SANITIZE_URL);
            if ($website_validation == '') {
                $error_msg .= "Website filed is required.<br/>";
                $error_msg_website = "Website filed is required.<br/>";
            } else if (!filter_var($website_validation, FILTER_VALIDATE_URL)) {
                $error_msg .= "This is not a valid website url.<br/>";
                $error_msg_website = "This is not a valid website url.<br/>";
            }
            $website_filed_value = $_POST['zwsc-website'];
        }
        if ($_POST['zwsc-subject'] != '') {
            if ($_POST["zwsc-subject"] == '') {
                $error_msg .= "Subject filed is required.<br/>";
            }
            $subject_filed_value = $_POST['zwsc-subject'];
        }
        if ($_POST['zwsc-message'] != '') {
            if ($_POST["zwsc-message"] == '') {
                $error_msg .= "Message filed is required.<br/>";
            }
            $message_filed_value = $_POST['zwsc-message'];
        }
        if (!$error_msg) {
            global $wpdb;
            $data = array(
                'name' => sanitize_text_field($_POST['zwsc-name']),
                'email' => sanitize_email($_POST['zwsc-email']),
                'phone' => sanitize_text_field($_POST['zwsc-phone']),
                'website' => sanitize_text_field($_POST['zwsc-website']),
                'subject' => sanitize_text_field($_POST['zwsc-subject']),
                'message' => sanitize_text_field($_POST['zwsc-message'])
            );
            $table_name = $wpdb->prefix . 'zws_contact';

            $wpdb->insert($table_name, $data);
            $lastid = $wpdb->insert_id;

            if ($lastid) {
                $headers = array('From: ' . $data['name'] . ' <' . $data['email'] . '>');
                // get the site administrator's email address
                $to = get_option('admin_email');
                if ($data['name'] != '') {
                    $message = "Name :" . $data['name'] . "\n";
                }
                if ($data['email'] != '') {
                    $message .= "Email :" . $data['email'] . "\n";
                }
                if ($data['phone'] != '') {
                    $message .= "Phone :" . $data['phone'] . "\n";
                }
                if ($data['website'] != '') {
                    $message .= "Website :" . $data['website'] . "\n";
                }
                if ($data['subject'] != '') {
                    $message .= "Subject :" . $data['subject'] . "\n";
                }
                if ($data['message'] != '') {
                    $message .= "Message :" . $data['message'] . "\n";
                }
                // If email has been process for sending, display a success message
                if (wp_mail($to, $data['subject'], $message, $headers)) {
                    echo '<p>Thanks for contacting us, we will get in touch with you soon.</p>';
                    $name_filed_value = '';
                    $email_filed_value = '';
                    $phone_filed_value = '';
                    $website_filed_value = '';
                    $subject_filed_value = '';
                    $message_filed_value = '';
                } else {
                    echo '<p>An unexpected error occurred.</p>';
                }
            } else {
                echo '<p>An unexpected error occurred.</p>';
            }
        }
    }
    ?>
    <p class="zwsc-required"><?php _e('All fields marked with an asterisk (<span class="zwsc-asterisk">*</span>) are required.'); ?></p>
    <form action="" method="post">
    <?php if (get_option('zwsc_name_visibility') != '') { ?>
            <p>
                <label><?php echo get_option('zwsc_name_label'); ?><?php if (get_option('zwsc_name_required') != '') { ?><span class="zwsc-asterisk">*</span></label><?php } ?><br/>
                <input type="text" name="zwsc-name" value="<?php echo $name_filed_value; ?>" size="40" <?php if (get_option('zwsc_name_required') != '') { ?> required=""<?php } ?> />
                <span class="zwsc_form_error_msg"><?php echo $error_msg_name; ?></span>
            </p>
        <?php } ?>

    <?php if (get_option('zwsc_email_visibility') != '') { ?>
            <p>
                <label><?php echo get_option('zwsc_email_label'); ?><?php if (get_option('zwsc_email_required') != '') { ?><span class="zwsc-asterisk">*</span></label><?php } ?><br/>
                <input type="email" name="zwsc-email" value="<?php echo $email_filed_value; ?>" size="40" <?php if (get_option('zwsc_email_required') != '') { ?> required="" <?php } ?> /><br/>
                <span class="zwsc_form_error_msg"><?php echo $error_msg_email; ?></span>
            </p>
        <?php } ?>

    <?php if (get_option('zwsc_phone_visibility') != '') { ?>
            <p>
                <label><?php echo get_option('zwsc_phone_label'); ?><?php if (get_option('zwsc_phone_required') != '') { ?><span class="zwsc-asterisk">*</span></label><?php } ?><br/>
                <input type="tel" name="zwsc-phone" value="<?php echo $phone_filed_value; ?>" size="40" <?php if (get_option('zwsc_phone_required') != '') { ?> required="" <?php } ?> /><br />
                <span class="zwsc_form_error_msg"><?php echo $error_msg_phone; ?></span>
            </p>
        <?php } ?>
    <?php if (get_option('zwsc_website_visibility') != '') { ?>
            <p>
                <label><?php echo get_option('zwsc_website_label'); ?><?php if (get_option('zwsc_website_required') != '') { ?><span class="zwsc-asterisk">*</span></label><?php } ?><br/>
                <input type="url" name="zwsc-website" value="<?php echo $website_filed_value; ?>" size="40" <?php if (get_option('zwsc_website_required') != '') { ?> required="" <?php } ?> /><br />
                <span class="zwsc_form_error_msg"><?php echo $error_msg_website; ?></span>
            </p>
        <?php } ?>
    <?php if (get_option('zwsc_subject_visibility') != '') { ?>
            <p>
                <label><?php echo get_option('zwsc_subject_label'); ?><?php if (get_option('zwsc_subject_required') != '') { ?><span class="zwsc-asterisk">*</span></label><?php } ?><br/>
                <input type="text" name="zwsc-subject" value="<?php echo $subject_filed_value; ?>" size="40" <?php if (get_option('zwsc_subject_required') != '') { ?> required="" <?php } ?> />
            </p>
        <?php } ?>
    <?php if (get_option('zwsc_message_visibility') != '') { ?>
            <p>
                <label><?php echo get_option('zwsc_message_label'); ?><?php if (get_option('zwsc_message_required') != '') { ?><span class="zwsc-asterisk">*</span></label><?php } ?><br/>
                <textarea rows="10" cols="35" name="zwsc-message" <?php if (get_option('zwsc_message_required') != '') { ?> required="" <?php } ?> ><?php echo $message_filed_value; ?></textarea>
            </p>
            <?php } ?>
        <p>
    <?php wp_nonce_field('zwscontact_nonce', 'zwsc') ?>
            <input type="submit" name="zwsc-submitted" value="<?php esc_html_e('Send') ?>">
        </p>
    </form>
    <?php
}

function zwsc_shortcode()
{
    ob_start();
    zws_send_email();
    $output_string = ob_get_contents();
    ob_end_clean();
    return $output_string;
}

add_shortcode('zws_contact_form', 'zwsc_shortcode');
?>
