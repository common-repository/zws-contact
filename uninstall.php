<?php

if (!defined('ABSPATH') && !defined('WP_UNINSTALL_PLUGIN'))
    exit(); // Exit if accessed directly

global $wpdb;
$table_name = $wpdb->prefix . 'zws_contact';
$wpdb->query("DROP TABLE IF EXISTS $table_name");

delete_option('zwsc_name_visibility');
delete_option('zwsc_name_required');
delete_option('zwsc_name_label');

delete_option('zwsc_email_visibility');
delete_option('zwsc_email_required');
delete_option('zwsc_email_label');

delete_option('zwsc_phone_visibility');
delete_option('zwsc_phone_required');
delete_option('zwsc_phone_label');

delete_option('zwsc_website_visibility');
delete_option('zwsc_website_required');
delete_option('zwsc_website_label');

delete_option('zwsc_subject_visibility');
delete_option('zwsc_subject_required');
delete_option('zwsc_subject_label');

delete_option('zwsc_message_visibility');
delete_option('zwsc_message_required');
delete_option('zwsc_message_label');
