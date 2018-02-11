<?php
/*
Plugin Name: The Upvote
Description: Manage episodes and topics and provide voting functionality for The Upvote.
Author: Anthony Scire
*/

namespace upvote\install;

function install() {
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    global $wpdb;
    
    $charset_collate = $wpdb->get_charset_collate();
    $sqlCommands = Array(
        sql_create_uv_episode($wpdb, $charset_collate),
        sql_create_uv_topic($wpdb, $charset_collate),
        sql_create_uv_vote($wpdb, $charset_collate),
        sql_create_uv_voter($wpdb, $charset_collate)
    );
    foreach($sqlCommands as $sqlCommand) {
        dbDelta($sqlCommand);
    }
}

function sql_create_uv_episode($wpdb, $charset_collate) {
    $table_name = $wpdb->prefix . 'uv_episode';
    $columns =
       "title           VARCHAR(250)  NOT NULL,
        video_code      VARCHAR(20)   NOT NULL,
        air_date        DATETIME,
        expiration_date DATETIME,";
    return sql_create_meta($table_name, $columns, $charset_collate);
}

function sql_create_uv_topic($wpdb, $charset_collate) {
    $table_name = $wpdb->prefix . 'uv_topic';
    $columns =
       "title           VARCHAR(250)  NOT NULL,
        uv_episode_id   BIGINT(20)    NOT NULL,";
    return sql_create_meta($table_name, $columns, $charset_collate);
}

function sql_create_uv_vote($wpdb, $charset_collate) {
    $table_name = $wpdb->prefix . 'uv_vote';
    $columns =
       "uv_topic_id     BIGINT(20)    NOT NULL,
        is_upvote       TINYINT(2)    NOT NULL,
        uv_voter_id     BIGINT(20)    NOT NULL,";
    return sql_create_meta($table_name, $columns, $charset_collate);
}

function sql_create_uv_voter($wpdb, $charset_collate) {
    $table_name = $wpdb->prefix . 'uv_voter';
    $columns =
       "signature       VARCHAR(64)   NOT NULL,
        ip_address      VARCHAR(40)   NOT NULL,
        user_agent      VARCHAR(1024) NOT NULL,";
    return sql_create_meta($table_name, $columns, $charset_collate);
}

function sql_create_meta($table_name, $columns, $charset_collate) {
    $sql = "CREATE TABLE $table_name (
        id              BIGINT(20)    NOT NULL AUTO_INCREMENT,
        $columns                    
        is_active       BOOLEAN       NOT NULL DEFAULT 1,
        create_date     DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
        create_user_id  BIGINT(20), 
        update_date     DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        update_user_id  BIGINT(20),
        PRIMARY KEY  (id)
    ) $charset_collate;";
    return $sql;
}

function register_hooks() {
    register_activation_hook(__FILE__, 'upvote\\install\\install');
}

register_hooks();
?>
