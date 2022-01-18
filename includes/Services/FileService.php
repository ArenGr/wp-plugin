<?php
namespace Inc\Services;
use Config\Config;
use Http\Client\Exception;

class FileService
{
    public static function savePodcastImage($url, $size, $new_name) {
        $image_path = self::generatePodcastImagePath($size, $new_name);
        $image_abs_path = plugin_dir_path( dirname( __FILE__, 2 ) ).$image_path['path'];

        try {
            $content = file_get_contents($url);
            file_put_contents($image_abs_path, $content);
            return $image_path['name'];
        }catch (Exception $exception){
            var_dump($exception);
        }
    }

    public static function generatePodcastImagePath($size, $new_name) {
        $name = $new_name.'.jpg';
        $dir = Config::FX_PODCAST_IMAGES_DIR;
        $path = $dir.$size.'x'.$size.'/'.$name;
        return array('path' => $path, 'name' => $name);
    }
}