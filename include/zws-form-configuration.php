<?php
if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

function zws_form_configuration()
{
    $name_visibility = (get_option('zwsc_name_visibility') == 'enabled') ? 'checked' : '';
    $name_required = (get_option('zwsc_name_required') == 'enabled') ? 'checked' : '';
    $name_label = (get_option('zwsc_name_label') != '') ? get_option('zwsc_name_label') : 'Name';

    $email_visibility = (get_option('zwsc_email_visibility') == 'enabled') ? 'checked' : '';
    $email_required = (get_option('zwsc_email_required') == 'enabled') ? 'checked' : '';
    $email_label = (get_option('zwsc_email_label') != '') ? get_option('zwsc_email_label') : 'Email';

    $phone_visibility = (get_option('zwsc_phone_visibility') == 'enabled') ? 'checked' : '';
    $phone_required = (get_option('zwsc_phone_required') == 'enabled') ? 'checked' : '';
    $phone_label = (get_option('zwsc_phone_label') != '') ? get_option('zwsc_phone_label') : 'Phone';

    $website_visibility = (get_option('zwsc_website_visibility') == 'enabled') ? 'checked' : '';
    $website_required = (get_option('zwsc_website_required') == 'enabled') ? 'checked' : '';
    $website_label = (get_option('zwsc_website_label') != '') ? get_option('zwsc_website_label') : 'Website';

    $subject_visibility = (get_option('zwsc_subject_visibility') == 'enabled') ? 'checked' : '';
    $subject_required = (get_option('zwsc_subject_required') == 'enabled') ? 'checked' : '';
    $subject_label = (get_option('zwsc_subject_label') != '') ? get_option('zwsc_subject_label') : 'Subject';

    $message_visibility = (get_option('zwsc_message_visibility') == 'enabled') ? 'checked' : '';
    $message_required = (get_option('zwsc_message_required') == 'enabled') ? 'checked' : '';
    $message_label = (get_option('zwsc_message_label') != '') ? get_option('zwsc_message_label') : 'Message';
    ?>
    <form class="zwsc-configuration-form" method="post" name="options" action="options.php">
        <h2><?php esc_html_e('ZWS Contact Form Configuration') ?></h2><?php echo wp_nonce_field('update-options'); ?>
        <p><strong><?php echo esc_html('To display ZWS Contact form use this shortcode: [zws_contact_form]'); ?></strong></p>
        <table cellpadding="10">
            <tbody>
                <tr>
                    <td>
                        <h3><?php esc_html_e('Name: ') ?></h3>
                    </td> 
                    <td>
                        <label><?php esc_html_e('Visibility') ?></label><input type="checkbox" <?php echo $name_visibility; ?> name="zwsc_name_visibility" value="enabled" />
                    </td> 
                    <td>
                        <label><?php esc_html_e('Required') ?></label><input type="checkbox" <?php echo $name_required; ?> name="zwsc_name_required" value="enabled" />
                    </td>
                    <td>
                        <label><?php esc_html_e('Label') ?></label><input type="text" name="zwsc_name_label" value="<?php echo $name_label; ?>" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3><?php esc_html_e('Email: ') ?></h3>
                    </td>
                    <td>
                        <label><?php esc_html_e('Visibility') ?></label><input type="checkbox" <?php echo $email_visibility; ?> name="zwsc_email_visibility" value="enabled" />
                    </td> 
                    <td>
                        <label><?php esc_html_e('Required') ?></label><input type="checkbox" <?php echo $email_required; ?> name="zwsc_email_required" value="enabled" />
                    </td>
                    <td>
                        <label><?php esc_html_e('Label') ?></label><input type="text" name="zwsc_email_label" value="<?php echo $email_label; ?>" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3><?php esc_html_e('Phone: ') ?></h3>
                    </td>
                    <td>
                        <label><?php esc_html_e('Visibility') ?></label><input type="checkbox" <?php echo $phone_visibility; ?> name="zwsc_phone_visibility" value="enabled" />
                    </td> 
                    <td>
                        <label><?php esc_html_e('Required') ?></label><input type="checkbox" <?php echo $phone_required; ?> name="zwsc_phone_required" value="enabled" />
                    </td>
                    <td>
                        <label><?php esc_html_e('Label') ?></label><input type="text" name="zwsc_phone_label" value="<?php echo $phone_label; ?>" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3><?php esc_html_e('Website: ') ?></h3>
                    </td>
                    <td>
                        <label><?php esc_html_e('Visibility') ?></label><input type="checkbox" <?php echo $website_visibility; ?> name="zwsc_website_visibility" value="enabled" />
                    </td> 
                    <td>
                        <label><?php esc_html_e('Required') ?></label><input type="checkbox" <?php echo $website_required; ?> name="zwsc_website_required" value="enabled" />
                    </td>
                    <td>
                        <label><?php esc_html_e('Label') ?></label><input type="text" name="zwsc_website_label" value="<?php echo $website_label; ?>" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3><?php esc_html_e('Subject: ') ?></h3>
                    </td>
                    <td>
                        <label><?php esc_html_e('Visibility') ?></label><input type="checkbox" <?php echo $subject_visibility; ?> name="zwsc_subject_visibility" value="enabled" />
                    </td> 
                    <td>
                        <label><?php esc_html_e('Required') ?></label><input type="checkbox" <?php echo $subject_required; ?> name="zwsc_subject_required" value="enabled" />
                    </td>
                    <td>
                        <label><?php esc_html_e('Label') ?></label><input type="text" name="zwsc_subject_label" value="<?php echo $subject_label; ?>" />
                    </td>
                </tr>
                <tr>
                    <td>
                        <h3><?php esc_html_e('Message: ') ?></h3>
                    </td>
                    <td>
                        <label><?php esc_html_e('Visibility') ?></label><input type="checkbox" <?php echo $message_visibility; ?> name="zwsc_message_visibility" value="enabled" />
                    </td> 
                    <td>
                        <label><?php esc_html_e('Required') ?></label><input type="checkbox" <?php echo $message_required; ?> name="zwsc_message_required" value="enabled" />
                    </td>
                    <td>
                        <label><?php esc_html_e('Label') ?></label><input type="text" name="zwsc_message_label" value="<?php echo $message_label; ?>" />
                    </td>
                </tr>
            </tbody>
        </table>
        <p class="submit">
            <input type="hidden" name="action" value="update" />  
            <input type="hidden" name="page_options" value="zwsc_name_visibility,zwsc_name_required,zwsc_name_label,zwsc_email_visibility,zwsc_email_required,zwsc_email_label,zwsc_phone_visibility,zwsc_phone_required,zwsc_phone_label,zwsc_website_visibility,zwsc_website_required,zwsc_website_label,zwsc_subject_visibility,zwsc_subject_required,zwsc_subject_label,zwsc_message_visibility,zwsc_message_required,zwsc_message_label" /> 
            <input type="submit" name="Submit" value="Update" />
        </p>
    </form>
    <?php
}
