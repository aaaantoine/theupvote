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

class YouTubeUtils
{
    /**
     * Gets video code from the end of a URL path
     */
    private static function get_embed_code($url) {
        $noQueryString = explode("?", $url)[0];
        $explodedPath = explode("/", $noQueryString);
        $code = end($explodedPath);
        return $code;
    }

    /**
     * Gets video code from the v=____ querystring variable
     */
    private static function get_watch_code($url) {
        $query = explode("&", parse_url($url)['query']);
        foreach ($query as $single) {
            $parts = explode("=", $single);
            if ($parts[0] == "v") {
                return $parts[1];
            }
        }

        // v= not found.
        return null;
    }

    private static function get_code($url) {
        return strpos($url, "watch") !== false
            ? self::get_watch_code($url)
            : self::get_embed_code($url);
    }

    private static function make_url($url) {
        $code = self::get_code($url);
        if ($code == null) {
            return null;
        }

        return "https://www.youtube.com/embed/$code";
    }

    private static function remove_shortcodes($content) {
        return str_replace("[embedyt]", "",
                str_replace("[/embedyt]", "", $content));
    }

    public static function embed($content) {
        $content = self::remove_shortcodes($content);
        $url = self::make_url($content);
        if ($url == null) {
            return "<div>
                        <strong>uv_video:</strong>
                        Not a valid YouTube URL or video code.
                    </div>";
        }
        return "<div class='embed-responsive embed-responsive-16by9'>
                    <iframe class='embed-responsive-item'
                        src='$url'
                        allow='autoplay; encrypted-media'
                        allowfullscreen></iframe>
                </div>";
    }
}

function uv_video($atts, $content = null) {
    $youtube = YouTubeUtils::embed($content);
    return "<div class='col-lg-8'>$youtube</div>";
}

function uv_list($atts, $content = null) {
    $shortcodeContent = do_shortcode($content);
    return "<div class='col-lg'>$shortcodeContent</div>";
}
?>
