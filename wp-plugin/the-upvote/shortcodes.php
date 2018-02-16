<?php
namespace upvote\shortcodes;

function uv_container($atts, $content = null) {
    $shortcodeContent = do_shortcode($content);
    return "
    <div class='container-fluid'>
        <div class='row'>
            $shortcodeContent
        </div>
    </div>";
}

function uv_video($atts, $content = null) {
    $shortcodeContent = do_shortcode($content);
    return "<div class='col-lg-8'>$shortcodeContent</div>";
}

function uv_list($atts, $content = null) {
    $shortcodeContent = do_shortcode($content);
    return "<div class='col-lg'>$shortcodeContent</div>";
}
?>
