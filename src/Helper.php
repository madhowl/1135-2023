<?php
declare(strict_types=1);


namespace App;


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
}