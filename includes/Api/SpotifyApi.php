<?php
/**
 * @package  Flexity
 */
namespace Inc\Api;
use Config\Config;

class SpotifyApi
{
    public static $access_token;

    public static function getAccessToken() {
        $client_id = Config::SPOTIFY_CLIENT_ID_PREM;
        $client_secret = Config::SPOTIFY_CLIENT_SECRET_PREM;
        $spotify_api_get_token_endpoint = Config::SPOTIFY_API_GET_TOKEN_ENDPOINT;

        $signature = base64_encode($client_id.':'.$client_secret);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $spotify_api_get_token_endpoint);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Basic '.$signature,
        ));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'grant_type=client_credentials'
        );

        if (curl_errno($ch))
            $error_msg = curl_error($ch);

        $output = curl_exec($ch);
        curl_close($ch);

        if (isset($error_msg)) {
            echo $error_msg;
            return false;
        }

        self::$access_token = json_decode($output, true)['access_token'];
        return self::$access_token;
    }

    public static function getTrackById($track_id) {
        self::getAccessToken();
        $spotify_api_get_track_endpoint = Config::SPOTIFY_API_GET_TRACK_ENDPOINT.$track_id;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $spotify_api_get_track_endpoint);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer '.self::$access_token,
        ));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

        if (curl_errno($ch))
            $error_msg = curl_error($ch);

        $output = curl_exec($ch);
        $output = json_decode($output, true);
        curl_close($ch);
        if (isset($error_msg)) {
            echo $error_msg;
            return false;
        }
        return $output;
    }
}