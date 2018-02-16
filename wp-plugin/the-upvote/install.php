<?php
/*
Plugin Name: The Upvote - Post Format Helper
Description: Provides a collection of shortcodes to format posts for The Upvote.
Author: Anthony Scire
*/

namespace upvote\install;

function register_hooks() {
    require_once('shortcodes.php');
    add_shortcode('uv-container', 'upvote\\shortcodes\\uv_container');
    add_shortcode('uv-video', 'upvote\\shortcodes\\uv_video');
    add_shortcode('uv-list', 'upvote\\shortcodes\\uv_list');
}

register_hooks();
?>
