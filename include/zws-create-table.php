<?php

if (!defined('ABSPATH'))
    exit; // Exit if accessed directly

function zws_create_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'zws_contact';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
  id mediumint(9) NOT NULL AUTO_INCREMENT,
  name varchar(50) DEFAULT NULL,
  email varchar(75) DEFAULT NULL,
  phone varchar(255) default NULL,
  website varchar(255) default NULL,
  subject varchar(100) DEFAULT NULL,
  message text,
  UNIQUE KEY id (id)
) $charset_collate;";
    require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
    dbDelta($sql);

    add_option('zwsc_name_visibility', 'enabled', '', 'yes');
    add_option('zwsc_name_required', 'enabled', '', 'yes');
    add_option('zwsc_name_label', 'Name', '', 'yes');

    add_option('zwsc_email_visibility', 'enabled', '', 'yes');
    add_option('zwsc_email_required', 'enabled', '', 'yes');
    add_option('zwsc_email_label', 'Email', '', 'yes');

    add_option('zwsc_phone_visibility', '', '', 'yes');
    add_option('zwsc_phone_required', '', '', 'yes');
    add_option('zwsc_phone_label', 'Phone', '', 'yes');

    add_option('zwsc_website_visibility', '', '', 'yes');
    add_option('zwsc_website_required', '', '', 'yes');
    add_option('zwsc_website_label', 'Website', '', 'yes');

    add_option('zwsc_subject_visibility', 'enabled', '', 'yes');
    add_option('zwsc_subject_required', 'enabled', '', 'yes');
    add_option('zwsc_subject_label', 'Subject', '', 'yes');

    add_option('zwsc_message_visibility', 'enabled', '', 'yes');
    add_option('zwsc_message_required', 'enabled', '', 'yes');
    add_option('zwsc_message_label', 'Message', '', 'yes');
}
