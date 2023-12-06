<?php
declare(strict_types=1);


namespace App\Core;


class Helper
{
    public static function dd($some)
    {
        echo '<pre>';
        print_r($some);
        echo '</pre>';
    }

    public static function goUrl(string $url)
    {
        echo '<script type="text/javascript">location="';
        echo $url;
        echo '";</script>';
    }

    public static function sanitize($input)
    {
        $allowedTags = "<br><p><a><strong><b><i><em><img><blockquote><code><dd><dl><hr><h1><h2><h3><h4><h5><h6><label><ul><li><span><sub><sup>";
        return is_string($input) ? strip_tags($input, $allowedTags) : $input;
    }
}