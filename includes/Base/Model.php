<?php
/**
 * @package  Flexity
 */
namespace Inc\Base;

use Config\Config;

class Model
{
    public static function insertPodcast($post_id, $podcast, $wpdb, $image_path)
    {
//        var_dump($podcast);exit();
        $data = array(
            'post_id' => $post_id,
            'track_id' => $podcast['id'],
            'track_name' => $podcast['name'],
            'track_href' => $podcast['href'],
            'track_uri' => $podcast['uri'],
            'track_duration_ms' => $podcast['duration_ms'],
            'track_release_date' => $podcast['album']['release_date'],
            'album_image' => $image_path,
            'artist_name' => $podcast['album']['artists'][0]['name'],
        );
        $format = array( '%s' ,'%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');
        $result = $wpdb->insert( Config::TABLE_WP_FX_PODCASTS, $data, $format );
        if ($result){
            return $result;
        }
    }
}